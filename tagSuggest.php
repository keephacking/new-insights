<?php
require_once 'include/lib.php';
if(isset($_POST['tag'])){
	$tag=$_POST['tag'];
	$tagObj=new item_class();
	$tagObj->sql_query("CALL getTagSuggestion('".$tag."')");
	while($tag_data=$tagObj->load_datas())
	{
		echo "
				<div class=suggested-item>
					<div class=mask-suggested-tag></div>
					 <input type=hidden name=tid value=$tag_data[id]>
			        <div class=suggested-item-name>
			           $tag_data[tag]			       
			        </div>
			        <div class='suggested-item-des'>
			          $tag_data[description]
			        </div>
		      </div>";
		        
	}
}
else echo " ";

?>