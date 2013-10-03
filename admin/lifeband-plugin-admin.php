<?php
require_once('generateUsers.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

?>


<div class="wrap">

<h2>Life Band Plugin</h2>

<h3>Life Band Plugin Options</h3>

</form>
<form method="post" action="lifeband-plugin-admin.php">
<input type="button" name="submit" value="click me">
</form>
</div>
<?php 
if(isset($_POST['submit'])) { 
generateUsers::canti();
} 
?>