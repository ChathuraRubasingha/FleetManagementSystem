


<style>
    #checkall
    {
        width:20px;
    }
    .checkBox
    {
        width:20px;
    }
    
    .checkBoxLabel
    {
        width:200px;
    }
    
    .dbHeader
    {
        font-size:17px; 
        font-weight:bold; 
        text-align:left;
        padding-bottom: 20px;
    }
    
    .dbTable
    {
        margin-left:20%;
    }
    .dbTable td
    {
        padding-bottom: 4px;
        padding-left: 10px;
        
    }
    
    .dbGroupIndicator
    {
        font-size: 15px;
        font-weight: bold;
        padding-left: 0px !important;
        padding-top: 15px !important;
    }
</style>

<div class="form">
<script type="text/javascript">
    
  function checkedAll () 
  {
      var checkallValue = $("#checkall").attr("checked");

      if(checkallValue == "checked")
      {
          $('input[type=checkbox]').attr("checked", "checked");
      }
      else
      {
          $('input[type=checkbox]').removeAttr("checked");
      }

}
</script>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dashboard-permission-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>
<?php
$getDashBoardPermissionArray = array();
$id = Yii::app()->request->getQuery('id');
if(isset($id))
{
    $roleArr = Role::model()->findAll("Role_ID=$id");
    if(count($roleArr)>0)
    {
        $role = $roleArr[0]['Role'];
        echo "<h3 style='text-align:center; margin-bottom:30px;margin-top:50px; text-decoration:underline'>Role : $role</h3>";
    }
}
// get Dashboard groups
$dashboardGroups = DashboardItems::model()->getDashboardGroups();
$groupsCount = count($dashboardGroups);
echo "<table class='dbTable'>
    <tr>
        <td/>
        <td/>
        <td><label for='checkall'>Select/Unselect All</label>
            <input type='checkbox' name='checkall' id='checkall' onclick='checkedAll();'></td>
    </tr>
    ";

echo "<tr>
        <th class='dbHeader'>Dashboard Item</th>
        <th class='dbHeader'>Permission (Show/Hide)</th>
        <th/>
    </tr>";

if($groupsCount>0)
{
    for($i=0; $i<$groupsCount; $i++)
    {
        $groupID = $dashboardGroups[$i]['Dashboard_Group_ID'];
        $groupName = $dashboardGroups[$i]['Display_Order'];
        // get dashboard items
        $dashboardItems = DashboardItems::model()->getDashboardItems($id, $groupID,'0');
        
        $itemsCount = count($dashboardItems);
        if($itemsCount >0)
        {
            echo "<tr>
                    <td class='dbGroupIndicator'>$groupName </td>
                    <td/>
                    <td/>  
                    </tr>";
            $ddd='';
            for($j=0; $j<$itemsCount; $j++)
            {
                $itemName = $dashboardItems[$j]['Display_Name'];
                $itemID = $dashboardItems[$j]['Dashboard_Item_ID'];
                $selected = null;
                if(isset($id))
                {   
                    $getDashBoardPermissionArray = $model->getDashboardPermissionArray($id,$itemID);
                    $countArray = count($getDashBoardPermissionArray);
                    if($countArray>0)
                    {
                        $selected = 'checked';
                    }
                }
                echo "<tr>
                        <td><label for='id_$itemID'>$itemName</label></td>
                        <td align='right'>".CHtml::checkBox("ids[]",$selected,array("value"=>"id_$itemID", "class"=>"checkBox", "id"=>"id_$itemID"))."</td>
                        <td></td>
                    </tr>";
            }
            //echo $ddd;exit;
            echo '</ol>
                </div>';
        }
    }
}


echo "    
    <tr>
         <td></td>
         <td></td>
         <td>". CHtml::submitButton($model->isNewRecord ? 'Apply Permision' : 'Apply Permision', array('style'=>"width:120px" ))."</td>
     </tr>

</table>";


$this->endWidget(); ?>

</div><!-- form -->