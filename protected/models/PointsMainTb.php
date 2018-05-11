<?php

/**
 * This is the model class for table "points_main_tb".
 *
 * The followings are the available columns in table 'points_main_tb':
 * @property string $id
 * @property string $plant_id
 * @property string $station_id
 * @property string $section_id
 * @property string $sub_section_id
 * @property string $category_id
 * @property string $point_id
 * @property string $point_name
 * @property string $point_unit
 * @property string $point_prefix_id
 * @property string $point_type_id
 * @property string $display_id
 * @property string $time_id
 * @property string $remark
 * @property string $ref_sheet
 * @property string $created_date
 * @property string $modified_date
 */
class PointsMainTb extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'points_main_tb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plant_id, station_id, section_id, sub_section_id, category_id, point_id, display_id, time_id, remark', 'required'),
			array('plant_id, display_id', 'length', 'max'=>11),
			array('station_id, section_id', 'length', 'max'=>14),
			array('sub_section_id', 'length', 'max'=>18),
			array('category_id', 'length', 'max'=>15),
			array('point_id', 'length', 'max'=>9),
			array('point_name, point_unit, point_prefix_id, point_type_id, remark, ref_sheet', 'length', 'max'=>255),
			array('time_id', 'length', 'max'=>8),
			array('created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plant_id, station_id, section_id, sub_section_id, category_id, point_id, point_name, point_unit, point_prefix_id, point_type_id, display_id, time_id, remark, ref_sheet, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'category'=>array(self::BELONGS_TO, 'CategoryTb', 'category_id'),
			'point_value'=>array(self::BELONGS_TO, 'PointValueTb', 'point_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'plant_id' => 'Plant',
			'station_id' => 'Station',
			'section_id' => 'Section',
			'sub_section_id' => 'Sub Section',
			'category_id' => 'Category',
			'point_id' => 'Point',
			'point_name' => 'Point Name',
			'point_unit' => 'Point Unit',
			'point_prefix_id' => 'Point Prefix',
			'point_type_id' => 'Point Type',
			'display_id' => 'Display',
			'time_id' => 'Time',
			'remark' => 'Remark',
			'ref_sheet' => 'Ref Sheet',
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
		$criteria->compare('plant_id',$this->plant_id,true);
		$criteria->compare('station_id',$this->station_id,true);
		$criteria->compare('section_id',$this->section_id,true);
		$criteria->compare('sub_section_id',$this->sub_section_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('point_id',$this->point_id,true);
		$criteria->compare('point_name',$this->point_name,true);
		$criteria->compare('point_unit',$this->point_unit,true);
		$criteria->compare('point_prefix_id',$this->point_prefix_id,true);
		$criteria->compare('point_type_id',$this->point_type_id,true);
		$criteria->compare('display_id',$this->display_id,true);
		$criteria->compare('time_id',$this->time_id,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('ref_sheet',$this->ref_sheet,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PointsMainTb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
