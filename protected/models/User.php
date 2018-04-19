<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $position
 * @property string $username
 * @property string $password
 * @property integer $approver
 * @property integer $plant
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, position, username, password, plant', 'required'),
			array('approver, plant', 'numerical', 'integerOnly'=>true),
			array('name, position', 'length', 'max'=>500),
			array('username, password', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, position, username, password, approver, plant', 'safe', 'on'=>'search'),
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
			'name' => 'ชื่อ-นามสกุล',
			'position' => 'ตำแหน่ง',
			'username' => 'ชื่อผู้ใช้งาน',
			'password' => 'รหัสผ่าน',
			'approver' => 'ผู้อนุมัติ',
			'plant' => 'โรงงานผลิตน้ำ',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('approver',$this->approver);
		$criteria->compare('plant',$this->plant);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
    {
        return ($password)===$this->password;
    }
    
    public function beforeSave()
    {
        
            //$this->password= sha1($this->password);
            $this->password= ($this->password); 
            return parent::beforeSave();
    }

    protected function afterFind(){

		parent::afterFind();
		
	}

}
