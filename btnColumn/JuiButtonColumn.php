<?php
Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * Can use CdeleteJuiDialog for confirmation message
 */
class JuiButtonColumn extends CButtonColumn
{
	/**
	* @var array Definition for the JUI Dialog. The same as CJuiDialog except that
	* ['options']['buttons'] is an array whose first element is the string for the
	* delete button, and the second the string of the cancel button and defaults
	* to array('Delete', 'Cancel')
	*/
	public $deleteJuiDialog;
	private $_csrf = '';
	 
	/**
	 * Initializes the default buttons (view, update and delete).
	 */
	protected function initDefaultButtons()
	{
		if($this->viewButtonLabel===null)
			$this->viewButtonLabel=Yii::t('zii','View');
		if($this->updateButtonLabel===null)
			$this->updateButtonLabel=Yii::t('zii','Update');
		if($this->deleteButtonLabel===null)
			$this->deleteButtonLabel=Yii::t('zii','Delete');
		if($this->viewButtonImageUrl===null)
			$this->viewButtonImageUrl=$this->grid->baseScriptUrl.'/view.png';
		if($this->updateButtonImageUrl===null)
			$this->updateButtonImageUrl=$this->grid->baseScriptUrl.'/update.png';
		if($this->deleteButtonImageUrl===null)
			$this->deleteButtonImageUrl=$this->grid->baseScriptUrl.'/delete.png';
		if($this->deleteConfirmation===null)
			$this->deleteConfirmation=Yii::t('zii','Are you sure you want to delete this item?');

		foreach(array('view','update','delete') as $id)
		{
			$button=array(
				'label'=>$this->{$id.'ButtonLabel'},
				'url'=>$this->{$id.'ButtonUrl'},
				'imageUrl'=>$this->{$id.'ButtonImageUrl'},
				'options'=>$this->{$id.'ButtonOptions'},
			);
			if(isset($this->buttons[$id]))
				$this->buttons[$id]=array_merge($button,$this->buttons[$id]);
			else
				$this->buttons[$id]=$button;
		}

		if(is_string($this->deleteConfirmation)&&empty($this->deleteJuiDialog))
			$confirmation="if(!confirm(".CJavaScript::encode($this->deleteConfirmation).")) return false;";
		else
			$confirmation='';

		if(Yii::app()->request->enableCsrfValidation)
		{
	        $csrfTokenName = Yii::app()->request->csrfTokenName;
	        $csrfToken = Yii::app()->request->csrfToken;
	        // csrf now private class property
	        $this->_csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
		}

		// Honour a custom click definition for delete
		if(!isset($this->buttons['delete']['click'])) {
			// If not using JUI Dialog the same as CButtonColumn except to use class properrty for csrf
			if(empty($this->deleteJuiDialog))
				$this->buttons['delete']['click']=<<<EOD
function() {
	$confirmation
	$.fn.yiiGridView.update('{$this->grid->id}', {
		type:'POST',
		url:$(this).attr('href'),{$this->_csrf}
		success:function() {
			$.fn.yiiGridView.update('{$this->grid->id}');
		}
	});
	return false;
}
EOD;
		// If using JUI Dialog:
		// store the URL in the dialog, set the HTML content, and open it
		else
			$this->buttons['delete']['click']=<<<EOD
function() {	
	jQuery('#{$this->deleteJuiDialog['id']}-{$this->grid->id}').data('url', $(this).attr('href')).html('{$this->deleteConfirmation}').dialog("open");
	return false;
}
EOD;
		}
	}

	/**
	 * Registers the client scripts for the button column.
	 */
	protected function registerClientScript()
	{
		$js=array();
		foreach($this->buttons as $id=>$button)
		{
			if(isset($button['click']))
			{
				$function=CJavaScript::encode($button['click']);
				$class=preg_replace('/\s+/','.',$button['options']['class']);
				$js[]="jQuery('#{$this->grid->id} a.{$class}').live('click',$function);";
			}
		}
		
		// Start JUI Dialog
		if(isset($this->deleteJuiDialog)) {
			$tagname = (isset($this->deleteJuiDialog['tagname'])?$this->deleteJuiDialog['tagname']:'div');
			
			// Define default options
			$deleteJuiDialogOptions = array(
				'title'=>'Confirm Delete',
				'autoOpen'=>false,
				'dialogClass'=>'alert',
				'height'=>200,
				'width'=>480,
				'modal'=>true,
				'buttons'=>array('Delete','Cancel')
			);
			
			// Use user defined options where set
			if(isset($this->deleteJuiDialog['options'])) {
				array_merge($deleteJuiDialogOptions, $this->deleteJuiDialog['options']);
				unset($this->deleteJuiDialog['options']);
			}
			
			// Get the buttons as they aren't JS
			$buttons = $deleteJuiDialogOptions['buttons'];
			unset($deleteJuiDialogOptions['buttons']);
			
			// Do the JS
			// Combine dialog id with grid id to ensure uniqueness if multiple instances
			// of CGridView
			$id = $this->deleteJuiDialog['id'].'-'.$this->grid->id;
			unset($this->deleteJuiDialog['id']);
			$js[]="jQuery('body').append(".CJavaScript::encode(CHtml::tag($tagname, array('id'=>$id))).");";
			$js[]="jQuery('#{$id}').dialog(".CJavaScript::encode($deleteJuiDialogOptions).");";			
			$js[]=<<<EOD
jQuery('#{$id}').bind('dialogopen', function(event, ui) {
	jQuery(this).dialog("option","buttons",{
		{$buttons[0]}: function() {
			$(this).dialog("close");
			$.fn.yiiGridView.update('{$this->grid->id}', {
				type:'POST',
				url:jQuery(this).data('url'),{$this->_csrf}
				success:function() {
					$.fn.yiiGridView.update('{$this->grid->id}');
				}
			});
			return false;
		},
		{$buttons[1]}: function() {
			$(this).dialog("close");
			return false;
		}
	});
});
EOD;
			// Need to make CJuiWidget a concrete class
			// Just used to initialise JIU scripts, etc		
			$this->grid->owner->widget('zii.widgets.jui.CJuiWidget', $this->deleteJuiDialog);
		}
		// End JUI Dialog

		if($js!==array())
			Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, implode("\n",$js));
	}
}