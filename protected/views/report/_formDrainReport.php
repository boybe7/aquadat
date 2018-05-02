
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

.table tfoot > tr> td {
  text-align: center;
  background-color: rgba(171, 168, 168, 0.25);
}

.table td {
  text-align : center;
}


</style>


<?php
        $days_in_month = cal_days_in_month(CAL_GREGORIAN,intval($month),$year-543);
        //echo $days_in_month;
        $month_int = $month;  
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
             $min_point1_00 = 999;
             $max_point1_00 = 0;
             $min_point1_10 = 999;
             $max_point1_10 = 0;
             $min_point1_16 = 999;
             $max_point1_16 = 0;
             $min_point2_10 = 999;
             $max_point2_10 = 0; 
             
             for ($i=1; $i < $days_in_month+1; $i++) { 
                echo "<tr>";
                    echo "<td>";
                        echo $i." ".$month." ".$year; 
                    echo "</td>";
                    $day = $i<10 ? "0".$i : $i;
                    $date_record = ($year-543)."-".$month_int."-".$day." 0.00";                   
                    $models = PointValueTb::model()->findAll(array('join' => '','condition'=>'point_id="BK-000302"  AND datetime_record ="'.$date_record.'" ', 'params'=>array()));
                    $value = empty($models) ? "-":$models[0]->point_float_value;
                    if(!empty($models))
                    {
                       $min_point1_00 = $min_point1_00 < $value ? $min_point1_00 : $value;
                       $max_point1_00 = $max_point1_00 > $value ? $max_point1_00 : $value;
                    }
                    echo "<td>";
                        echo $value; 
                    echo "</td>";
                    $date_record = ($year-543)."-".$month_int."-".$day." 10.00";                   
                    $models = PointValueTb::model()->findAll(array('join' => '','condition'=>'point_id="BK-000302"  AND datetime_record ="'.$date_record.'" ', 'params'=>array()));
                    $value = empty($models) ? "-":$models[0]->point_float_value;
                    if(!empty($models))
                    {
                       $min_point1_10 = $min_point1_10 < $value ? $min_point1_10 : $value;
                       $max_point1_10 = $max_point1_10 > $value ? $max_point1_10 : $value;
                    }
                    echo "<td>";
                        echo $value; 
                    echo "</td>";
                    $date_record = ($year-543)."-".$month_int."-".$day." 16.00";                   
                    $models = PointValueTb::model()->findAll(array('join' => '','condition'=>'point_id="BK-000302"  AND datetime_record ="'.$date_record.'" ', 'params'=>array()));
                    $value = empty($models) ? "-":$models[0]->point_float_value;
                    if(!empty($models))
                    {
                       $min_point1_16 = $min_point1_16 < $value ? $min_point1_16 : $value;
                       $max_point1_16 = $max_point1_16 > $value ? $max_point1_16 : $value;
                    }
                    echo "<td>";
                        echo $value; 
                    echo "</td>";

                    $date_record = ($year-543)."-".$month_int."-".$day." 0.00";                   
                    $models = PointValueTb::model()->findAll(array('join' => '','condition'=>'point_id="BK-000303"  AND datetime_record ="'.$date_record.'" ', 'params'=>array()));
                    $value = empty($models) ? "-":$models[0]->point_float_value;
                    if(!empty($models))
                    {
                       $min_point2_10 = $min_point2_10 < $value ? $min_point2_10 : $value;
                       $max_point2_10 = $max_point2_10 > $value ? $max_point2_10 : $value;
                    }
                    echo "<td>";
                        echo $value; 
                    echo "</td>";
                    echo "<td>";
                        echo "";  
                    echo "</td>";

                echo "</tr>";
             }

            ?>


    </tbody>
    <tfoot>
      <tr>
        <td>MIN</td>
        <?php
           $value = $min_point1_00==999 ? "-" : $min_point1_00;
           echo "<td>".$value."</td>";
           $value = $min_point1_10==999 ? "-" : $min_point1_10;
           echo "<td>".$value."</td>";
           $value = $min_point1_16==999 ? "-" : $min_point1_16;
           echo "<td>".$value."</td>";
           $value = $min_point2_10==999 ? "-" : $min_point2_10;
           echo "<td>".$value."</td>";

        ?>     
     
        <td></td>
        
      </tr>
      <tr>
        <td>MAX</td>
        <?php
           $value = $max_point1_00==0 ? "-" : $max_point1_00;
           echo "<td>".$value."</td>";
           $value = $max_point1_10==0 ? "-" : $max_point1_10;
           echo "<td>".$value."</td>";
           $value = $max_point1_16==0 ? "-" : $max_point1_16;
           echo "<td>".$value."</td>";
           $value = $max_point2_10==0 ? "-" : $max_point2_10;
           echo "<td>".$value."</td>";
          
        ?>   
        <td></td>
        
      </tr>
      <tr>
        <td>AVG</td>
        <?php
           //SELECT * FROM `point_value_tb` WHERE DATE_FORMAT(datetime_record,'%H:%i:%s')="10:00:00" AND datetime_record BETWEEN "2018-02-01 00.00" AND "2018-02-28 23.00"        
           // SELECT STDDEV_SAMP(point_float_value) FROM `point_value_tb` WHERE point_id='BK-000302'
           
           $date_begin = ($year-543)."-".$month_int."-01 00.00";
           $date_end = ($year-543)."-".$month_int."-".$days_in_month." 23.59";
           //$models = PointValueTb::model()->findAll(array('select' => 'AVG(point_float_value) as avg','condition'=>'point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="00:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"', 'params'=>array()));
           $models = Yii::app()->db->createCommand()
                        ->select('AVG(point_float_value) as avg')
                        ->from('point_value_tb')
                        ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="00:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                        ->queryAll();
          $value = empty($models) ? "-": number_format($models[0]['avg'],2);
          echo "<td>".$value."</td>";

           $models = Yii::app()->db->createCommand()
                      ->select('AVG(point_float_value) as avg')
                      ->from('point_value_tb')
                      ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="10:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                      ->queryAll();
                      $value = empty($models) ? "-": number_format($models[0]['avg'],2);
           echo "<td>".$value."</td>";

           $models = Yii::app()->db->createCommand()
                      ->select('AVG(point_float_value) as avg')
                      ->from('point_value_tb')
                      ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="16:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                      ->queryAll();
                      $value = empty($models) ? "-": number_format($models[0]['avg'],2);
            echo "<td>".$value."</td>";


            $models = Yii::app()->db->createCommand()
                        ->select('AVG(point_float_value) as avg')
                        ->from('point_value_tb')
                        ->where('point_id="BK-000303" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="10:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                        ->queryAll();
            $value = empty($models) ? "-": number_format($models[0]['avg'],2);
            echo "<td>".$value."</td>";
        ?>
       
     
        <td></td>
        
      </tr>
      <tr>
        <td>STD</td>
        <?php
           //SELECT * FROM `point_value_tb` WHERE DATE_FORMAT(datetime_record,'%H:%i:%s')="10:00:00" AND datetime_record BETWEEN "2018-02-01 00.00" AND "2018-02-28 23.00"        
           // SELECT STDDEV_SAMP(point_float_value) FROM `point_value_tb` WHERE point_id='BK-000302'
           
           $date_begin = ($year-543)."-".$month_int."-01 00.00";
           $date_end = ($year-543)."-".$month_int."-".$days_in_month." 23.59";
           //$models = PointValueTb::model()->findAll(array('select' => 'AVG(point_float_value) as avg','condition'=>'point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="00:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"', 'params'=>array()));
           $models = Yii::app()->db->createCommand()
                        ->select('STDDEV_SAMP(point_float_value) as sd')
                        ->from('point_value_tb')
                        ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="00:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                        ->queryAll();
          $value = empty($models) ? "-": number_format($models[0]['sd'],2);
          echo "<td>".number_format($value,2)."</td>";

           $models = Yii::app()->db->createCommand()
                      ->select('STDDEV_SAMP(point_float_value) as sd')
                      ->from('point_value_tb')
                      ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="10:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                      ->queryAll();
          $value = empty($models) ? "-": number_format($models[0]['sd'],2);
           echo "<td>".number_format($value,2)."</td>";

           $models = Yii::app()->db->createCommand()
                      ->select('STDDEV_SAMP(point_float_value) as sd')
                      ->from('point_value_tb')
                      ->where('point_id="BK-000302" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="16:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                      ->queryAll();
           $value = empty($models) ? "-": number_format($models[0]['sd'],2);
            echo "<td>".number_format($value,2)."</td>";


            $models = Yii::app()->db->createCommand()
                        ->select('STDDEV_SAMP(point_float_value) as sd')
                        ->from('point_value_tb')
                        ->where('point_id="BK-000303" AND DATE_FORMAT(datetime_record,"%H:%i:%s")="10:00:00"   AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"')
                        ->queryAll();
            $value = empty($models) ? "-": number_format($models[0]['sd'],2);
            echo "<td>".number_format($value,2)."</td>";
        ?>
        <td></td>
        
      </tr>
    </tfoot>
  </table>



