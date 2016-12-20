<?php
require_once 'include/lib.php';
$tags=new item_class();
if(isset($_POST['tag']))
{
	$search_tag=$_POST['tag'];
	$tags->sql_query("SELECT * FROM tags where tag LIKE '$search_tag%' ");

}
else
$tags->sql_query("select * from tags");?>
<?php
if($tags->num_rows){
while($row=$tags->load_datas()){?>

	<div class="box-tag">
		<div class="box-tag-item">
			 <div class="box-tag-details">
					 <div class="box-tag-name">
						 <a href="tagged_posts.php?tid=<?=$row['id']?>"><?=$row['tag'];?></a>
					 </div>
					 <div class="box-tag-des">
					  <?=$row['description'];?>
					</div>
						<div class="box-tag-reput-details">
						  post:<?=$row['maxpost']?>&nbsp&nbspfollow :<?=$row['followers']?>
						</div>
			 </div>
		</div>
	</div>

<?php }}
else die("No Results");
?>
