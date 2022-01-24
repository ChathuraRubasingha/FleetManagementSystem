<?php
$id = Yii::app()->request->getQuery('id');


if(!isset($id))
{
    $id=0;
}
///var_dump($getDashBoardPermissionArray);exit;
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('dashboard-permission-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<script>
    $(document).ready(function()
    {
        var roleID = '<?php echo $id; ?>';
       
        if(roleID !='0')
        {
            $('.group').show();
           
        }
        
    });
</script>
    




<?php $userRole = Yii::app()->getModule('user')->user()->Role_ID;?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if($userRole !=='3')
                    {
                        
                    $this->breadcrumbs=array(
                        'Dashboard'=>array('dashboard/index'),
                        'Dashboard Permission',
                    );
                   
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Role to Manage Dashboard Permissions</h1>
                       
                    </div>

                    

                       

                    
                </div>

                <div class="panel panel-default">


                    <div class="panel-body">


                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'dashboard-permission-grid',
                            'dataProvider'=>  Role::model()->search(),
                            //'filter'=>$model,
                            'columns'=>array(
                                'Role_ID',
                                array('name'=>'Role_ID', 'header'=>'User Role', 'value'=>'$data->Role'),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Role',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>' Yii::app()->createUrl("/dashboardPermission/admin",  array("id" =>$data["Role_ID"],"menuId"=>"configuration"))',))
                                     ),
                                
                                ),
                        )); ?>

                        <div class="group" style="display:none">

                            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
                        </div>
                    </div>
                </div>




            </div>
            <div class="col-xs-4">

<div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php
                            echo MaVehicleRegistry::model()->menuarray('Access');

                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>


                

            </div>
        </div>

    </div>
</div>