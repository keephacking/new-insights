<?php
require_once 'include/head.php';

require_once 'header.php';?>

      <?php

            $item=new item_class();
            $item->set("questions");

            if(isset($_GET['query'])){
            	$query=$_GET['query'];
            	$item->sql_query("CALL searchPost('".$query."')");
            }

if($item->num_rows==0){
	die(0);
}
            while($data=$item->load_datas()){?>

		        <div class="ques-row-container">
		           <div class='ques-attribute-area'>
			             <div class='ques-attribute'>
			             <span class="quest-nums"><?=$data['vote']?></span>
			               <span class="attr-info">
			                  vote
			               </span>
			           </div>
			             <div class='ques-attribute'>
			             <span class="quest-nums"><?=$data['_views']?></span>
			               <span class="attr-info">
			                  views
			               </span>
			           </div>
			             <div class='ques-attribute'>
			             <span class="quest-nums"><?=$data['answer_count']?></span>
			             <span class="attr-info">
			                  answers
			               </span>
			           </div>

		           </div>

		           <div class="ques-title-index">
		             <p><a href="question.php?id=<?php echo $data['id'];?>"><?php echo $data['title'] ;?></a></p>
		             <div class="about-ques">
			            <div class="timeItAsked">
			            <?php
			                 echo timeAgoInWords($data['creation_date']);
			                 ?>
			            </div>
		             </div>
		           </div>

		       </div>
       <?php }
require_once 'footer.php';
       ?>
