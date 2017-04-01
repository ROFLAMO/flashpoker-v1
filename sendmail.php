<?php
if (!isset($_REQUEST['to']))
    exit();
if (!isset($_REQUEST['msg']))
    exit();
if (!isset($_REQUEST['from']))
    exit();

$to = $_REQUEST['to'];
$subj = $_REQUEST['subj'];
$msg = $_REQUEST['msg'];
$from = $_REQUEST['from'];
if (@mail($to, $subj, $msg, $from)) {
    ?>
    OK
    <?php
} else {
    ?>
    KO
    <?php
}
?>