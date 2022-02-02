<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Accsess';



?>

<?php if($code == "403")
{
    $url = Yii::app()->request->Url;
    $isAddNew= strpos($url,'AddNew');
    //echo strpos($url,'AddNew');exit;
    if(strpos($url,'AddNew'))
    {   
       $this->layout = 'fancy_box_layout';
        echo '<img width="210px" height="195px" style="margin-left:155px" src="images/AccsessDenied.png">';
    }
    else
    { 
        echo '<img src="images/AccsessDenied.png" width="250px" height="250px" style="margin:100px 530px"/>';
   
       // echo '<div  style="background-image:url(images/AccsessDenied.png);height:400px;width:400px;background-repeat:no-repeat;margin-left:500px;margin-top:50px"> </div>';

        
    }
?>
   
<?php } else if($code == "404"){ ?>

    <?php


    $url = str_replace('/Fleet/index.php?r=role/','',str_replace('/Fleet/index.php?r=user/','',Yii::app()->request->requestUri));
    $this->renderPartial('//'.$url); ?>

<?php } else {?>

    <h2>Error <?php echo $code; ?></h2>

    <div class="error">
        <?php echo CHtml::encode($message); ?>
    </div>

<?php } ?>