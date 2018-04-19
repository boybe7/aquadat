<?php

/***
************************************
Program ID : LOG_02
Create By : Atitep
Create Date :
*********** Change Logs ************
Update By :
Update Date :
Update Detail :
----------- Unit Test --------------
     No.                 Result
1.Test 1
2.Test 2
3.Test 3
************************************
/* @var $this SiteController */


$this->pageTitle=Yii::app()->name;

$theme = Yii::app()->theme;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile( $theme->getBaseUrl() . '/js/highcharts.js' );
//$cs->registerCssFile($theme->getBaseUrl() . '/css/ProgressTracker.css');

?>
<div class="hero-unit">
  <h3>ยินดีต้อนรับเข้าสู่</h3>
  <h2><?php echo Yii::app()->name; ?></h2>
  <p></p>
  <p>
  <?php
      
       echo '<a class="btn btn-primary btn-large" href="">';
    
  
  ?>
       <span class="icon-book white" aria-hidden="true"></span>  คู่มือการใช้งาน
    </a>
  </p>
</div>


<div id="modal-content" class="hide">
    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	
   

    	?>
    </div>
</div>


