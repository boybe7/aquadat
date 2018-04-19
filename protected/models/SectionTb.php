<?php

/**
 * This is the model class for table "section_tb".
 *
 * The followings are the available columns in table 'section_tb':
 * @property string $id
 * @property string $plant_id
 * @property string $station_id
 * @property string $section_id
 * @property string $section_name
 * @property string $section_desc
 */
class SectionTb extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'section_tb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plant_id, station_id, section_id, section_name, section_desc', 'required'),
			array('plant_id', 'length', 'max'=>11),
			array('station_id, section_id', 'length', 'max'=>14),
			array('section_name, section_desc', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, plant_id, station_id, section_id, section_name, section_desc', 'safe', 'on'=>'search'),
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
			'section_name' => 'Section Name',
			'section_desc' => 'Section Desc',
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
		$criteria->compare('section_name',$this->section_name,true);
		$criteria->compare('section_desc',$this->section_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SectionTb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
