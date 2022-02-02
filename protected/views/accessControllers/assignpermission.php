<style>
    #table td, th
    {
        border: 1px solid #ccc;
        padding: 8px;
    }
</style>
<?php
Yii::app()->clientScript->registerScript('search',
    "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#AccessControllers_Action').keyup(function(){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
// this is the id of the CListView
                'ajaxListView',
                {data: ajaxRequest}
            )
        },
// this is the delay
        300);
    });
	
	 $('.ajax_link').click(function(){
  $.fn.yiiListView.update('companyList')
 });
	
	"
);?>


<script type="text/javascript">

    $(document).ready(function(){

        $("#AccessControllers_Display_Name").change(function(){
            var materialId = $("#AccessControllers_Display_Name").val();
            var rollId = $("#Role_Role_ID").val();
            
            if(materialId !=="" && rollId !=="")
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("AccessControllers/ActionsTable"); ?>',
                    data: {'materialId':materialId,'rollId':rollId},
                    success:function(data){
                        var hasData = data.indexOf("input");
                       if(hasData >0)
                       {
                            $("#table").show();
                            $("#table").html(data);
                            $("#checkAllRow").show();
                            $("#assignBtn").show();
                        }
                    },
                    error: function(data) { // if error occured
                        alert("Error occured.please try again");
                        //alert(data);
                        //alert(RateId);
                    },
                    dataType:'html'
                });
             }
             else
            {
                $("#checkAllRow").hide();
                $("#assignBtn").hide();
                $("#table").hide();
            }
        });
        
        
        $("#Role_Role_ID").change(function(){
            var materialId = $("#AccessControllers_Display_Name").val();
            var rollId = $("#Role_Role_ID").val();
            if(materialId !=="" && rollId !=="")
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("AccessControllers/ActionsTable"); ?>',
                    data: {'materialId':materialId,'rollId':rollId},
                    success:function(data){
                        //$.fn.yiiGridView.update('access-control-actions-grid');
                       var hasData = data.indexOf("input");
                       if(hasData >0)
                       {
                            $("#table").show();
                           $("#table").html(data);
                           $("#checkAllRow").show();
                           $("#assignBtn").show();
                       }
                    },
                    error: function(data) { // if error occured
                        alert("Error occured.please try again");
                        //alert(data);
                        //alert(RateId);
                    },
                    dataType:'html'
                });
            }
            else
            {
                $("#checkAllRow").hide();
                $("#assignBtn").hide();
                $("#table").hide();
            }
        });

    });

</script>


<script type="text/javascript">
    function checkAll () {

        var checkallValue = $("#checkall").attr("checked");

        if(checkallValue === "checked")
        {
            $('input[type=checkbox]').attr("checked", "checked");
        }
        else
        {
            $('input[type=checkbox]').removeAttr("checked");
        }

    }
</script>


<script type="text/javascript">


    $(document).ready(function(){

        $("#Role_Role_ID").change(function(){

           /* var checkallValue = $("#checkall").attr("checked");

            if(checkBoxValues == "checked")
            {
                $("#checkall").attr("checked", "checked");
            }

            */

        });

    });

</script>



<?php

?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Access'=>array('accessPermission/accesscontrol'),
                        'Access Permission',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name">Assign Permission for Modules</h1></center>
                    </div>

                    <div class="panel-body">

                        <div style="width: 760px !important">
                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'ma-user-form',
                                'enableAjaxValidation'=>false,
                            )); ?>
                            <table style="width: 100%!important; margin-left:4px">



                                   <tr>
                                       <td  style="width:45px"><?php echo $form->labelEx($modelrole,'Role'); ?></td>
                                       <td><?php     echo $form->dropDownList($modelrole, 'Role_ID', CHtml::listData(
                                                 role::model()->findAll(), 'Role_ID', 'Role'),array('prompt' => '--- Please Select ---'));   ?>
                                           <?php echo $form->error($modelrole,'Role_ID'); ?></td>

                                       <td><?php echo $form->labelEx($model,'Controller_Name'); ?></td>
                                       <td><?php echo $form->dropdownlist($model,'Display_Name',CHtml::listData(AccessControllers::model()->getControllerName(),'Main_Module','Main_Module'),array('width'=> '25', 'empty'=>'--- Please Select ---'));  ?>
                                           <?php echo $form->error($model,'Controller_Name'); ?></td>
                                       
                                   </tr>



                                   <tr style="width:50px"/>
                                    <tr id="checkAllRow" style="display: none">
                                        <td/>
                                        <td/>
                                        <td/>
                                        
                                        <td style="text-align: left; padding-top: 30px;"> <label for="checkall">Select/Unselect All</label><input type='checkbox' name='checkall' style="width:20px" id='checkall' onclick='checkAll();'></td>

                                    </tr>

                                    <tr><td colspan="5">

                                            <div align="center" class="as" id="table" style="margin-top:1px; width:auto">



                                            </div>
                                        </td>
                                    </tr>
                                <tr id="assignBtn" style="display: none">
                                    <td/>
                                    <td/>

                                    <td> </td>
                                    <td style="padding-left:13%;font-weight:bold"> <?php echo CHtml::submitButton($model->isNewRecord ? 'Assign Permission' : 'Save', array("style"=>'width:130px !important')); ?></td>

                                </tr>
                                </table><?php $this->endWidget(); ?>
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