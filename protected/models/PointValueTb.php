<?php

/**
 * This is the model class for table "point_value_tb".
 *
 * The followings are the available columns in table 'point_value_tb':
 * @property string $id
 * @property string $point_id
 * @property string $datetime_record
 * @property string $point_prefix_value
 * @property string $point_float_value
 * @property string $point_text_value
 * @property string $user_id
 * @property string $status_flag
 * @property string $remark
 * @property string $created_date
 * @property string $modified_date
 */
class PointValueTb extends CActiveRecord
{
	
	public $category_id,$section_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'point_value_tb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('point_id, datetime_record, user_id', 'required'),
			array('point_id', 'length', 'max'=>9),
			array('point_prefix_value, point_float_value', 'length', 'max'=>255),
			array('user_id', 'length', 'max'=>8),
			array('status_flag', 'length', 'max'=>1),
			array('point_text_value, remark, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, point_id, datetime_record, point_prefix_value, point_float_value, point_text_value, user_id, status_flag, remark, created_date, modified_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'point_main'=>array(self::BELONGS_TO, 'PointsMainTb', 'point_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'point_id' => 'Point',
			'datetime_record' => 'วันเวลาที่บันทึก',
			'point_prefix_value' => 'Point Prefix Value',
			'point_float_value' => 'value',
			'point_text_value' => 'value',
			'user_id' => 'User',
			'status_flag' => 'Status Flag',
			'remark' => 'Remark',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('point_id',$this->point_id,true);
		$criteria->compare('datetime_record',$this->datetime_record,true);
		$criteria->compare('point_prefix_value',$this->point_prefix_value,true);
		$criteria->compare('point_float_value',$this->point_float_value,true);
		$criteria->compare('point_text_value',$this->point_text_value,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status_flag',$this->status_flag,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		if(!empty($this->datetime_record))
		{
			$from_date = $this->datetime_record." 00:00:00";
			$end_date = $this->datetime_record." 23:59:00";

			$criteria->addBetweenCondition('datetime_record', $from_date, $end_date);


			//$criteria->condition = "datetime_record  >= '$from_date' and datetime_record <= '$end_date'";

		}
		else{
			$criteria->compare('datetime_record',$this->datetime_record,true);
		}
			

		//$criteria->compare( 'point_main.category_id', $this->category_id, true );
		//$criteria->compare( 'point_main.section_id', $this->section_id, true );


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
		        'defaultOrder' => 'id DESC',
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PointValueTb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDate($m)
    {
                
        return substr($m->datetime_record, 0,16);
    }

    public function getPointName($m)
    {
        $point_main = PointsMainTb::model()->findAll('point_id=:id', array(':id' => $m->point_id)); 
        $name = empty($point_main[0]) ? "" : $point_main[0]->point_name;   
 

        return $name;
    }

    public function getCategoryName($m)
    {
        $point_main = PointsMainTb::model()->findAll('point_id=:id', array(':id' => $m->point_id)); 
        $category  =  CategoryTb::model()->findAll('category_id=:id', array(':id' => $point_main[0]->category_id)); 
        $name = empty($category[0]) ? "" : $category[0]->category_name;   

        return $name;
    }

    public function getSectionName($m)
    {
        $point_main = PointsMainTb::model()->findAll('point_id=:id', array(':id' => $m->point_id)); 
        $section  =  SectionTb::model()->findAll('section_id=:id', array(':id' => $point_main[0]->section_id)); 
        $name = empty($section[0]) ? "" : $section[0]->section_name;   
 

        return $name;
    }
}
