<?php

/**
 * This is the model class for table "users_info_tb".
 *
 * The followings are the available columns in table 'users_info_tb':
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $position
 * @property string $username
 * @property string $password
 * @property string $user_group_id
 * @property string $approver
 */
class UsersInfoTb extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_info_tb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, first_name, last_name, position, password, user_group_id', 'required'),
			array('user_id', 'length', 'max'=>8),
			array('first_name, last_name, position, password', 'length', 'max'=>255),
			
			array('user_group_id', 'length', 'max'=>14),
			array('approver', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, first_name, last_name, position,  password, user_group_id, approver', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'position' => 'Position',
			//'username' => 'Username',
			'password' => 'Password',
			'user_group_id' => 'User Group',
			'approver' => 'Approver',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('position',$this->position,true);
		//$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_group_id',$this->user_group_id,true);
		$criteria->compare('approver',$this->approver,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersInfoTb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
    {
        return hash( 'sha256', $password )===$this->password;
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
