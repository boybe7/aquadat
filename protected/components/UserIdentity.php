<?php
/**
************************************
Program ID : LOG_01
Create By : Atitep
Create Date :
*********** Change Logs ************
Update By :
Update Date :
Update Detail :
----------- Unit Test --------------
     No.                 Result
1.Test 1
2.Test 2
3.Test 3
************************************
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
//	public function authenticate()
//	{
//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
//	}
    
    
    private $_id;
    
    public function authenticate()
    {
        $username= $this->username;
        //$username = '00100898';
        $user=UsersInfoTb::model()->find('(user_id)=?',array($username));
        //     header('Content-type: text/plain');
        //    print_r($user);          
        // exit;


        if($user===null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if(!$user->validatePassword($this->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id=$user->id;
            $this->username=$user->user_id;
            $this->errorCode=self::ERROR_NONE;

       }
        return $this->errorCode==self::ERROR_NONE;

        
    }
    
    public function getId()
    {
        return $this->_id;
    }

}