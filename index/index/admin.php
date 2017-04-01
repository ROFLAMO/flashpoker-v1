<?php
require("../class/pkr.config.php");
?>
<html>
<head>
<script language="javascript">
<!-- 
function go() {
	document.forms['myform'].submit();
}
-->
</script>
</head>
<body onLoad="go()">
<form action="../index/index.php" name="myform" method="post">
<input type="hidden" name="act_value" value="<?php echo PKR_ADMIN?>">
<input type="hidden" name="sub_act_value" value="<?php echo PKR_LOGIN?>">
</form>
</body>
</html>
