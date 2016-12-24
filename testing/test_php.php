<script>
function p(){
  document.getElementById('theForm').submit();
}
</script>
<form method="post" id="theForm" action="REDIRECT_PAGE.php">
<input type="hidden" id="my_data" value="John">
<input type="submit" name="submit" onclick="p()">
</form>
Then put some hidden fields in that form.
<?php
if(isset($_POST['my_data'])){
  echo $_POST['my_data'];
}
?>
