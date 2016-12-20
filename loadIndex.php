<?php
ob_start();
require_once 'include/lib.php';?>

      <?php 
           $pn =$_POST['pageNumber'];
           $ps =$_POST['pageSize'];
           $filter =$_POST['filter'];
            $item=new item_class();
            $item->set("questions");
            
            if(isset($_POST['tid'])){
            	$tid=$_POST['tid'];
            	$item->sql_query("CALL getQuestionsByTag($pn,$ps,$tid,'".$filter."')");
            }
            else{
            	$item->sql_query("CALL getQuestions($pn,$ps,'".$filter."')");
            }
           
            
ob_end_clean();
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
		             <p><a href="question.php?id=<?php echo $data['qid'];?>"><?php echo $data['title'] ;?></a></p>
		             <div class="about-ques">
		                <div class="tags-index-container">
		                
                		     <div class="related-tags">
						       <?php if($data['tid1']!=NULL){?>
							       <div class="related-tag"><?=$data['tag1'];?>
							       <div class="related-tag-details"></div>
						                <input type="hidden" id="tid" value='<?=$data['tid1']?>'>						                 						                   
							       </div>
							    <?php }?>
							    <?php if($data['tid2']!=NULL){?>
							       <div class="related-tag"> <?=$data['tag2'];?>
							            <div class="related-tag-details"></div>
						                <input type="hidden" id="tid" value='<?=$data['tid2']?>'>					                    
						                 
							       </div>
							       <?php }?>
							       <?php if($data['tid3']!=NULL){?>
							       <div class="related-tag"><?=$data['tag3'];?>
							       <div class="related-tag-details "></div>
						                <input type="hidden" id="tid" value='<?=$data['tid3']?>'>
						                   
							       </div>
							       <?php }?>
							       <?php if($data['tid4']!=NULL){?>
							       <div class="related-tag"><?=$data['tag4'];?>
							       <div class="related-tag-details"></div>
						                <input type="hidden" id="tid" value='<?=$data['tid4']?>'>
						                   
							       </div>
							       <?php }?>
							       <?php if($data['tid5']!=NULL){?>
							       <div class="related-tag"> <?=$data['tag5'];?>
							        <div class="related-tag-details"></div>
						                <input type="hidden" id="tid" value='<?=$data['tid5']?>'>
						                  
							       </div>
							       <?php }?>
                             </div>
									     
			            </div>
			            <div class="timeItAsked">
			            <?php 
			                 echo timeAgoInWords($data['creation_date']);
			                 echo "  by <a href=profile.php?uid=$data[uid]>$data[username]</a>";
			                 ?>
			            </div>
		             </div>
		           </div>
		           
		       </div>
       <?php }?>
      