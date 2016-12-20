<?php require_once 'include/head.php';?>
<script src='include/code.js'></script>
<script>
$(document).ready(function(){
  $('#select').click(function(){selectText('selectIt');});
});
</script>

<?php 
require_once 'header.php';?>
<button type="submit" id="select"  
class="btn btn-default btn-sm" name="SignUp" class="form-control">
					<span class="glyphicon glyphicon-lock"></span>Select</button>

<div id="selectIt" contenteditable="true" >
ejncccccccccccccd
cecevvvvvvvvvvvvv
eve

evvvvvvvvvvvv
</div>
<?php require_once 'footer.php';?>