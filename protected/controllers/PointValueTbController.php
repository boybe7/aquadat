<?php

class PointValueTbController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','dailyReport','import'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PointValueTb;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PointValueTb']))
		{
			$model->attributes=$_POST['PointValueTb'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PointValueTb']))
		{
			$model->attributes=$_POST['PointValueTb'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new PointValueTb('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PointValueTb']))
			$model->attributes=$_GET['PointValueTb'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PointValueTb('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PointValueTb']))
			$model->attributes=$_GET['PointValueTb'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PointValueTb::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='point-value-tb-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionDailyReport()
	{
		
		$day = 23;
		$month = 'กุมภาพันธ์';
		$year = 2561;

		$date_begin = "2018-03-01 08:00:00";
		$date_end = "2018-03-01 15:59:59";
		$shift = "08.00-16.00";

		$date_record = "2018-03-01";

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

		

		$this->render('daily_report',array(
		 	'models'=>$model_array,'date_begin'=>$date_begin,'date_end'=>$date_end,'date_record'=>$date_record,'day'=>$day,'month'=>$month,'year'=>$year,'shift'=>$shift
		 ));

		

	}

	public function postCl2($value='')
	{
		//echo $value."<br>";
		$shift_data = explode(">", $value);
		//print_r($shift_data);
		$data_return = array();
		$i = 0;
		foreach ($shift_data as $key => $value) {
			//echo $value."<br>";
			if( preg_match( '/\[([^\]]*)\]/', $value, $match ) )
    		{
    			$time = $match[1];
    			//echo $time."<br>";
    			$data_return[$i]["time"] = $time;
    		}	

    		$end = strpos($value, "]");
    		$data = substr($value, $end+1);
    		//echo $data."<br>";
    		$lines = array();
    		$tps = 0;
    		$iline = 0;
    		while( preg_match( '!\(([^\)]+)\)!', $data, $match ) )
   			{
   				//echo $match[1]."<br>";
                $value = explode("+", $match[1]);
                $lines[$iline] = $value[0];
                $tps = $value[1]; 
   				$end = strpos($data, ")");
    		    $data = substr($data, $end+1);
    		    //echo $data."<br>";
    		    $iline++;
   			}	 	

   			//print_r($lines);
   			//echo "tps=".$tps;
   			$data_return[$i]["lines"] = $lines;
   			$data_return[$i]["tps"] = $tps;

   			$i++;
		}

		// echo("<pre>");
		// print_r($data_return);
		// echo("</pre>");


		return $data_return;
	}

	public function actionImport()
	{
	
		$this->render('import_daily_report');

	}

	public function addModel($id,$datetime_record,$value)
	{
		//check for update data
        $models = PointsMainTb::model()->findAll(array('condition'=>'point_id="'.$id.'"'));
        //get value type
        $point_type = $models[0]->point_type_id;
        $models = PointValueTb::model()->findAll(array('condition'=>'point_id="'.$id.'" AND datetime_record="'.$datetime_record.'"'));

		if($value!="")
			if(empty($models))
			{
								//insert data
								$model = new PointValueTb;
								$model->point_id = $id;
								$model->datetime_record = $datetime_record;
								$model->user_id = "import";
								$today = date("Y-m-d H:i:s");  
								$model->created_date = $today;

								if($point_type=="POINT-TYPE-001")
								{
									$model->point_float_value = $value;
								} 
								else{
									$model->point_text_value = $value;
								} 
								
								

								if(!$model->save())  
								{
									echo "<pre>";print_r($model); echo "</pre>";
									print_r($model->getErrors());    
								}              
									
									
			}
			else
			{
								//update]
								//print_r($models);   
								// $models[0]->user_id = "import";
								// $today = date("Y-m-d H:i:s");  
								// $models[0]->created_date = $today; 

								// if($point_type=="POINT-TYPE-001")
								// {
								//    $models[0]->point_float_value = $value;
								// } 
								// else{
								//    $models[0]->point_text_value = $value;
								// }  

								// if(!$models[0]->save())
								// {
								// 	echo "<pre>";print_r($models[0]); echo "</pre>";
								// 	print_r($models[0]->getErrors()); 
								// }
									
			}

	}
}
