<?php require_once 'include/lib.php';
$answer    =new item_class();
$filter    =new filter_class();
$answer->set('questions');



$qid         =$_POST['qid'];
$uid         =$_POST['uid'];
$user=new user_class();
$user->id=$uid;
$body        =$filter->escape($_POST['myTextArea']);


        if(!$body){
            echo "Where is the Answer!";
            echo $body;
        }
        else
        {
        $res=$answer->sql_query("BEGIN WORK;");

            if(!$res)
            {
                //Damn! the query failed, quit
                echo 'An error occured while creating your topic. Please try again later.';
            }
            else
            {

                 if( strlen($body)<10 )
                 {
                    echo "Your Answer should be in between 10 and 10000 charecters!";

                 }
                else
                    {
	                    //$date=time();
	                    //"date_created"=>$date,
						$data=array("qid"=>$qid,"uid"=>$uid,"body"=>$body);
						$answer->set('answers');
	                    $answer->insert($data);
	                    $aid=$answer::$link->insert_id;


	                    if(!$answer->result)
	                    {
	                        //something went wrong, display the error
	                        echo 'An error occured while inserting your data. Please try again later.' ;
	                        $sql = "ROLLBACK;";
	                        $answer->sql_query($sql);
	                    }
	                    else
	                    {

	                    	$owner=new item_class();
	                    	$owner->set("notification");

	                    	$question=new item_class();
							          $question->sql_query("CALL updateAnswerCount($qid,1)");

                            $sql = "COMMIT;";
                            $answer->sql_query($sql);
                /**************update tag score on users**********/
                          $answer->sql_query("select * from question_tags where qid=$qid");
                          while($tag_data=$answer->load_datas()){
                            $user->newAnsTagScore($tag_data['tid']);
                          }
                            //after a lot of work, the query succeeded!
                            echo 'You have successfully entered your answer';



                            $owner->sql_query("select owner_id,title from questions where id=$qid");
                            $owner_data=$owner->load_datas();
                            $fid=$owner_data['owner_id'];
                            $q_title=substr($owner_data['title'],0,25);
                            $q_title.="...";
                            if($fid!=$uid){
                            	$insertNot=array("message"=>$q_title,"aid"=>$aid,"fid"=>$uid,"uid"=>$fid,"qid"=>$qid);
                            	$owner->insert($insertNot);
                            }


                            header("Location:question.php?id=$qid");

                    }
                }
            }
        }

?>
