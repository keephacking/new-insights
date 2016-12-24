<?php
require_once 'table.class.php';
require_once 'mail.php';
class user_class extends table
{
    public $id=null;
    public $loggedin=null;

	public  function registration()
	{
		$this->set("users");
		$data =array("username"=>$this->username,"email"=>$this->email,"password"=>$this->password,"active"=>$this->active);
		$this->insert($data);
		if($this->affected_rows==1)
		{
			$this->id=$this::$link->insert_id;
			return true;
		}
		else{
			return false;
		}
	}

	public function check_user($email){
		$this->sql_query("select * from users where email='$email' and active=1") or
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
	public function activate_mail(){
		$email=$this->email;
		$body=file_get_contents("activate_mail.php");

		$body.='<a href=http://localhost:3333/proj/login.php?new=true&id='.$this->id.'&x='.$this->active.' style="text-decoration: none;display: inline-block;background-color: #06f;color: white;padding: 10px 20px;border-radius: 5px;">here</a>';

		$body.='</div></div> <div class="footer" style="max-width: 500px;background-color: #eee;font-family: sans-serif;margin: 0 auto;overflow: hidden;border-radius: 5px;text-align: center;padding: 20px;font-size: 12px;">
		If You cannot activate by the above link.Send us a message at <a style="color: #3087f5;">reply@insights.com</a></div></div></body></html>';

		$mess="Confirmation mail has been send to your email id!";
		return smtpmailer($email,'discuss-no-reply@outlook.in','NewInsights','ACTIVATION OF NEW INSIGHTS', $body,$mess);

	}

	public function activate_user(){
		$this->sql_query("select * from users where id=$this->id and active='$this->x'");

		if($this->num_rows==1){
			$this->sql_query("update users set active=1 where id=$this->id and active='$this->x'");
		  if($this->affected_rows>0)
			return true;
		  else return false;
		}
		else return false;
	}
	/*******************reputation of users***********************/
	public function ansUpVote($clear=NULL){
	   if($clear==1){
			$rep=array("reputation"=>$this->reputation-15);
			$this->update($rep);

		}
		else{
	     $rep=array("reputation"=>$this->reputation+15);
	     $this->update($rep);
		}
	}
	public function ansDownVote($clear=NULL){
		if($clear==1){
			$rep=array("reputation"=>$this->reputation+5);
			$this->update($rep);
		}
		else{
	      $rep=array("reputation"=>$this->reputation-5);
	      $this->update($rep);
		}
	}
	public function quesUpVote($clear=NULL){
		if($clear==1){
			$rep=array("reputation"=>$this->reputation-15);
			$this->update($rep);
		}
		else{
		$rep=array("reputation"=>$this->reputation+15);
		$this->update($rep);
		}

	}
	public function quesDownVote($clear=NULL){
		if($clear==1){
			$rep=array("reputation"=>$this->reputation+5);
			$this->update($rep);
		}
		else{
		$rep=array("reputation"=>$this->reputation-5);
		$this->update($rep);
		}
	}
	/******************reputation*********************************/


	/*******************user tag score***************************/
   public function newAnsTagScore($tid){

         $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
         if($this->num_rows>0){
           $this->sql_query("update user_tag_score set score=score+4 where tid=$tid and uid=$this->id");
         }
         else{
           $this->sql_query("insert into user_tag_score (uid,tid,score) values ($this->id,$tid,4)");
         }
   }
   public function newQuesTagScore($tid){
     $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
     if($this->num_rows>0){
       $this->sql_query("update user_tag_score set score=score+2 where tid=$tid and uid=$this->id");
     }
     else{
       $this->sql_query("insert into user_tag_score (uid,tid,score) values ($this->id,$tid,2)");
     }
   }
   public function ansScoreOnVote($tid,$vote){
     if($vote==1){
           $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
           if($this->num_rows>0){
              $this->sql_query("update user_tag_score set score=score+10 where tid=$tid and uid=$this->id");
          }
          else $this->sql_query("insert into user_tag_score (tid,uid,score) values($tid,$this->id,10)");
     }
     else{
           $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
           if($this->num_rows>0){
             $this->sql_query("update user_tag_score set score=score-10 where tid=$tid and uid=$this->id");
          }
          else $this->sql_query("insert into user_tag_score (tid,uid,score) values($tid,$this->id,-10)");
     }
   }
   public function quesScoreOnVote($tid,$vote){
     if($vote==1){
         $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
         if($this->num_rows>0){
          $this->sql_query("update user_tag_score set score=score+5 where tid=$tid and uid=$this->id");
        }
        else $this->sql_query("insert into user_tag_score (tid,uid,score) values($tid,$this->id,5)");
     }
     else{
         $this->sql_query("select * from user_tag_score where uid=$this->id and tid=$tid");
         if($this->num_rows>0){
          $this->sql_query("update user_tag_score set score=score-5 where tid=$tid and uid=$this->id");
         }
         else {
            $this->sql_query("insert into user_tag_score (tid,uid,score) values($tid,$this->id,'-5')");
         }
     }
   }
	/*******************user tag score end***************************/


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
