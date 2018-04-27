<?php
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load("report/bk_template.xls");
        date_default_timezone_set("Asia/Bangkok");

        $str = explode("-",$date_record);
        $year = $str[0]+543;
        $day = $str[2];

        $month_th = array("01"=>"มกราคม","02"=>"กุมภาพันธ์" ,"03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
        $month = $month_th[$str[1]];
        $row = 2; //row start
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $year);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$row, $day);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$row, $month);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$row, $year);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$row, "__( ".$shift." น.)__");

        //-----------------Section 1. Jar Test------------------//
        echo "---------section 1-----------<br>";
        $row_sec1 = 5;
        $row = 5;
        $nsample = 6;
        $nparam = 7;
        $ipoint = 1;
        //----42 samples----//
        for ($i=0; $i < $nparam; $i++) {
            $column = 'B'; 
        	for ($j=0; $j < $nsample; $j++) { 
        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;

        		$value = empty($models[$id]["value"]) ? "-" : $models[$id]["value"];
        		
        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
        		$column++;
                echo $id.":".$value."|";
        		$ipoint++;
        	}
        	$row++;
            echo "<br>";
        }
        //Recommended dosage
        echo '-----Recommended dosage------<br>';
        $row = $row_sec1;
        for ($i=0; $i < $nparam; $i++) { 
        	$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
        	$value = empty($models[$id]["value"]) ? "-" : $models[$id]["value"];
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("J".$row, $value);
        	echo $id.":".$value."<br>";
        	$ipoint++;
        	$row++;
        }


        //----------------------------End section 1--------------------//

        //-----------------Section 2. Chemical Dosage------------------//
        echo "//-----------------Section 2. Chemical Dosage------------------//<br>";

        //SELECT * FROM point_value_tb WHERE datetime_record=(SELECT MAX(datetime_record) FROM `point_value_tb` WHERE datetime_record < "2018-03-01" AND point_id IN ('BK-000058','BK-000059','BK-000060','BK-000061'))
        //$datetime_record = "2018-03-01";
        $models2 = PointValueTb::model()->findAll(array('condition'=>'datetime_record=(SELECT MAX(datetime_record) FROM point_value_tb WHERE point_id IN ("BK-000058","BK-000059","BK-000060","BK-000061") AND datetime_record < "'.$date_record.'")'));

        $last_postCl2 = "";
        if(!empty($models2[0]))
        $last_postCl2 = "(".$models2[0]['point_float_value']."+".$models2[3]['point_float_value'].")+".
                        "(".$models2[1]['point_float_value']."+".$models2[3]['point_float_value'].")+".
                        "(".$models2[2]['point_float_value']."+".$models2[3]['point_float_value'].")"
        ;
        //echo $last_postCl2;
        //$models = PointValueTb::model()->findAll(array('condition'=>'point_id IN ("BK-000058","BK-000059","BK-000060","BK-000061") AND datetime_record BETWEEN "2018-03-01 08.00" AND "2018-03-01 16.00"'));
        //foreach ($models as $key => $m) {
          //  echo $m->datetime_record." : ".$m->point_id." = ".$m->point_float_value."<br>";
        //}
        $ipoint = 50;

        $row = $row_sec1;
        for ($i=0; $i < $nparam; $i++) { 

        	if($i!=4)
        	{
        		//2 Lines

        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                $models2 = PointValueTb::model()->findAll(array('condition'=>'point_id="'.$id.'" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"'));
	        	$value1 = empty($models2[0]["point_float_value"]) ? "" : $models2[0]["point_float_value"];
	        	//echo $ipoint.":".$value1."<br>";
                $ipoint++;


	        	$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                $models2 = PointValueTb::model()->findAll(array('condition'=>'point_id="'.$id.'" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"'));
                $value2 = empty($models2[0]["point_float_value"]) ? "" : $models2[0]["point_float_value"];
                //echo $ipoint.":".$value2."<br>";

                if($value1=="" && $value2=="")
                    $value = "-";
                elseif($value1!="" && $value2=="")
                    $value = $value1;
                elseif($value1=="" && $value2!="")
                    $value = $value2;
                else
	        	     $value  = $value1."+".$value2;
                echo $value;
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$row, $value);
	        	$ipoint++;

        	}
        	else{
                $ipoint = 62;
                $models2 = PointValueTb::model()->findAll(array('select'=>'datetime_record',
'condition'=>'point_id IN ("BK-000058","BK-000059","BK-000060","BK-000061") AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"','group'=>'datetime_record',
    'distinct'=>true,
));
                $value = $last_postCl2;
                foreach ($models2 as $key => $m) {
                    //echo $m["datetime_record"]."<br>";
                    $models3 = PointValueTb::model()->findAll(array(
'condition'=>'point_id IN ("BK-000058","BK-000059","BK-000060","BK-000061") AND datetime_record ="'.$m["datetime_record"].'"'
));
                    $str =  explode(" ", $m["datetime_record"]);
                    $str = explode(":",$str[1]);
                    $time = $str[0].".".$str[1];
                    //echo $time;
                    //echo $models3[0]["point_id"].":".$models3[0]["point_float_value"]."<br>";
                    //3 Lines with TPS    
                    $value1 = $models3[0]["point_float_value"];
                    $value2 = $models3[1]["point_float_value"];
                    $value3 = $models3[2]["point_float_value"];
                    $tps = $models3[3]["point_float_value"];    

                    $value1 = "(".$value1."+".$tps.")";
                    $value2 = "(".$value2."+".$tps.")";
                    $value3 = "(".$value3."+".$tps.")";
                    $valueAll = $value1."+".$value2."+".$value3."(".$time.")";

                    $value = $value."->".$valueAll;
                    
                }

        		//3 Lines with TPS
        		// $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	// $value1 = empty($models[$id]["value"]) ? "" : $models[$id]["value"];
	        	// $ipoint++;

	        	// $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	// $value2 = empty($models[$id]["value"]) ? "" : $models[$id]["value"];
	        	// $ipoint++;


	        	// $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	// $value3 = empty($models[$id]["value"]) ? "" : $models[$id]["value"];
	        	// $ipoint++;

	        	// //TPS
	        	// $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	// $tps = empty($models[$id]["value"]) ? "" : $models[$id]["value"];
	        	// $ipoint++;

	        	// $value1 = "(".$value1."+".$tps.")";
	        	// $value2 = "(".$value2."+".$tps.")";
	        	// $value3 = "(".$value3."+".$tps.")";
          //       $value = $value1."+".$value2."+".$value3."(".$models[$id]["datetime_record"].")";
                 echo $value;
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$row, $value);
	        	

        	}
        	echo "<br>";
        	$row++;
        }
        //----------------------------End section 2--------------------//

        //-----------------Section 3. Chemicals Used ------------------//
        echo "//-----------------Section 3. Chemicals Used ------------------//<br>";
        $row = $row_sec1;
        for ($i=0; $i < $nparam; $i++) { 
        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : $models[$id]["value"];
	        	$ipoint++;
                $value = number_format($value,0);
	        	echo $value."<br>";
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA".$row, $value);
	        	$row++;
        }

        //----------------------------End section 3--------------------//

        //-----------------Section 4. Water Production------------------//
        echo "//-----------------Section 4. Water Production------------------//<br>";
        $row = 4;
        $nrow = 8;
        for ($i=0; $i < $nrow; $i++) { 
        	//echo $i."---<br>";
        	if($i==1 || $i==5 || $i==7)
        	{
        		//2 Lines
        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$ipoint++;
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AH".$row, $value);
                echo $value."|";

	        	$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN".$row, $value);
	        	$ipoint++;
                echo $value."|";
	        	//echo $i.":".$id."=".$value."<br>";

        	}
        	else if($i==3)
        	{
        		//3 Lines
        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$ipoint++;
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AG".$row, $value);
                echo $value."|";

	        	$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK".$row, $value);
	        	$ipoint++;
                echo $value."|";

	        	$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$row, $value);
	        	$ipoint++;

	        	//echo $i.":".$id."=".$value."<br>";
                echo $value."|";
        	}
        	else{

        		$id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
	        	$value = empty($models[$id]["value"]) ? "0" : number_format(intval($models[$id]["value"]),0);
	        	$ipoint++;
	        	
	        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AJ".$row, $value);
	        	echo $value."|";
        	}
            echo "<br>";;
        	$row++;	
        }

        //----------------------------End section 4--------------------//

        //-----------------Section 5. Water Quality------------------//
        echo "//-----------------Section 5. Water Quality------------------//<br>";
        
        switch ($shift) {
        	case '00.00-08.00':
        		$time1 = '00.00';
        		$time2 = '04.00';
        		break;

        	case '08.00-16.00':
        		$time1 = '08.00';
        		$time2 = '12.00';
        		break;
        		
        	case '16.00-24.00':
        		$time1 = '16.00';
        		$time2 = '20.00';
        		break;		
        	
        	default:
        		$time1 = '00.00';
        		$time2 = '00.00';
        		break;
        }

        $date_begin = $date_record." ".$time1;
        $date_end2 = $date_record." ".$time2;
        $section_id = "BK-SECTION-005";
        //echo $date_end;
        $model_sec5 = PointValueTb::model()->findAll(array('join' => 'LEFT JOIN points_main_tb ON t.point_id = points_main_tb.point_id', 'order'=>'datetime_record,t.point_id ASC','condition'=>'section_id="'.$section_id.'" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end2.'"', 'params'=>array()));

        //print_r($model_sec5);
        $model_array = array();
        $id = 1;
        foreach ($model_sec5 as $model) {
            $dt1 = new DateTime($model->datetime_record);
            $h = (int)$dt1->format( 'H' );
            //echo $h."<br>";
            $model_array[$model->point_id][$h] = $model->point_float_value; 
            //echo $model->datetime_record." : ".$model->point_id."=".$model->point_float_value."<br>";
            $id++;  
        }

        //echo "<pre>";
        //print_r($model_array);
        //echo "</pre>";

        //echo "===".$model_array['BK-000103'][8];



        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A13", $time1." น.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A18", $time2." น.");

        $nparam = 4;
        $ntime = 2;
        $nstation = 17;
        $times = array($time1, $time2);
        $skip_col = array(1,2,15,16,17);
        
        $row = 14;

        for ($i=0; $i < $ntime; $i++) { 
            $time_int  = intval($times[$i]);
            echo $time_int."<br>";
            $ipoint = 86;
            for ($j=0; $j < $nparam; $j++) { 
                    $column = "B";
                    for ($k=0; $k < $nstation; $k++) { 

                       $skip = ($j==$nparam-1 && in_array($k+1, $skip_col));
                       if(!$skip)
                        {
                            //echo $column."|";
                            $id = $ipoint < 100 ? "BK-0000".$ipoint : "BK-000".$ipoint ;
                            //echo $id."|";
                            $value = empty($model_array[$id][$time_int]) ? "-" : $model_array[$id][$time_int];
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
                            //if(empty($model_array[$id][$time_int]))
                            ///if($id=='BK-000103')    
                            //echo $ipoint.":".$column.$row."=".$value."| ";
                            echo $value."|";
                            $ipoint++;
                        }        
                       $column++;     
                    }      
                echo "row:".$row."<br>";    
                $row++;    
            }
            $row++; //skip header section time2
        }

        $nstation = 15;
        $skip_col = array(1,12,13,14,15);
        $row = 14;
        for ($i=0; $i < $ntime; $i++) { 
            $time_int  = intval($times[$i]);
            $ipoint = 149;
            for ($j=0; $j < $nparam; $j++) { 
                    $column = "S";
                    for ($k=0; $k < $nstation; $k++) { 

                       $skip = ($j==$nparam-1 && in_array($k+1, $skip_col));
                       if(!$skip)
                        {
                            //echo $column."|";
                            $id = $ipoint < 100 ? "BK-0000".$ipoint : "BK-000".$ipoint ;
                            $value = empty($model_array[$id][$time_int]) ? "-" : $model_array[$id][$time_int];
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
                            //if(empty($model_array[$id][$time_int]))
                            ///if($id=='BK-000103')    
                            //echo $ipoint.":".$column.$row."=".$value."| ";
                            echo $value."|";

                            $ipoint++;
                        }        
                       $column++;     
                    }      
                echo "row:".$row."<br>";    
                $row++;    
            }
            $row++; //skip header section time2
        }

        //Raw water flow rate
        $row = 23;
        $column = array('E','I','M'); 
        $columnT = array('E','I','M'); 
        $time = explode("-",$shift);
        $datetime_record = $date_record.' 00.00" AND "'.$date_record." ".$time[1];
        //echo $datetime_record."<br>";
        $models3 = PointValueTb::model()->findAll(array(
             'condition'=>'point_id ="BK-000204" AND datetime_record BETWEEN "'.$datetime_record.'"'
        ));
        $i = 0;
        foreach ($models3 as $key => $m) {
            //echo $m['datetime_record'].":".$m['point_float_value']."<br>";
            $str =  explode(" ", $m["datetime_record"]);
            $str = explode(":",$str[1]);
            $time = $str[0].".".$str[1];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column[$i].$row, number_format($m['point_float_value'],0)." CMD (".$time.")");
            $i++;
        }

        $models3 = PointValueTb::model()->findAll(array(
             'condition'=>'point_id ="BK-000205" AND datetime_record BETWEEN "'.$datetime_record.'"'
        ));
        $row++;
        $i=0;
        foreach ($models3 as $key => $m) {
            //echo $m['point_float_value']."<br>";
            $str =  explode(" ", $m["datetime_record"]);
            $str = explode(":",$str[1]);
            $time = $str[0].".".$str[1];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column[$i].$row, number_format($m['point_float_value'],0)." CMD (".$time.")");
            $i++;
        }
        //----------------------------End section 5--------------------//

        //-----------------Section 6. Free CL2 in TP------------------//
        echo "//-----------------Section 6. Free CL2 in TP------------------//<br>";
        switch ($shift) {
        	case '00.00-08.00':
        		$time1 = '00.00';
        		$time2 = '06.00';
        		break;

        	case '08.00-16.00':
        		$time1 = '08.00';        	
        		$time2 = '14.00';
        		break;
        		
        	case '16.00-24.00':
        		$time1 = '16.00';
        		$time2 = '22.00';
        		break;		
        	
        	default:
        		$time1 = '00.00';
        		$time2 = '00.00';
        		break;
        }

        $ntime = 4;
        $nstation = 11;
        $date_begin = $date_record." ".$time1;
        $date_end2 = $date_record." ".$time2;

        //SELECT * FROM `point_value_tb` pv LEFT JOIN points_main_tb pm ON pv.point_id=pm.point_id WHERE section_id="BK-SECTION-007" AND datetime_record BETWEEN "2018-02-05 08:00:00" AND "2018-02-05 15:00:00" ORDER BY pv.point_id,datetime_record
        $model_sec6 = PointValueTb::model()->findAll(array('join' => 'LEFT JOIN points_main_tb ON t.point_id = points_main_tb.point_id', 'order'=>'datetime_record,t.point_id ASC','condition'=>'section_id="BK-SECTION-006" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end2.'"', 'params'=>array()));

        $model_array = array();
        $id = 1;
        foreach ($model_sec6 as $model) {
            $dt1 = new DateTime($model->datetime_record);
            $h = (int)$dt1->format( 'H' );
            //echo $h."<br>";
            $model_array[$model->point_id][$h] = $model->point_float_value; 
            //echo $model->datetime_record." : ".$model->point_id."=".$model->point_float_value."<br>";
            $id++;  
        }

        
        $time_int = intval($time1); 
        $row = 25;
        for ($i=0; $i < $ntime  ; $i++) {     
            
            $column = 'V';    
            $ipoint = 206; //start point_id
  
            for ($j=0; $j < $nstation; $j++) { 
                $id = "BK-000".$ipoint ;    
                if($j==0)
                {
                    //echo $column.$row."=".$time_int."<br>";
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $time_int." น.");
                
                    $column++;    
                }
               
                $value = $model_array[$id][$time_int]!=0 && empty($model_array[$id][$time_int])  ? "-" : $model_array[$id][$time_int];
                //$value =  $model_array[$id][$time_int];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
                //if(empty($model_array[$id][$time_int]))
                //   echo $id.":".$column.$row."=".$value."<br>";
                echo $value." | ";
                 
                $column++;   
                $ipoint++;
            
                
            }

            $time_int += 2 ;
            $row++;

            echo "<br>";
            
        }



        //----------------------------End section 6--------------------//

        //-----------------Section 7. Free CL2 at Pump------------------//
        echo "//-----------------Section 7. Free CL2 at Pump------------------//<br>";
        //$shift = '08.00-16.00';
        switch ($shift) {
        	case '00.00-08.00':
        		$time1 = '00.00';
        		$time2 = '07.00';
        		break;

        	case '08.00-16.00':
        		$time1 = '08.00';
        		$time2 = '15.00';
        		break;
        		
        	case '16.00-24.00':
        		$time1 = '16.00';
        		$time2 = '23.00';
        		break;		
        	
        	default:
        		$time1 = '00.00';
        		$time2 = '07.00';
        		break;
        }

        $ntime = 8;
        $nstation = 9;
        $date_begin = $date_record." ".$time1;
        $date_end2 = $date_record." ".$time2;

        //SELECT * FROM `point_value_tb` pv LEFT JOIN points_main_tb pm ON pv.point_id=pm.point_id WHERE section_id="BK-SECTION-007" AND datetime_record BETWEEN "2018-02-05 08:00:00" AND "2018-02-05 15:00:00" ORDER BY pv.point_id,datetime_record
        $model_sec7 = PointValueTb::model()->findAll(array('join' => 'LEFT JOIN points_main_tb ON t.point_id = points_main_tb.point_id', 'order'=>'datetime_record,t.point_id ASC','condition'=>'section_id="BK-SECTION-007" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end2.'"', 'params'=>array()));

		//print_r($model_sec7);

		$model_array = array();
        $id = 1;
		foreach ($model_sec7 as $model) {
            $dt1 = new DateTime($model->datetime_record);
            $h = (int)$dt1->format( 'H' );
            //echo $h."<br>";
			$model_array[$model->point_id][$h] = $model->point_float_value; 
            //echo $model->datetime_record." : ".$model->point_id."=".$model->point_float_value."<br>";
            $id++;  
		}
        // echo "<pre>";
        // print_r($model_array);
        // echo "</pre>";
        //header
        $time_int = intval($time1); 
        $column = 'AI';
        for ($j=0; $j < $ntime; $j++) {   

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column."13", $time_int." น.");
            $column++;
            $time_int++;
        }    
        
        
        $column = 'AI';
        $time_int = intval($time1); 
        for ($i=0; $i < $ntime ; $i++) {     
            $row = 14;    
            $ipoint = 217; //start point_id
            

        	for ($j=0; $j < $nstation; $j++) { 
        		$id = "BK-000".$ipoint ;
                $value = empty($model_array[$id][$time_int]) ? "" : $model_array[$id][$time_int];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
               
                //if(empty($model_array[$id][$time_int]))
                //echo $id.":".$column.$row."=".$value."<br>";
                echo $value."<br>";
                 $row++;
                $ipoint++;
        	}
            echo "----<br>";
            $time_int++;
            $column++;
        }



        //----------------------------End section 7--------------------//

        //-----------------Section 8. Recycle Water--------------------//
        echo "//-----------------Section 8. Recycle Water--------------------//<br>";
        switch ($shift) {
        	case '00.00-08.00':
        		$time1 = '00.00';
        		break;

        	case '08.00-16.00':
        		$time1 = '08.00';      	
        		break;
        		
        	case '16.00-24.00':
        		$time1 = '16.00';
        		break;		
        	
        	default:
        		$time1 = '00.00';
        		break;
        }
        //echo $time1;
        //echo $models["BK-000226"]["value"]."<br>";
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AI24", $time1." น.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK24", $models["BK-000226"]["value"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN24", $models["BK-000227"]["value"]);
        //----------------------------End section 8--------------------//

        //-----------------Section 9. Non-Conform --------------------//
        echo "//-----------------Section 9. Non-Conform --------------------//<br>";
        $row = 28;
        $ipoint = 228; //start point_id
        $ipoint2 = 475; //start point_id
        $nparam = 6;
        $datetime_record = $date_record." ".$date_begin;
        //echo $datetime_record;
        
        for ($i=0; $i < $nparam; $i++) { 
        	//no sample
            $id = "BK-000".$ipoint ;
            $valueSample = "";
            if(array_key_exists($id,$models))
                   $valueSample = $models[$id]['value'];	    
            echo $id.":".$valueSample."|";
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B".$row, $valueSample);
            

            //no NC
            $id = "BK-000".$ipoint2 ;
            $valueNC = "";
            if(array_key_exists($id,$models))
                   $valueNC = $models[$id]['value'];	    
            echo $id.":".$valueNC."|";
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C".$row, $valueNC);

           

            //% NC
            $percent = ($valueNC/$valueSample)*100;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D".$row, $percent);
            echo "%:".$percent."|";

            //monthy Sample
            $id = "BK-000".$ipoint ;
            $str = explode("-",$date_record);
            $date_month = $str[0]."-".$str[1]."-1 00.00";
            $model_sec9 = Yii::app()->db->createCommand()
                        ->select('sum(point_float_value) as sum')
                        ->from('point_value_tb')
                        ->where('point_id="'.$id.'" AND datetime_record BETWEEN "'.$date_month.'" AND "'.$date_begin.'"')
                        ->queryRow();
            $valueSampleMonth = $model_sec9['sum'];
            echo $valueSampleMonth."|";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E".$row, $valueSampleMonth);

            //monthy NC
            $id = "BK-000".$ipoint2 ;
            $model_sec9 = Yii::app()->db->createCommand()
                        ->select('sum(point_float_value) as sum')
                        ->from('point_value_tb')
                        ->where('point_id="'.$id.'" AND datetime_record BETWEEN "'.$date_month.'" AND "'.$date_begin.'"')
                        ->queryRow();
            $valueSampleNC = $model_sec9['sum'];
            echo $valueSampleNC."|";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$row, $valueSampleNC);

            //% NC
            $percent = ($valueSampleNC/$valueSampleMonth)*100;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$row, $percent);
            echo $percent."|";

            echo "<br>";
            $ipoint++;
            $ipoint2++;
        	$row++;
        }

       
      

        //----------------------------End section 9--------------------//

        //-----------------Section 10. Additional Data--------------------//
        echo "//-----------------Section 10. Additional Data--------------------//<br>";
        switch ($shift) {
        	case '00.00-08.00':
        		$time = array("00.00","04.00");
        		break;

        	case '08.00-16.00':
        		$time = array("08.00","12.00");
        		break;
        		
        	case '16.00-24.00':
        		$time = array("16.00","20.00");
        		break;		
        	
        	default:
        		$time = array("00.00","04.00");
        		break;
        }
        $row = 28;
        $nparam = 7;
            
        for ($i=0; $i < 2; $i++) { 
        	$datetime_record = $date_record." ".$time[$i];
        	echo $datetime_record."<br>";
        	$ipoint = 234;
            $column = 'AI';
            $str = explode(".",$time[$i]);
            $time_str = $str[0]." น.";
            //echo $time_str."<br>";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AH".$row, $time_str);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$row, $time_str);
            
            $model_sec10 = PointValueTb::model()->findAll(array('join' => 'LEFT JOIN points_main_tb ON t.point_id = points_main_tb.point_id', 'order'=>'datetime_record,t.point_id ASC','condition'=>'section_id="BK-SECTION-010" AND datetime_record= "'.$datetime_record.'"', 'params'=>array()));

            $model_array = array();
            foreach ($model_sec10 as $key => $m) {
               //echo $m['point_id'].":".$m['point_float_value']."<br>";
               $model_array[$m['point_id']] = $m['point_float_value'];
               //echo $model_array[$m['point_id']]."<br>";
            }

        	for ($j=0; $j < $nparam; $j++) {
        	    if($j==$nparam-1){
        	       $column++;
        	    }
        		echo $column.$row.":";

                $id = "BK-000".$ipoint ;
                $value = empty($model_array[$id]) ? "" : $model_array[$id];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
	        	
	        	echo $value." | ";
	        	$column++;
	        	$ipoint++;
        	}
        	echo "<br>";
        	$row++;
        }
        echo "----------------<br>";
       
       
        $datetime_record = $date_record." ".$time[0];
        $model_sec10 = PointValueTb::model()->findAll(array('join' => 'LEFT JOIN points_main_tb ON t.point_id = points_main_tb.point_id', 'order'=>'datetime_record,t.point_id ASC','condition'=>'section_id="BK-SECTION-010" AND datetime_record= "'.$datetime_record.'"', 'params'=>array()));

        $model_array = array();
        foreach ($model_sec10 as $key => $m) {
               //echo $m['point_id'].":".$m['point_float_value']."<br>";
               $model_array[$m['point_id']] = $m['point_float_value'];
               //echo $model_array[$m['point_id']]."<br>";
        }

        $row = 30;
        $ipoint = 241;
        for ($i=0; $i < 3; $i++) { 
        
	        $column = 'AF';
	        for ($j=0; $j < 2; $j++) { 
                $id = "BK-000".$ipoint ;
                $value = "";
                if(array_key_exists($id,$model_array))
                   $value = $model_array[$id];	    
	        	//$value = array_key_exists($id,$model_array) ? "" : $model_array[$id];	        	
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
		        echo $id.":".$value." | ";
		        $column++;
		        $ipoint++;
	        }
            $row++;
            echo "<br>";
        }

        $row = 31;
        $ipoint = 247;
        for ($i=0; $i < 2; $i++) { 
        
	        $column = 'AI';
	        for ($j=0; $j < 4; $j++) { 
	        	$id = "BK-000".$ipoint ;
                $value = "";
	        	if(array_key_exists($id,$model_array))
                   $value = $model_array[$id];   	
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value);
		        echo $id.":".$value." | ";
		        $column++;
		        $column++;
		        $ipoint++;
	        }
            $row++;
            echo "<br>";
        }

       

        //----------------------------End section 10--------------------//

        //-----------------------------Remark---------------------------//
        echo "//-----------------------------Remark---------------------------//<br>";
        $row = 25;
        $column = 'H';
        $id = "BK-000474";

        $model_remark = PointValueTb::model()->findAll(array('condition'=>'point_id="'.$id.'" AND datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"', 'params'=>array()));
        foreach ($model_remark as $key => $m) {
            //echo $m["point_id"].":".$m["point_text_value"]."<br>";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $m["point_text_value"]);
            $row++;
        }


        //----------------------------End Remark-----------------------//

        //echo Yii::app()->user->name.":".Yii::app()->user->ID;
        $user = UsersInfoTb::model()->findByPk(Yii::app()->user->ID);
        //echo $user->position;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P30", Yii::app()->user->name);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P31", $user->position." สคบ. ฝผข.");
        
		
		//?????important clear cabage
		ob_end_clean();
		ob_start();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="daily_report.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');  //
		Yii::app()->end();

?>		