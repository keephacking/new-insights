<?php
require_once 'include/lib.php';
if(isset($_POST['tag'])){
	$tag=$_POST['tag'];
	$tagObj=new item_class();
	$tagObj->sql_query("CALL getTagSuggestion('".$tag."')");
  echo "<div class=tag-list>";
	while($tag_data=$tagObj->load_datas())
	{
		echo "<div class=tag-list-item>
					 <input type=hidden name=tid value=$tag_data[id]>
			        <div class=listed-item-name>
			           $tag_data[tag]
			        </div>
		    </div>";

	}
  echo "</div>";
}
else echo " ";

?>
