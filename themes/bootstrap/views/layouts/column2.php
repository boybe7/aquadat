<?php /* @var $this Controller */ 
Yii::app()->bootstrap->init();
?>
<?php $this->beginContent('//layouts/main'); ?>
<script type="text/javascript">
    $(function() {

         $('.tree-toggle').click(function () {
        
            $(this).parent().children('ul.tree').toggle(200);
        });
    });

   
</script>

<style type="text/css">
    .nav-header {
        font-size: 16px;
    }
</style>
<br><br>
<?php

if(!Yii::app()->user->isGuest)
{

?>
<div class="row">
   
    <div class="span3">
      <div class="well">
        <div>
            <ul class="nav nav-list">
        <?php
          
                    echo  '<li><label class="tree-toggle nav-header" style="color:black">บันทึก</label>';
                    echo  '<ul class="nav nav-list tree">';
                  
                        echo '<li>'.CHtml::link('บันทึกข้อมูล','PointValueTb/index').'</li>';
                       
                    echo '</ul>';
                    echo '</li>';
                    echo  '<li><label class="tree-toggle nav-header" style="color:black">รายงาน</label>';
                    echo  '<ul class="nav nav-list tree">';
                  
                      
                        echo '<li>'.CHtml::link('รายงานผลการวิเคราะห์คุณภาพน้ำระบบผลิตประจำผลัด','report/dailyReport').'</li>';
                        echo '<li>'.CHtml::link('รายงานผลการวิเคราะห์คุณภาพน้ำระบายออกนอกโรงงาน','report/drainReport').'</li>';
                  
                    echo '</ul>';
         
           
        ?>
            </ul>
        </div>
      </div><!-- well -->

   

   
    </div>


     <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php 
}
?>

<?php $this->endContent(); ?>


