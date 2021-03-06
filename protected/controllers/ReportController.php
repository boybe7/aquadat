<?php


class ReportController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout='//layouts/main';

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
	public function actionGraph()
	{		
		$this->render('_formGraph');
	}

    public function actionDailyReport()
	{		
		$this->render('_reportDaily');
	}

	public function actionGenDailyReport()
	{
        $date_record = $_GET["date"];
        $shift = $_GET["shift"];
        
        $str = explode("-",$shift);
        $time_begin = $str[0];
        $time_end = $str[1];

		$date_begin = $date_record ." ".$time_begin;
        $date_end = $date_record ." ".$time_end;
        $date = new DateTime($date_end);
        $date->modify('-1 minutes');
        $date_end = $date->format('Y-m-d H:i') ;
        //echo $date_begin.":".$date_end;
		

		$models = PointValueTb::model()->findAll(array('order'=>'point_id ASC','condition'=>'datetime_record BETWEEN "'.$date_begin.'" AND "'.$date_end.'"', 'params'=>array()));

		//print_r($models);

		$model_array = array();
		foreach ($models as $model) {

			$models = PointsMainTb::model()->findAll(array('condition'=>'point_id="'.$model->point_id.'"'));
        	//get value type
        	$point_type = $models[0]->point_type_id;

        	if($point_type=="POINT-TYPE-001")
			{
				$model_array[$model->point_id]["value"] = $model->point_float_value;
			} 
			else{
				$model_array[$model->point_id]["value"] = $model->point_text_value;
			} 

			$model_array[$model->point_id]["datetime_record"] = $model->datetime_record; 
		}

		

		$this->render('dailyReport',array(
		 	'models'=>$model_array,'date_begin'=>$date_begin,'date_end'=>$date_end,'date_record'=>$date_record,'shift'=>$shift
		 ));

	}
	
	public function actionDrainReport()
	{		
		$this->render('_reportDrain');
	}

	public function actionGenDrainReport()
	{
    	$month = $_GET["month"];
        $year = $_GET["year"];
		$this->renderPartial('_formDrainReport', array(
			'month'=>$month,
            'year'=>$year,
            'display' => 'block',
        ), false, true);
	}

}

?>