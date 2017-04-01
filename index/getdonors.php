<?php
// For Supporter
header('Content-type: text/html; charset=iso-8859-1');
define("FILE_DONORS",'../public/donors.txt');
define("DEF_DONOR","5€");

$h = "<table width=\"100%\" style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;\"><tr><td style=\"border-width: 0px 0px 1px 0px; border-style: ridge ridge dotted ridge; border-collapse: collapse; border-spacing: 2px;\"><b>";
$datas = file_get_contents(FILE_DONORS);
$datas = str_replace("\n","</b></td><td>".DEF_DONOR."</td></tr><tr><td style=\"border-width: 0px 0px 1px 0px; border-style: ridge ridge dotted ridge; border-collapse: collapse; border-spacing: 2px;\"><b>",$datas);
$f = "</b></td><td>".DEF_DONOR."</td></tr></table>";
?>
<html>
<head>
<title>
</title>
</head>
<body>
<?php
//echo $h.$datas.$f;
echo getDonors();
?>
</body>
</html>