<?php
require_once '/include/head.php';
?>

<link rel="stylesheet" type="text/css" href="include/admin.css">

<link type="text/css" rel="stylesheet" href="include/matrix.css" >
<script src="include/matrix.js"></script>
<script src="include/admin.js"></script>
</head>
	<body>
	  <div class="main-container">

	     <div class="main-header">
	       <h3>Admin Control Panel</h3>
	     </div>
	     <div class="main-content">
	        <div class="cluster-tags-container">
	           <div class="content-head">
	              TAG CLUSTERING
	           </div>
	           <div class="content-body">
	              <div class="tag-details">
	                <div><span>Previous Number of Questions</span> :<span class="pre-ques-count"></span></div>
	                <div><span>Previous Number of Tags</span> :<span class="pre-tags-count"></span></div>
	                <div><span>New Number of Questions</span> :<span class="new-ques-count"></span></div>
	                <div><span>New Number of Tags</span> :<span class="new-tags-count"></span></div>
	              </div>
	              <div class="head">PREPARING DATABASE</div>
	              <div class="btn-container">
	                 <button class="btn prepare-btn" type="button">Prepare table</button>
	                 <button class="btn clearDatas-btn" type="button">Clear Datas</button>
	                 <button class="btn fillDatas-btn" type="button">Fill Datas</button>
	                 <button class="btn findProb-btn" type="button">Find Probability</button>

	              </div>
	              <div class="head">PREPARING MATRIX</div>
	              <div class="btn-container">

	                 <button class="btn displayMatrix-btn" type="button">Display Matrix</button>
	                 <button class="btn norm-btn" type="button">Norm Matrix</button>
									 <input id="cby" type="text"style="width:20px">
	                 <button class="btn findClusters-btn" type="button" id="threeDee">RUN</button>
	                 <button class="btn displayClusters-btn" type="button">DISPLAY CLUSTERS</button>
	              </div>
	              <div class="result-container">
	                <div class="result-details">
	                <span>Do you wana run it</span>
	                  <div class="options">
	                    <button class="max-btn">⧉</button>
	                  </div>
	                </div>
	                <canvas id="c" style="display:none;"></canvas>
	              </div>
	           </div>
	        </div>
					  <div class="manage-user-container-wrap">
							<button class="manage-user-btn">Manage Moderators</button>
							<div class="manage-user-container">
								<div class="manage-user-head">
									<button type="button" class="mod-update-btn">update</button>
								</div>
								<div class="manage-user-body">
									 <div class="user-container">

									 </div>
								</div>
								<div class="manage-user-footer"></div>
							</div>
						</div>
	     </div>
	     <div class="main-footer">
	       FOOTER
	     </div>
	  </div>
	</body>
</html>
