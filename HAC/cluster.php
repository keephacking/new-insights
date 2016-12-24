<?php
ob_start();
session_start();

require ("/include/lib.php");
require ("HAC.php");
$user=new user_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();

}
else {
	$user->loggedin=false;
	$user->status=0;
}

if(isset($_GET['logout']) && $user->loggedin)
{
	if($_GET['logout']==true){
		$user->goOffline();
		session_destroy();
		header("Location:login.php");
	}
}

$prepare=new item_class();

if(isset($_POST["prepare"])){
 $prepare->sql_query("CALL prepareTable()");
 $prepare->sql_query("select * from post_counter where id=1");
 $data=$prepare->load_datas();
 ob_end_clean();
 echo json_encode($data);
}
if(isset($_POST['prev'])){
  $prepare->sql_query("select * from post_counter where id=1");
  $data=$prepare->load_datas();
ob_end_clean();
 echo json_encode($data);
}
if(isset($_POST['checkCount'])){
  $prepare1=new item_class();

  $prepare->sql_query("select id from questions where deleted!=1");
  $qn=$prepare->num_rows;
  $prepare1->sql_query("select id from tags");
  $tn=$prepare1->num_rows;
  $data=array("question"=>$qn,"tag"=>$tn);
  ob_end_clean();
 echo json_encode($data);
}
/*********************PREPARING TABLE**********************/
if(isset($_POST['fillDatas'])){
	$tagObj1=new item_class();
	$tagObj2=new item_class();
	$tagObj3=new item_class();


	$tagObj1->sql_query("select * from tags");
	while($tag1=$tagObj1->load_datas()){
		if($tag1['maxpost']!=0){
			$tagObj2->sql_query("select * from question_tags where tid=$tag1[id]");
			while($qid=$tagObj2->load_datas()){
				$tagObj3->sql_query("select * from question_tags where qid=$qid[qid] and tid!=$tag1[id]");
				 while($tag2=$tagObj3->load_datas()){
				 	$prepare->sql_query("update tag_similarity set `".strval($tag2['tid'])."`=`".strval($tag2['tid'])."`+1 where tag=$tag1[id]");
				 }

			}
		//$prepare->sql_query("update tag_similarity set `".strval($tag1['id'])."`=$tag1[maxpost] where tag=$tag1[id]");
		}
	}
}
if(isset($_POST['clearDatas'])){
	$tagObj1=new item_class();
	$tagObj2=new item_class();
	$tagObj3=new item_class();

    $prepare->sql_query("select * from tags");
	$tagObj1=new item_class();
	$tagObj2=new item_class();
	while($tag1=$prepare->load_datas()){

		$tagObj1->sql_query("select * from tag_similarity where tag=$tag1[id]");
		$tag2=$tagObj1->load_datas();
		foreach($tag2 as $key =>$value){
			if($key!='tag'){
				if($value!=0){
				  $tagObj2->sql_query("update tag_similarity set `".$key."`=0 where tag=$tag1[id]");
				}
			}
		}


	}
}
if(isset($_POST['findProbability'])){
	$prepare->sql_query("select * from tags");
	$tagObj1=new item_class();
	$tagObj2=new item_class();
	while($tag1=$prepare->load_datas()){
	 if($tag1['maxpost']!=0){
		$tagObj1->sql_query("select * from tag_similarity where tag=$tag1[id]");
		$tag2=$tagObj1->load_datas();
		foreach($tag2 as $key =>$value){
			if($key!='tag'&&$key!=$tag1['id']){
				if($value!=0){
				  $temp=($value/$tag1['maxpost']);
				  $tagObj2->sql_query("update tag_similarity set `".$key."`=$temp where tag=$tag1[id]");
				}
			}
		}

	 }
	}
}
/***********************PREPARING MATRIX******************/
if(isset($_POST['displayMatrix'])){
	/*$prepare->sql_query("select * from tempmatrix");*/ /************edit***********/
	$prepare->sql_query("select * from tag_similarity");
	$tagObj=new item_class();

	$row="";

	while($tag=$prepare->load_datas()){
		   $col="";
		   $th="";
		   foreach($tag as $key =>$value){
		   	$th.="<th class=col-head>$key</th>";
			if($key!='tag'){
              $col.="<td>$value</td>";
			}
			else{
				$col.="<td class=row-head >$value</td>";
			}
		}
		  $row.="<tr>$col</tr>";

	 }
	$table="<table border=1><tr>$th</tr>$row</table>";
ob_end_clean();
echo $table;
}
if(isset($_POST['norm'])){
	/*$prepare->sql_query("select * from tempmatrix");*/  /************edit***********/
	$prepare->sql_query("select * from tag_similarity");
	$tagObj=new item_class();
	while($tag=$prepare->load_datas()){
			foreach($tag as $key =>$value){
				if($key!='tag'&& $key!=$tag['tag']){
					$norm=1-$value;
					/*$tagObj->sql_query("update tempmatrix set `".$key."`=$norm where tag=$tag[tag]")*/  /************edit***********/
					$tagObj->sql_query("update tag_similarity set `".$key."`=$norm where tag=$tag[tag]");
				}
			}

	 }
}

/*********************CLUSTERING***************************/
if(isset($_POST['findClusters'])){
$cby=$_POST['cby'];
	if($cby=="")
  {
		$cby=1;
	}
	$tagObj=new item_class();
    //$tagObj->sql_query("select * from tempmatrix"); /************edit***********/
    $tagObj->sql_query("select * from tag_similarity");
	$row=array();
	$label=array();
	$col=array();

	while($tag=$tagObj->result->fetch_array(MYSQL_ASSOC)){
		array_push($label,$tag['tag']);
		unset($col);
		$col=array();

		foreach($tag as $key=>$value){

            echo "<br><br>";
			if($key!='tag'){
				array_push($col,$value);
			}

		}

		array_push($row,$col);

	}

	$grid=$row;
	/***********************************result to json & csv***************
	$fp = fopen('matrix.json', 'w');
	fwrite($fp,json_encode($grid));
	fclose($fp);

	$jsonFilename="http://localhost:3333/proj/HAC/matrix.json";
	$json = file_get_contents($jsonFilename);
	$array = json_decode($json, true);
	$f = fopen('matrix.csv', 'w');
	$firstLineKeys = false;
	foreach ($array as $line)
	{
		if (empty($firstLineKeys))
		{
			$firstLineKeys = array_keys($line);
			fputcsv($f, $firstLineKeys);
			$firstLineKeys = array_flip($firstLineKeys);
		}
		// Using array_merge is important to maintain the order of keys acording to the first element
		fputcsv($f, array_merge($firstLineKeys, $line));
	}
	fclose($f);
	*********************************result to json & csv****************/
	/*echo "<pre>";
	print_r($grid);
	echo "</pre>";*/

	$a = agglomerate($label, $grid);
	$c=$a->splitInto($cby);

	$prepare->sql_query(" DROP TABLE IF EXISTS `tagclusters`");
	$prepare->sql_query("CREATE TABLE `tagclusters` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`tid` BIGINT UNSIGNED  ,
			`cluster` INT UNSIGNED )");

$i=1;
foreach($c as $z){

	foreach($z->members() as $key=>$value){
		$prepare->sql_query("insert into tagclusters (tid,cluster) values($value,$i)");
	}
	$i++;


}
ob_end_clean();
print_r($a);

}
if(isset($_POST['displayClusters'])){
		$tags=array();
		$prepare->sql_query("select * from tagclusters LEFT JOIN tags on tid=tags.id");
		while($tag=$prepare->load_datas()){
			//$tags+=$tag;
			array_push($tags,$tag);
		}
		ob_end_clean();
		echo json_encode($tags);
}

?>
