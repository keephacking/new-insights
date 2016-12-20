<?php require_once 'include/lib.php';
$question    =new item_class();
$question->set('questions');
$tag_insert  =new item_class();
$tag_insert->set('tags');
$filter      =new filter_class();
if(isset($_POST['tags'])){
	$tags=$_POST['tags'];
}

$owner_id    =$_POST['owner_id'];
$user=new user_class();
$user->id=$owner_id ;

 $title=$filter->sanitizeString($_POST['title']);
 $body=$filter->escape($_POST['myTextArea']);

        if(!$title && !$body)
        {
            echo "uh-oh :-) you forgot to enter Title and its description ";
        }
        elseif(!$title)
            echo "Title is needed";
        elseif(!$body)
            echo "Description is Needed";
        else
        {
        $res=$question->sql_query("BEGIN WORK;");

            if(!$res)
            {
                //Damn! the query failed, quit
                echo 'An error1 occured while creating your topic. Please try again later.';
            }
            else
            {

                 if(strlen($title)<10 || strlen($body)<10 || strlen($title)>250)
                 {
                    echo "Your Question must be between 10 and 10000 charecters!";

                 }
                else
                    {

					$data=array("title"=>$title,"body"=>$body,"owner_id"=>$owner_id);
                    $question->insert($data);

                    $qid=$question::$link->insert_id; //id of the question inserted

                    if(!$question->result)
                    {
                        //something went wrong, display the error
                        echo 'An error2 occured while inserting your data. Please try again later.' ;
                        $sql = "ROLLBACK;";
                        $question->sql_query($sql);
                    }
                    else
                    {

                     $sql = "COMMIT;";
                            $question->sql_query($sql);



 /****************Find the id of tags*********************/
                      $tag_insert->set('question_tags');
                      $tagObj=new item_class();
                      foreach ($tags as $key=>$value)
                      {
                      $tag_insert->sql_query("select * from tags where tag='$value'");
                      $row=$tag_insert->load_datas();
                      $tag_id=$row['id'];

											/**************update tag score on users**********/
											 $user->newQuesTagScore($tag_id);
                      $tagObj->sql_query("update tags set maxpost=maxpost+1 where id=$tag_id");//update maxpost in tags

                      $data=array("qid"=>"$qid","tid"=>"$tag_id","uid"=>$owner_id);
                      $tag_insert->insert($data);
                      $data=null;
                      }

                            //after a lot of work, the query succeeded!
                            echo 'You have successfully entered the question';
                            header("location:question.php?id=$qid");

                    }
                }
            }
        }

?>
