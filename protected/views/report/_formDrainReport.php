
<style type="text/css">
.table-fixed thead {
  width: 100%;

}

.table-fixed tbody {
  height: 600px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td {
  float: left;
  border-bottom-width: 0;
  border-style: solid;
  border-width: thin;
  border-color: #e3e3e3;
  }

.table-fixed thead > tr> th {
  float: left;
  text-align: center;

  background-color: #f5f5f5;

}


</style>


<?php
        $month_th = array("01"=>"มกราคม","02"=>"กุมภาพันธ์" ,"03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
        $month = $month_th[$month];
?>

<center><h4>รายงานผลการวิเคราะห์คุณภาพน้ำระบายออกนอกโรงงาน  ฝ่ายโรงงานผลิตน้ำบางเขน เดือน <?php echo $month." ".$year; ?></h4></center>

<?php

function displayDate($date)
{
  $str = explode("-", $date);
  return $str[2]."/".$str[1]."/".$str[0];
}


// $sql = "SELECT * FROM requests rq LEFT JOIN invoices i ON rq.id=i.request_id  WHERE  rq.date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
// $result = Yii::app()->db->createCommand($sql)->queryAll();

?>

  <table class="table  table-bordered table-condensed" >
     <thead>
      <tr>
        <th rowspan=2 style="vertical-align:center;text-align:center;width:25%;">วัน</th>
        <th colspan=3 style="text-align:center;width:45%">ความขุ่นน้ำระบายออกนอกโรงงาน (NTU)</th>
        <th colspan=2 style="text-align:center;width:30%">ความขุ่นน้ำนำกลับ (NTU)</th>      
      </tr>
      <tr>
        <th style="text-align:center;width:15%">00.00 น.</th>
        <th style="text-align:center;width:15%">10.00 น.</th>
        <th style="text-align:center;width:15%">16.00 น.</th> 

        <th style="text-align:center;width:15%">10.00 น.</th>
        <th style="text-align:center;width:15%">หมายเหตุ</th>     
      </tr>
    </thead>
    <tbody>
          <?php
             

            ?>


    </tbody>
  </table>



