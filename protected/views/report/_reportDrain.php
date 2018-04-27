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


<h4>รายงานผลการวิเคราะห์คุณภาพน้ำระบายออกนอกโรงงาน</h4>

<div class="well">
  <div class="row-fluid">
  <div class="span3">
               
              <?php
                 echo CHtml::label('ณ เดือน','month');  
                 $list = array("01" => "ม.ค.", "02" => "ก.พ.", "03" => "มี.ค.","04" => "เม.ย.", "05" => "พ.ค.", "06" => "มิ.ย.","07" => "ก.ค.", "08" => "ส.ค.", "09" => "ก.ย.","10" => "ต.ค.", "11" => "พ.ย.", "12" => "ธ.ค.");
                 $mm = date("m");
                 echo CHtml::dropDownList('month', '', 
                         $list,array('class'=>'span12',"options"=>array($mm=>array("selected"=>true))
                     ));
              ?>
    </div>
    <div class="span2">
            <?php
               echo CHtml::label('ปี','year');  
               $yy = date("Y")+543;
               $list = array($yy-4=>$yy-4,$yy-3=>$yy-3,$yy-2=>$yy-2,$yy-1=>$yy-1,$yy=>$yy);
               echo CHtml::dropDownList('year', '', 
                       $list,array('class'=>'span12',"options"=>array($yy=>array("selected"=>true))
                 
                   ));
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

       
        $.ajax({
            url: "GenDrainReport",
            cache:false,
            data: {month:$("#month").val(),year:$("#year").val()},
            success:function(response){
               
               $("#printcontent").html(response);                 
            }

        });
    
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