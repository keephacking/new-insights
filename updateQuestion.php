<?php 
ob_start();
require_once 'include/lib.php';
$qid=$_POST['qid'];
$question    =new item_class();
$question->set('questions',$qid);
$filter      =new filter_class();
if(isset($_POST['tags'])){
$tags        =$_POST['tags'];
}
else $tags=false;

 $title=$filter->sanitizeString($_POST['title']);
 $body=$filter->escape($_POST['body']);
 $out=array("");
        if(!$title && !$body)
        {
            $out=array("out"=>"uh-oh :-) you forgot to enter Title and its description ");
        }
        elseif(!$title)
            $out=array("out"=>"Title is needed");
        elseif(!$body)
            $out=array("out"=>"Description is Needed");
        else
        {
        $res=$question->sql_query("BEGIN WORK;");
         
            if(!$res)
            {
                //Damn! the query failed, quit
                $out=array("out"=>'An error1 occured while creating your topic. Please try again later.');
            }
            else
            {
    
                 if(strlen($title)<10 || strlen($body)<10 || strlen($title)>250)
                 {
                    $out=array("out"=>"Your Question must be between 10 and 10000 charecters!");

                 } 
                else
                    {
                    $time=date('Y-m-d H:i:s',time());
					$data=array("title"=>$title,"body"=>$body,"last_activity_date"=>$time);
                    $question->update($data);
                    
                    if(!$question->result)
                    {
                        //something went wrong, display the error
                       $out=array("out"=>'An error2 occured while inserting your data. Please try again later.' );    
                        $sql = "ROLLBACK;";
                        $question->sql_query($sql);
                    }
                    else
                    {
                   	
                     $sql = "COMMIT;";
                            $question->sql_query($sql);
                            $out=array("out"=>"success");
 /***************Find the id of tags*********************/
                    
                   if(!empty($tags)){
                      $tagObj=new item_class();
                      $tagObj1=new item_class();
                      $tagObj2=new item_class();
                      $tagObj2->set("question_tags");
                      $tagObj3=new item_class();
                    
                      foreach ($tags as $key=>$value)
                      {
                      	
                      $tagObj->sql_query("select * from tags where tag='$value'");
                      $row=$tagObj->load_datas();
                      $tid=$row['id'];
                      
                         $tagObj1->sql_query("select * from question_tags where tid=$tid and qid=$qid");
                        
                         if($tagObj1->num_rows==0){
                         	$data=array("qid"=>$qid,"tid"=>$tid);
                         	$tagObj2->insert($data);
                         	$data=null;
                         	if($tagObj2->affected_rows>0){
                         		$tagObj3->sql_query("update tags set maxpost=maxpost+1 where id=$tid");//update maxpost in tags
                         	}
                         	
                         }
                     
                      }
                      
                   }
                             
                            //after a lot of work, the query succeeded!
                         //$out=array("out"=>'You have successfully updated the question');
                    }
                }
            }    
        }
 ob_end_clean();
 echo json_encode($out);
      
?>