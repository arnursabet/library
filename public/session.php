<?php
//before we store information of our member, we need to start first the session
	
session_start();
	
//create a new function to check if the session variable member_id is on set
function logged_in() {
return isset($_SESSION['username']);        
}
//this function if session member is not set then it will be redirected to index.php

if (!logged_in()) { ?>

<script type="text/javascript">
window.location = "index.php";
</script>

<?php } ?>