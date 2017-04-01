<?php
session_start();
session_destroy();
//header("Location: ../index/index.php?act_value=pkr_www&sub_act_value=pkr_public_ext_home&room=1");
?>

<html>
<body>
<form action="../index/index.php" name="retry" method="post">
<input type="hidden" name="act_value" value="<?php echo 'pkr_ext_www'?>">
<input type="hidden" name="sub_act_value" value="<?php echo 'pkr_public_ext_home'?>">
<input type="hidden" name="room" value="1">
</form>
<script language="javascript">
document.forms['retry'].submit();
</script>
</body>
</html>