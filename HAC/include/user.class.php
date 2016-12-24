<?php 
require_once 'table.class.php';
class user_class extends table
{
    public $id=null;
    public $loggedin=null;

	public  function registration()
	{
		$this->set("users");
		$data =array("username"=>$this->username,"email"=>$this->email,"password"=>$this->password);
		$this->insert($data);
		if($this->affected_rows==1)
		{
			return true;
		}
		else{
			return false;
		}
	}

	public function check_user($email){
		$this->sql_query("select * from users where email='$email'") or
		trigger_error("MySQL Error: ". parent::$link->error);

		if( $this->num_rows==1)
		{
			$registered=true;
		}
		else{
			$registered =false;
		}
		return $registered;
	}


	public function user_login($email,$password){
		$mess='false';
		if($this->check_user($email))
		{
			$this->sql_query("SELECT * FROM users WHERE email='$email' and password='$password'") or
			trigger_error("MySQL Error: " . parent::$link->error);
			
			if($this->num_rows==1)
			{
				$id=$this->load_datas();
				$this->id=$id['id'];
				session_start();
					$_SESSION['id'] =$this->id;
					return true;

			}
			else 
			{
				$mess= "Wrong password";
				return $mess;
			}

		}
		else
		{
			$mess="this is not a registered mail id";
			return $mess;
		}
	}
	
	public function goOnline(){
		$this->table="users";
		$this->table_id=$this->id;
		$status=array("status"=>1);
		$this->update($status);
		return 1;
	}
	public function goOffline(){
		$this->table="users";
		$this->table_id=$this->id;
		$status=array("status"=>0);
		$this->update($status);
		return 0;
	}

}
?>