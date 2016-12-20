<?php require_once 'include/lib.php';
$answer    =new item_class();
$filter    =new filter_class();

if(isset($_POST['aid'])){
	
$aid         =$_POST['aid'];
$qid         =$_POST['qid'];
$answer->set('answers',$aid);
$body        =$answer::$link->real_escape_string($_POST['myTextArea']);
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
	                    $date=time();	
						$data=array("last_edited_date"=>$date,"body"=>$body);
						
	                    $answer->update($data);	                    
	                    
	                    if(!$answer->result)
	                    {
	                        //something went wrong, display the error
	                        echo 'An error occured while inserting your data. Please try again later.' ;    
	                        $sql = "ROLLBACK;";
	                        $answer->sql_query($sql);
	                    }
	                    else
	                    {
	                   	
                            $sql = "COMMIT;";
                            $answer->sql_query($sql);   
                            //after a lot of work, the query succeeded!
                            echo 'You have successfully entered your answer';
                            header("Location:question.php?id=$qid");
                        
                       }
                 }
          }    
      }
}     
?>