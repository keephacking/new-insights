<?php
ob_start();
require_once 'include/lib.php';
if(isset($_POST['tid'])&& isset($_POST['qid'])){
	$tagObj=new item_class();
	$tid=$_POST['tid'];
	$qid=$_POST['qid'];
	$tagObj->set("question_tags",$tid);
	$out=array("");
}
else die();


if(isset($_POST['action'])){	
	if($_POST['action']=='add'){

		$tagObj->sql_query("select * from question_tags where qid=$qid and tid=$tid") ;
			  if($tagObj->num_rows==0)
			  {
					$data=array("qid"=>$qid,"tid"=>$tid);
					$tagObj->insert($data);
					if($tagObj->affected_rows>0){
						$tagObj->sql_query("update tags set maxpost=maxpost+1 where id=$tid");
						$out=array("out"=>"success","tid"=>$tid);					
					}
					else $out=array("out"=>"error");					
			  
			 }
		
	}	
   if($_POST['action']=='del'){
		$tagObj->sql_query("delete from question_tags where tid=$tid and qid=$qid");
		if($tagObj->affected_rows>0){
			$tagObj1=new item_class();
			$tagObj1->sql_query("update tags set maxpost=maxpost-1 where id=$tid");
			if($tagObj1->result)
				$out=array("out"=>"success");
		    else $out=array("out"=>"error");
		}
		else $out=array("out"=>"error");
   }
 ob_end_clean();
   echo json_encode($out);
}

?>