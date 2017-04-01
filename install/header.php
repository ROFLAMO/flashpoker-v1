<?php
session_start();
require "config.php";
require "functions.php";
require "../class/pkr.config.php";
?>
<html>
<head>
<title><?php echo SITE_NAME?> Installer</title>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<link href="styles.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<div align="center">

<TABLE width="500" class="body_table" cellspacing="1"><tr><td align="center">
<font size="2"><b><?php echo strtoupper(SITE_NAME)?> INSTALLATION</font>
</td></tr></table>
<br>