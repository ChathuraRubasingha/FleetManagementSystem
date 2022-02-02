<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" type="image/x-icon" />

        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/zebra.css" type="text/css">
<link rel="stylesheet" href="css/responsive.css" type="text/css" media="screen">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">

        <!--fancybox styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/fancy/jquery.fancybox.css?v=2.1.5" />




        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/fancy/jquery.fancybox.js?v=2.1.5');
        ?>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    </head>

    <body>
        <style>
            
            #page{
                margin-bottom: 0px !important;
            }
            
            input[type="submit"]:hover
            {
                border:1px solid #0099FF !important;

            }

        </style>

<?php

    if (Yii::app()->user->hasFlash('success')) {

        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'options' => array(
                'show' => 'explod',
                'hide' => 'explode',
                'modal' => 'true',
                /*    'title' => 'rtgdf', */
                'autoOpen' => true,
                'buttons' => array(
                    'OK' => 'js:function(){$(this).dialog("close");}',),),));
        printf('<span class="dialog">%s</span>', Yii::app()->user->getFlash('success'));
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    }
?>

        <header>
    <div class="fancyNav">
        <h3>Fleet Management System</h3>
    </div>
<div class="subheader clearfix">
    <div class="inner-subheader">

        <div class="subheader2" style="float:right; min-height: 30px;">



        </div>



    </div>

</div>





<!-- Navigation -->

</header>

        <div class="container" id="page">
            
                <?php echo $content; ?>
            
            <div class="clear"></div>

            



        </div>
        <footer>
    <div class="inner-footer dark">





    </div>
    <!-- End inner Footer -->


</footer>

    </body>
</html>
