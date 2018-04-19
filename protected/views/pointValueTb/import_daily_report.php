<?php
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes

	Yii::import('ext.phpexcel.XPHPExcel');    
	$objPHPExcel= XPHPExcel::createPHPExcel();
	$objReader = PHPExcel_IOFactory::createReader('Excel5');


	$filename = "bk_template_import.xls";
        $objPHPExcel = $objReader->load("import/".$filename);
        date_default_timezone_set("Asia/Bangkok");

        $worksheet  = $objPHPExcel->setActiveSheetIndex(0);

        $row_shift = 33;
        $shift_no = 0; 
    $month_th = array("มกราคม" =>"01","กุมภาพันธ์" =>"02","มีนาคม" =>"03","เมษายน" =>"04","พฤษภาคม" =>"05","มิถุนายน" =>"06","กรกฎาคม" =>"07","สิงหาคม" =>"08","กันยายน" =>"09","ตุลาคม" =>"10","พฤศจิกายน" =>"11","ธันวาคม" =>"12");


    //for ($shift_no=0; $shift_no < 3 ; $shift_no++) { 
    

        $row = ($row_shift*$shift_no+2);

        
        //--------datetime record---------------//
        $day   = $worksheet->getCell("X".$row)->getValue();
        $day   = $day < 10 ? "0".$day : $day;
        $month = $month_th[$worksheet->getCell("Y".$row)->getValue()];
        $year  = $worksheet->getCell("AE".$row)->getValue()-543;
        $shift = $worksheet->getCell("AG".$row)->getValue();
        $shift = substr($shift, 1, 11);
        
        $date_record  = $year."-".$month."-".$day;
        //echo $datetime_record."<br>";

        //---------end datetime---------------//

    
       
           
        //-----------------Section 1. Jar Test------------------//
        $row = $row_shift*$shift_no+5;
        $nsample = 6;
        $nparam = 7;
        $ipoint = 1;
        //----42 samples----//
        $times = explode("-", $shift);
        $time_record = $times[0];
        $datetime_record = $date_record." ".$time_record;
        //echo $datetime_record;
        for ($i=0; $i < $nparam; $i++) {
                $column = 'B'; 
                for ($j=0; $j < $nsample; $j++) { 
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $value = $worksheet->getCell($column.$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        $column++;
                        //echo $id.":".$value." | ";
                        $ipoint++;
                }
                $row++;
                //echo "<br>";
        }
        //Recommended dosage
        $row = $row_shift*$shift_no+5;
        $column = 'J'; 
        for ($i=0; $i < $nparam; $i++) { 
                $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                $value = $worksheet->getCell($column.$row);
                PointValueTbController::addModel($id,$datetime_record,$value); 
                //echo $id.":".$value."<br>";
                $ipoint++;
                $row++;
        }
        //----------------------------End section 1--------------------//

        //-----------------Section 2. Chemical Dosage------------------//
        $row = $row_shift*$shift_no+5;
        $column = 'N'; 
        for ($i=0; $i < $nparam; $i++) { 

                if($i!=4)
                {
                        $datetime_record = $date_record." ".$time_record;
                        //2 Lines
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $value = $worksheet->getCell($column.$row);
                        $value = explode("+", $value);
                        PointValueTbController::addModel($id,$datetime_record,$value[0]); 
                        //echo $id.":".$value[0]."<br>";
                        //PointValueTbController::addModel($id,$datetime_record,$value); 
                        $ipoint++;

                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $value = empty($value[1]) ? "" : $value[1] ;
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";
                        //PointValueTbController::addModel($id,$datetime_record,$value); 
                        $ipoint++;

                }
                else{

                        //3 Lines with TPS
                       
                        $value = $worksheet->getCell($column.$row);
                        $datas = PointValueTbController::postCl2($value); 
                        
                        //echo $value."<br>";

                        /*foreach ($datas as $key => $data) {
                                $ipoint = 58;
                                $datetime_record = $date_record." ".$data['time'];
                                //echo $datetime_record."<br>";

                                $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                                $value = $data['lines'][0];
                                PointValueTbController::addModel($id,$datetime_record,$value); 
                                //echo $id.":".$data['lines'][0]."<br>";
                                $ipoint++;

                                $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                                $value = $data['lines'][1];
                                PointValueTbController::addModel($id,$datetime_record,$value); 
                                //echo $id.":".$data['lines'][1]."<br>";
                                $ipoint++;

                                $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                                $value = $data['lines'][2];
                                PointValueTbController::addModel($id,$datetime_record,$value); 
                                //echo $id.":".$data['lines'][2]."<br>";
                                $ipoint++;

                                $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                                $value = $data['tps'];
                                PointValueTbController::addModel($id,$datetime_record,$value); 
                                //echo $id.":".$data['tps']."<br>";
                                $ipoint++;

                               
                        }
                        */

                }
                
                $row++;
        }

        //PostCl2 3 Lines with TPS
        
        $row = $row_shift*$shift_no+5;
        for ($i=0; $i < $nparam ; $i++) { 
        	$column = 'O';
        	for ($j=0; $j < 5 ; $j++) {
        		$value = $worksheet->getCell($column.$row);
        		if($value!="")
        		{
        			$str = explode("+", $value);
        			//print_r($str);
        			$start = strpos($str[5], '(');
        			$stop = strpos($str[5], ')');
        			$time = substr($str[5], $start+1,$stop-$start+1);
        			//echo $time."<br>";
        			$value = str_replace("(", "", $str[0]);
        			$id = "BK-000058";
        			$datetime_record = $date_record." ".$time;
        			echo $datetime_record."]".$id.":".$value."<br>";
        			PointValueTbController::addModel($id,$datetime_record,$value);

        			$value = str_replace(")", "", $str[1]);
        			$id = "BK-000061";
        			$datetime_record = $date_record." ".$time;
        			echo $datetime_record."]".$id.":".$value."<br>";
        			PointValueTbController::addModel($id,$datetime_record,$value);

        			$value = str_replace("(", "", $str[2]);
        			$id = "BK-000059";
        			$datetime_record = $date_record." ".$time;
        			echo $datetime_record."]".$id.":".$value."<br>";
        			PointValueTbController::addModel($id,$datetime_record,$value);

        			$value = str_replace("(", "", $str[4]);
        			$id = "BK-000060";
        			$datetime_record = $date_record." ".$time;
        			echo $datetime_record."]".$id.":".$value."<br>";
        			PointValueTbController::addModel($id,$datetime_record,$value);
        		}
        		//echo $column.$row.":".$value."<br>";
        	    $column++;
        	}

        	$row++;
        }


        //----------------------------End section 2--------------------//
        /*
        //-----------------Section 3. Chemicals Used ------------------//

        $row = $row_shift*$shift_no+5;
        $column = 'AA'; 
        $datetime_record = $date_record." ".$time_record;
        for ($i=0; $i < $nparam; $i++) { 
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $value = $worksheet->getCell($column.$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";
                        $ipoint++;
                        $row++;
        }

        //----------------------------End section 3--------------------//

        //-----------------Section 4. Water Production------------------//
        $row = $row_shift*$shift_no+4;
        $nrow = 8;
        for ($i=0; $i < $nrow; $i++) { 
                //echo $i."---<br>";
                if($i==0)
                {
                        //i==0
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AJ".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";
                }        
                else if($i==1 || $i==5)
                {
                        //2 Lines
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AG".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";


                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AM".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";

                }
                else if($i==2 || $i==4 || $i==6)
                {
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AI".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";
                }
                else if($i==3)
                {
                        //3 Lines
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AG".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";

                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AK".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";

                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AO".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";

                        //echo $i.":".$id."=".$value."<br>";

                }
                else {
                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AH".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";

                        $id = $ipoint < 10 ? "BK-00000".$ipoint : "BK-0000".$ipoint ;
                        $ipoint++;
                        $value = $worksheet->getCell("AN".$row);
                        PointValueTbController::addModel($id,$datetime_record,$value); 
                        //echo $id.":".$value."<br>";
                }

                $row++; 
        }

        //----------------------------End section 4--------------------//


        //-----------------Section 5. Water Quality------------------//
        
        switch ($shift) {
                case '00:00-08:00':
                        $time1 = '00.00';
                        $time2 = '04.00';
                        break;

                case '08:00-16:00':
                        $time1 = '08.00';
                        $time2 = '12.00';
                        break;
                        
                case '16:00-24:00':
                        $time1 = '16.00';
                        $time2 = '20.00';
                        break;          
                
                default:
                        $time1 = '00.00';
                        $time2 = '00.00';
                        break;
        }

      
        //echo $time1;
        $nparam = 4;
        $ntime = 2;
        $nstation = 17;
        $times = array($time1, $time2);
        $skip_col = array(1,2,15,16,17);
        
        $row = $row_shift*$shift_no+14;

        for ($i=0; $i < $ntime; $i++) { 
            
            $datetime_record = $date_record." ".$times[$i];
            echo $datetime_record ."<br>";
            $ipoint = 86;
            for ($j=0; $j < $nparam; $j++) { 
                    $column = "B";
                    for ($k=0; $k < $nstation; $k++) { 

                       $skip = ($j==$nparam-1 && in_array($k+1, $skip_col));
                       if(!$skip)
                        {
                            $id = $ipoint < 100 ? "BK-0000".$ipoint : "BK-000".$ipoint ;
                            $value = $worksheet->getCell($column.$row);
                            PointValueTbController::addModel($id,$datetime_record,$value); 
                            //echo $id.":".$value." | ";

                            $ipoint++;
                        }        
                       $column++;     
                    }      
                //echo "row:".$row."<br>";    
                $row++;    
            }
            $row++; //skip header section time2
        }
        
        $nstation = 15;
        $skip_col = array(1,12,13,14,15);
        $row = $row_shift*$shift_no+14;
        for ($i=0; $i < $ntime; $i++) { 
            $datetime_record = $date_record." ".$times[$i];
            echo $datetime_record ."<br>";
            $ipoint = 149;
            for ($j=0; $j < $nparam; $j++) { 
                    $column = "S";
                    for ($k=0; $k < $nstation; $k++) { 

                       $skip = ($j==$nparam-1 && in_array($k+1, $skip_col));
                       if(!$skip)
                        {
                            //echo $column."|";
                            $id = $ipoint < 100 ? "BK-0000".$ipoint : "BK-000".$ipoint ;
                            $value = $worksheet->getCell($column.$row);
                            PointValueTbController::addModel($id,$datetime_record,$value); 
                            //echo $id.":".$value." | ";


                            $ipoint++;
                        }        
                       $column++;     
                    }      
                //echo "row:".$row."<br>";    
                $row++;    
            }
            $row++; //skip header section time2
        }
        //Raw water flow rate 
        $row = $row_shift*$shift_no+23;
	    for ($i=0; $i < 2; $i++) { 
	    	$id = $ipoint < 100 ? "BK-0000".$ipoint : "BK-000".$ipoint ;
	    	$str = $worksheet->getCell("E".$row);
	        $str = str_replace("CMD", "", trim($str)) ;
	        $str = str_replace(")", "", trim($str)) ;
	        $start = strpos($str, "(");
	        $value = substr($str, 0,$start);
	        $time = substr($str, $start+1);
	        //echo $time."<br>";
	        $datetime_record = $date_record." ".$time;
	        if($value!="")
	        {
	        	PointValueTbController::addModel($id,$datetime_record,$value); 
	        }
	        //echo $id.":".$datetime_record.":".$value." | ";

	        $str = $worksheet->getCell("I".$row);
	        $str = str_replace("CMD", "", trim($str)) ;
	        $str = str_replace(")", "", trim($str)) ;
	        $start = strpos($str, "(");
	        $value = substr($str, 0,$start);
	        $time = substr($str, $start+1);
			$datetime_record = $date_record." ".$time;
	        if($value!="")
	        {
	        	PointValueTbController::addModel($id,$datetime_record,$value); 
	        }
	        //echo $id.":".$datetime_record.":".$value." | ";


	        $str = $worksheet->getCell("M".$row);
	        $str = str_replace("CMD", "", trim($str)) ;
	        $str = str_replace(")", "", trim($str)) ;
	        $start = strpos($str, "(");
	        $value = substr($str, 0,$start);
	        $time = substr($str, $start+1);
			$datetime_record = $date_record." ".$time;
	        if($value!="")
	        {
	        	PointValueTbController::addModel($id,$datetime_record,$value); 
	        }
	        //echo $id.":".$datetime_record.":".$value." | ";
	        
	        $row++;
	        $ipoint++;
	    }
	        
        //----------------------------End section 5--------------------//

        //-----------------Section 6. Free CL2 in TP------------------//
        switch ($shift) {
        	case '00:00-08:00':
        		$time = array('00.00','02.00','04.00','06.00');
        		break;

        	case '08:00-16:00':
        		$time = array('08.00','10.00','12.00','14.00');
        		break;
        		
        	case '16:00-24:00':
        		$time = array('16.00','18.00','20.00','22.00');
        		break;		
        	
        	default:
        		$time = array('00.00','02.00','04.00','06.00');
        		break;
        }

        $ntime = 4;
        $nstation = 11;
        $row = $row_shift*$shift_no+25;
        for ($i=0; $i < $ntime  ; $i++) {     
            
            $column = 'W';    
            $ipoint = 206; //start point_id
            $datetime_record = $date_record." ".$time[$i];
            echo $datetime_record."<br>";

            for ($j=0; $j < $nstation; $j++) { 
                $id = "BK-000".$ipoint ;  
                $value = $worksheet->getCell($column.$row);  
                PointValueTbController::addModel($id,$datetime_record,$value);
                //echo $id.":".$value." | ";                 
                $column++;   
                $ipoint++;
            
                
            }
            //echo "<br>";
            $row++;            
        }
        //----------------------------End section 6--------------------//

        //-----------------Section 7. Free CL2 at Pumping Station----------------//
        echo "section 7 <br>";
        switch ($shift) {
        	case '00:00-08:00':
        		$time = "00.00";
        		break;

        	case '08:00-16:00':
        		$time = '08.00';
        		break;
        		
        	case '16:00-24:00':
        		$time = '16.00';
        		break;		
        	
        	default:
        		$time = '00.00';
        		break;
        }

        $ntime = 8;
        $nstation = 9;
        $row = $row_shift*$shift_no+14;
        $ipoint = 217; //start point_id
        
        for ($i=0; $i < $nstation  ; $i++) {     
            
            $column = 'AI';    
            
            $id = "BK-000".$ipoint ;  
            $int_time = (int)$time;
            //echo $int_time."<br>";
                
            
            for ($j=0; $j < $ntime; $j++) { 
                
                $time2 = $int_time < 10 ? '0'.$int_time.'.00' :$int_time.'.00' ;
            	$datetime_record = $date_record." ".$time2;
            	$int_time++;

                $value = $worksheet->getCell($column.$row);  
                PointValueTbController::addModel($id,$datetime_record,$value);
                //echo $datetime_record."=".$id.":".$value." | ";                 
                //echo $int_time."<br>";
                $column++;   
                
                
            }
            $ipoint++;
            
            //echo "<br>";
            $row++;            
        }
        //----------------------------End section 7--------------------//

        //-----------------------------Section 8. ----------------//
        echo "section 8 <br>";
       
        $row = $row_shift*$shift_no+24;
        $ipoint = 226; //start point_id
        $value = $worksheet->getCell("AI".$row);
        $time = trim(str_replace("น.", "", $value)).".00";
        $datetime_record = $date_record." ".$time;

        $id = "BK-000".$ipoint ;
        $value = $worksheet->getCell("AK".$row);
        //echo($value);
        PointValueTbController::addModel($id,$datetime_record,$value);
        $ipoint++;

        $id = "BK-000".$ipoint ;
        $value = $worksheet->getCell("AN".$row);
        PointValueTbController::addModel($id,$datetime_record,$value);
        
        //----------------------------End section 8--------------------//

        //-----------------------------Section 9. ---------------------//
        echo "section 9 <br>";
       
        $row = $row_shift*$shift_no+28;
        $ipoint = 228; //start point_id
        $nparam = 6;
        $datetime_record = $date_record." ".$time_record;
        //no sample
        for ($i=0; $i < $nparam; $i++) { 
        	$value = $worksheet->getCell("B".$row);
        	$id = "BK-000".$ipoint ;
        	PointValueTbController::addModel($id,$datetime_record,$value);
        	echo $datetime_record."=".$id.":".$value." | ";
        	$ipoint++;
        	$row++;
        }

        $row = $row_shift*$shift_no+28;
        $ipoint = 475; //start point_id
        $nparam = 6;
        $datetime_record = $date_record." ".$time_record;
        //no NC
        for ($i=0; $i < $nparam; $i++) { 
        	$value = $worksheet->getCell("C".$row);
        	$id = "BK-000".$ipoint ;
        	PointValueTbController::addModel($id,$datetime_record,$value);
        	echo $datetime_record."=".$id.":".$value." | ";
        	$ipoint++;
        	$row++;
        }
        
        //----------------------------End section 9--------------------//

        //-----------------------------Section 10 ---------------------//
        echo "<br>section 10 <br>";
        switch ($shift) {
        	case '00:00-08:00':
        		$time = array("00.00","04.00");
        		break;

        	case '08:00-16:00':
        		$time = array("08.00","12.00");
        		break;
        		
        	case '16:00-24:00':
        		$time = array("16.00","20.00");
        		break;		
        	
        	default:
        		$time = array("00.00","04.00");
        		break;
        }

        $row = $row_shift*$shift_no+28;
        $nparam = 7;
       
        
        for ($i=0; $i < 2; $i++) { 
        	$datetime_record = $date_record." ".$time[$i];
        	//echo $datetime_record."<br>";
        	$ipoint = 234;
        	$column = 'AI';

        	for ($j=0; $j < $nparam; $j++) {
        	    if($j==$nparam-1){
        	       $column++;
        	    }
        		//echo $column.$row."|";
        		$value = $worksheet->getCell($column.$row);
	        	$id = "BK-000".$ipoint ;
	        	PointValueTbController::addModel($id,$datetime_record,$value);
	        	//echo $datetime_record."=".$id.":".$value." | ";
	        	$column++;
	        	$ipoint++;
        	}
        	
        	$row++;
        }

        $row = $row_shift*$shift_no+30;
        $datetime_record = $date_record." ".$time[0];
        for ($i=0; $i < 3; $i++) { 
        
	        $column = 'AF';
	        for ($j=0; $j < 2; $j++) { 
	        	$id = "BK-000".$ipoint ;
	        	//echo $column.$row."|";
	        	$value = $worksheet->getCell($column.$row);
		        PointValueTbController::addModel($id,$datetime_record,$value);
		        //echo $id.":".$value." | ";
		        $column++;
		        $ipoint++;
	        }
	        $row++;
        }

        $row = $row_shift*$shift_no+31;
        $datetime_record = $date_record." ".$time[0];
        for ($i=0; $i < 2; $i++) { 
        
	        $column = 'AI';
	        for ($j=0; $j < 4; $j++) { 
	        	$id = "BK-000".$ipoint ;
	        	//echo $column.$row."|";
	        	$value = $worksheet->getCell($column.$row)->getCalculatedValue();
	        	$value = number_format($value,2);	        	
		        PointValueTbController::addModel($id,$datetime_record,$value);
		        //echo $id.":".$value." | ";
		        $column++;
		        $column++;
		        $ipoint++;
	        }
	        $row++;
        }
        //----------------------------End section 10--------------------//

        //-----------------------------Remark---------------------------//
        $row = $row_shift*$shift_no+25;
        $column = 'H';
        $datetime_record = $date_record." ".$time_record;       
        $id = "BK-000474";

        for ($i=0; $i < 3; $i++) { 
        	$value = $worksheet->getCell($column.$row);
        	if($value!="")
        	{
        	  PointValueTbController::addModel($id,$datetime_record,$value);	
        	  echo $id.":".$value." | ";
        	}
        	$row++;
        }

        //----------------------------End Remark-----------------------//
    */
    //}
?>
