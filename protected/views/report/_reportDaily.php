<?php
$this->breadcrumbs=array(
	'รายงาน',
	 //----ไม่ต้องแก้-----
);


?>

<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}

</style>
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdfobject.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdf.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/compatibility.js"></script> -->


<h4>รายงานผลการวิเคราะห์คุณภาพน้ำระบบผลิตประจำผลัด</h4>

<div class="well">
  <div class="row-fluid">
  <div class="span3">
               
              <?php
                echo CHtml::label('วันที่','date');  
                echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                        array(
                            'name' => 'date',
                            'attribute' => 'date',
                            'options' => array(
                                'mode' => 'focus',
                                //'language' => 'th',
                                'format' => 'yyyy-mm-dd', //กำหนด date Format
                                'showAnim' => 'slideDown',
                            ),
                            'htmlOptions' => array('class' => 'span12'), // ใส่ค่าเดิม ในเหตุการ Update
                        )
                );
                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
              ?>
    </div>
    <div class="span2">
            <?php
                
                echo CHtml::label('ผลัด','shift');  
                $list = array("00.00-08.00"=>"00.00-08.00","08.00-16.00"=>"08.00-16.00","16.00-24.00"=>"16.00-24.00");
                echo CHtml::dropDownList('shift', '',$list,array('class'=>'span12'));

              ?>
    </div>
      <div class="span2 ">
<?php
          

            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'type' => 'success',
                'label' => 'ออกรายงาน',
                'icon' => 'excel white',
                'htmlOptions' => array(
                    'class' => 'span12',
                    'style' => 'margin:25px 0px 0px 0px;',
                    'id' => 'gentReport'
                ),
            ));
            ?>

        </div>
  
  </div>


    
</div>


<div id="printcontent" style=""></div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();
    window.location.href = "GenDailyReport?date="+$("#date").val()+"&shift="+$("#shift").val();
   
    
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();

    $.ajax({
        url: "printMonthlyReport",
        data: {monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val()
              },
        success:function(response){
            window.open("../print/tempReport.pdf", "_blank", "fullscreen=yes");

        }

    });

});
', CClientScript::POS_END);




?>