<?php
// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

// Store model to not repeat query.
private $_model;

// Return
// access it by Yii::app()->user->username
function getUsername(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->username;
   // return $user->title." ".$user->firstname." ".$user->lastname;
}

function getGroup(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->user_group_id;
    
}
// access it by Yii::app()->user->title
// function getTitle(){
//     $user = $this->loadUser(Yii::app()->user->id);
//     return $user->title;
    
// }
// access it by Yii::app()->user->firstname
function getName(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->first_name." ".$user->last_name;
    
}
// access it by Yii::app()->user->lastname
// function getLastName(){
//     $user = $this->loadUser(Yii::app()->user->id);
//     return $user->lastname;
    
// }


// access it by Yii::app()->user->usertype
function getUsertype(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if(Yii::app()->user->id == 0)
    {  
        
        return "guest";     
    }
    else    
         return "user";
}


 function isAdmin(){
    //$user = $this->loadUser(Yii::app()->user->id);
    return Yii::app()->user->id == "1";
    //return UserModule::isAdmin();
  }

function isUser(){
    $user = $this->loadUser(Yii::app()->user->id);
    return !empty($user);
    //return UserModule::isAdmin();
}




// Load user model.
protected function loadUser($id=null)
{
    if($this->_model===null)
    {
        if($id!==null)
            $this->_model=UsersInfoTb::model()->findByPk($id);
        else
        {
            $this->_model = new UsersInfoTb();
            $this->_model->username = "Guest";
          
        }
    }
    return $this->_model;
}

}
?>
