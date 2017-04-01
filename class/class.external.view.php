<?php

/**
 * ExternalView Class 
 *
 * Class ExternalView extends of View
 * 
 */
class ExternalView 
{
	/**
	* sExtHeader
	* 
	* External Header
	*/	
	function sExtHeader()
	{
?>
		<html>
		<head>
		<LINK REL="SHORTCUT ICON" HREF="../images/favicon.ico">
		<title><?php echo PKR_SITE_TITLE?></title>
		<meta name="description" content="Flash poker on line free texas holdem">
		<META name="keywords" content= "poker online, poker on line, flashpoker, texas holdem poker">
		<meta name="refresh" content="0">
		<meta name="robots" content="index,follow">
		<meta name="copyright" content="<?php SITE_NAME?> (2001-2005) Boo23. Tutti i diritti sono riservati.">
		<meta name="author" content="Boo23 creations">
		<meta name="generator" content="Crimson Editor">
		<meta name="revisit-after" content="1">
		<LINK href="../includes/pkr_ext.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		<!--
		var myWindow = null;	
		
		function setFocus()
		{
			//var isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;
			//if (isIE)
			if (!myWindow.focus)
				myWindow.focus();
		}
		
		<?php 
		if (SECURITY) {
		?>
			function openWindow(url,w,h,x,y,resize,scroll,n)
			{
				/*var start = new Date(1971);
				var end = new Date();
				var difference = end.getTime() - start.getTime();*/
				
				var str = "resizable="+resize+",location=0,status=0,scrollbars="+scroll+",width="+w+",height="+h;
				var t = (document.layers) ? ',screenX=' + x + ',screenY=' + y : ',left='+ x +',top='+ y ;
				myWindow = window.open (url , n, str + t );
				myWindow.focus();
			}		
		<?php
		} else {
		?>
			function openWindow(url,w,h,x,y,resize,scroll,n)
			{
				var start = new Date(1971);
				var end = new Date();
				var difference = end.getTime() - start.getTime();
				
				var str = "resizable="+resize+",location=0,status=0,scrollbars="+scroll+",width="+w+",height="+h;
				var t = (document.layers) ? ',screenX=' + x + ',screenY=' + y : ',left='+ x +',top='+ y ;
				myWindow = window.open (url , difference, str + t );
				myWindow.focus();
			}			
		<?php
		}
		?>
				
			//go Table
			function gotbl(idtbl,isguest)
			{
				var tbl_x_base = 920;
				var tbl_y_base = 598;
				if ( (screen.width <= tbl_x_base) || (screen.height <= tbl_y_base) ) {
					tbl_x_base = 950;
					tbl_y_base = 628;
					myWindow = openWindow("<?php echo $_SERVER['SCRIPT_NAME']?>?act_value=<?php echo PKR_WWW?>&sub_act_value=<?php echo PKR_TABLE?>&t="+idtbl+"&isguest="+isguest, tbl_x_base, tbl_y_base,"20%","20%","1","1","Table"+idtbl);
				}
				else {
					myWindow = openWindow("<?php echo $_SERVER['SCRIPT_NAME']?>?act_value=<?php echo PKR_WWW?>&sub_act_value=<?php echo PKR_TABLE?>&t="+idtbl+"&isguest="+isguest, tbl_x_base, tbl_y_base,"20%","20%","0","0","Table"+idtbl);
				}
			}
			
			//Leave Table			
			function leavetable()
			{
				window.close();
			}				
					
			//go Table
			function gotbl_curr_window(idtbl,idplr)
			{			
				document.forms['gotbl'].elements['t'].value=idtbl;
				document.forms['gotbl'].submit();
			}
		
			//Leave Table			
			function leavetable_curr_window()
			{
				document.forms['gohome'].submit();
			}				
				
			//snd mail to change pswd
			function goChangePass()
			{
				openWindow("<?php echo $_SERVER['SCRIPT_NAME']?>?act_value=<?php echo PKR_WWW?>&sub_act_value=<?php echo PKR_SND_MAIL_PSWD?>",290,230,"40%","40%",0,0,"changepass");
			}
			
			//See game history
			function goGameHistory()
			{
				document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWGAMEHISTORY?>';
				document.forms['refresh'].submit();
			}			

			//See game history
			function goRules()
			{
				document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWRULES?>';
				document.forms['refresh'].submit();
			}						
				
			//See game history
			function goYourSitePoker()
			{
				document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWYOURSITEPOKER?>';
				document.forms['refresh'].submit();
			}
			
			//See game history
			function goBuy()
			{
				document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWBUY?>';
				document.forms['refresh'].submit();
			}						
					
			//Login
			function goLogin()
			{
				openWindow("<?php echo $_SERVER['SCRIPT_NAME']?>?act_value=<?php echo PKR_WWW?>&sub_act_value=<?php echo PKR_LOGIN?>",230,230,"40%","40%",0,0,"login");
			}

			//Register
			function goRegister()
			{
				openWindow("<?php echo $_SERVER['SCRIPT_NAME']?>?act_value=<?php echo PKR_WWW?>&sub_act_value=<?php echo PKR_REGISTER?>",380,387,"20%","20%",0,0,"register");
			}			
			
			//Logout
			function logout(ext)
			{
				if (ext)
					window.location = ext;	
				else
					window.location = 'logout.php';	
			}							

			//Gorank
			function gornk()
			{
				document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWRANKING?>';
				document.forms['refresh'].submit();
			}
			
			function gohm()
			{
				document.forms['refresh'].submit();
			}
			
			function getFlashMovieObject(movieName)
			{
				if (window.document[movieName]) 
				{
					return window.document[movieName];
				}
				if (navigator.appName.indexOf("Microsoft Internet")==-1)
				{
					if (document.embeds && document.embeds[movieName])
					return document.embeds[movieName]; 
				}
				else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
				{
					return document.getElementById(movieName);
				}
			}
				
			function setFocus() 
			{
				window.focus();
				var flashui = document.getElementById('mymovie');
				if(flashui && flashui.focus) flashui.focus();
			}	
			
			function confirmSubmit(testo)
			{
			var agree=confirm(testo);
			if (agree)
				return true ;
			else
				return false ;
			}
			
			/*
			function checkCR(evt) 
			{
				var evt  = (evt) ? evt : ((event) ? event : null);
				var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
				if ((evt.keyCode == 13) && (node.type=="text")) {
						if (this.form)
							return submit();
				}
			}
			document.onkeypress = checkCR;
			*/
						
			
		-->
		</script>
		<script src="../includes/AC_RunActiveContent.js" type="text/javascript"></script>
		<script src="../includes/AC_ActiveX.js" type="text/javascript"></script>
		</head>
		<body>
	<?php
	}
	
	/**
	* sExtFooter
	* 
	* External Footer
	*/		
	function sExtFooter()
	{
	?>
		</body>
		</html>
	<?php		
	}
	
	/**
	* extGlobalHeader
	* 
	* External Global Header
	* @param boolean $all
	*/		
	function extGlobalHeader($all = false)
	{		
		if ($all) {
		?>
		<table border="0" align="center" cellspacing="0" cellpadding="0" width="1" height="99%">
		<tr>
		<td valign="top">
		
    		<table bgcolor="#FFFFFF" width="100%" cellspacing="0" cellpadding="0" align="center">

			<tr>
			<td width="1" height="3"><img src="../images/site/leftup.gif"></td>
			<td background="../images/site/up.gif" height="3"></td>
			<td width="1" height="3"><img src="../images/site/rightup.gif"></td>
			</tr>

			<tr>
			<td background="../images/site/left.gif" width="3" height="3"></td>
			
			<td valign="top">	
			
		<?php
		}
		else
		{
		?>
			<table border="0" align="center" cellspacing="0" cellpadding="0" width="1" height="99%">
			<tr>
			<td valign="top">		
		<?php	
		}
	}
	
	/**
	* extGlobalFooter
	* 
	* External Global Footer
	* @param boolean $all
	*/	
	function extGlobalFooter($all = false)
	{
		if ($all) {
		?>		
			<table cellspacing="2" align="center">
			
			<tr><td>
			
				<table align="center"><tr>
				<td><a href="http://www.adobe.com/it/products/flashplayer/" target="_blank"><u>scarica il flash player aggiornato</u></a>
				</td><td><a href="http://www.adobe.com/it/products/flashplayer/" target="_blank"><img src="../images/flash.gif" align="bottom" border="0"></a></td>
				</tr></table>		
			
			</td></tr>
			
			<tr><td align="center">
				<a href="" title="poker online"><b><u></u></b></a> Free Texas holdem & 5 Card Draw Poker [<b>NO REAL MONEY</b>]  <b></b>.
			</td></tr>
			
			<tr><td align="center">
				<b>Network</b>:&nbsp;&nbsp;&nbsp;<a href="" target="_blank">Fantacalcio online</A>&nbsp;-&nbsp;<a href="" target="_blank">Giochi online</A>&nbsp;-&nbsp;<a href="" target="_blank">Chat online</A>&nbsp;-&nbsp;<a href="" target="_blank">Poker online</A>
			</td></tr>
			
			</table>

		</td>
		
		<td background="../images/site/right.gif" width="3" height="3"></td>
		</tr>	
	
		<tr>
		<td><img src="../images/site/leftdown.gif"></td>
		<td background="../images/site/down.gif" height="3"></td>
		<td><img src="../images/site/rightdown.gif"></td>
		</tr>
		</table>		
		
		</td>
		</tr>
		</table>
		<?php
		} else {
		?>
			</td></tr></table>
		<?php	
		}
		?>
	<?php		
	}

	/**
	* toExtLogin
	* 
	* toExtLogin function
	* @param boolean $fromWindowOpener
	*/					
	function toExtLogin($fromWindowOpener = true)
	{
		$usr = clean($_REQUEST["usr"]);
		$pswd = md5($_REQUEST["pswd"]);		
		
		$query = "select * from pkr_player where usr='".$usr."' and pswd='".$pswd."'";
		$rows = $GLOBALS['mydb']->select($query);
		
		if (count($rows) == 1)
		{					
			if ($rows[0]['confirmed'] == 0)
			{
				echo "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>USR NOT CONFIRMED</b></font></div>";
				if ($fromWindowOpener) {
				?>
					<br>
					<br>
					<center><input type="button" onClick="window.close()" value="close"></center>	
				<?php
				}
				else
				{
				?>
					<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="retry" method="post">
					<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
					<input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME?>">
					<input type="hidden" name="room" value="1">					
					</form>
					<script language="javascript">setTimeout("document.forms['retry'].submit()",2000);</script>
				<?php					
				}
				
			}
			else
			{
				
				$_SESSION['my_idp'] = $rows[0]["idplayer"];
				$_SESSION['my_usr'] = $rows[0]["usr"];
				$_SESSION['is_supporter'] = ($rows[0]["supporter"] == 1) ? true : false;
				
				$query = "update pkr_player set sess = ?, lastenter = now() where idplayer = ?"; 
				$params = array(session_id(),$rows[0]["idplayer"]);
				$GLOBALS['mydb']->update($query,$params);
				
				
				echo "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>...WAIT PLEASE...</b></font></div>";	
				
				if ($fromWindowOpener) {
				?>			
					<script language="javascript">
					<!--
					window.opener.document.forms['refresh'].submit();
					//setTimeout("window.close()",500);
					window.close();
					-->
					</script>
				<?php
				}
				else
				{
				?>			
					<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="retry" method="post">
					<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
					<input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME?>">
					<input type="hidden" name="room" value="1">					
					</form>
					<script language="javascript">setTimeout("document.forms['retry'].submit()",2000);</script>
				<?php					
				}
			}
			
		}
		else
		{
			echo "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>ERROR USR/PSWD</b></font></div>";

			?>
				<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="retry" method="post">
				<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
				<input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME?>">
				<input type="hidden" name="room" value="1">					
				</form>
				<script language="javascript">setTimeout("document.forms['retry'].submit()",2000);</script>
			<?php
		}
		
	}
			
	/**
	* extbody
	* 
	* External Body
	* @param int $idroom
	* @param string $passRoom
	*/	
	function extbody($idroom = 1, $passRoom = '')
	{
		$onlycount = true;
		?>
		<table>
		<tr>
		<td align="center">
			
			<?php
			if (isset($_SESSION['my_idp']))
			{
			?>
				<table cellspacing="5" width="200">
				<tr>
					<td align="center">Zalogowany&nbsp;na&nbsp;<b><?php echo strtoupper($_SESSION['my_usr'])?></b></td>
					
					<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
					<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
					<input type="hidden" name="sub_act_value" value="<?php echo PKR_EXT_USR_PROFILE?>">
					<td align="center"><input type="submit" value="PROFIL"></td>
					</form>
					
					<td align="center"><input type="button" onClick="logout('extlogout.php')" value="WYLOGOWANIE"></td>
				</tr>
				</table>
			<?php			
			}
			else
			{
			?>
				<table border="0" cellspacing="5" width="200">
				<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
				<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
				<input type="hidden" name="sub_act_value" value="<?php echo PKR_EXT_LOGIN?>">
				<input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_EXT_3LOGIN?>">
				<tr>
				<td>
				GRACZ
				</td>
				
				<td>
				<input type="text" size="23" name="usr" maxlength="30">
				</td>	
				
				<td>
				HAS�O
				</td>
				
				<td>
				<input type="password" size="23" name="pswd" maxlength="30">
				</td>	
				
				<td align="center">
				<input type="submit" value="LOGIN">
				</td>
				
				<td><a href="javascript:goChangePass()"><img src="../images/changepswd.gif" border="0"></a></td>
			
				</form>
				
				<td colspan="6" align="center">
				<a href="javascript:goRegister()"><b><u>REJESTRACJA</u></b></a>
				</td></tr>				
				</table>
			<?php	
			}
			?>
		
		</td>
		</tr>
		</table>		
		<table align="center" width="802" cellspacing="0" cellpadding="0">		
			
<?php
		$checked = (isset($_SESSION["ctbl_".$idroom])) ? true : false;
		
		$curr_room = $this->getRoom($idroom);
		
		if (($idroom == $curr_room['idroom']) && ($passRoom == $curr_room['password'])) {
			$_SESSION["ctbl_".$idroom] = true;
			$checked = true;
		}
		
		if (($curr_room['type'] == 1) && (!$checked))
		{
?>
			<tr>
			<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="retry" method="post">
			<input type="hidden" name="act_value" value="<?php echo PKR_WWW?>">
			<input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME?>">
			<input type="hidden" name="room" value="<?php echo $idroom?>">
			<td align="center">
			<br><br><br><br>
			THIS IS A <b>PRIVATE ROOM</b>
			<br>
			PLEASE INSERT PASSWORD TO ENTER
			<br>
			<br>
			<input type="password" name="password" size="25">&nbsp;<input type="submit" value="ENTER">
			<br><br><br><br>
			</td>
			</form>
			</tr>
<?php		
		}
		else
		{
?>
			<tr>		
			<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="gotbl" method="post">
			<input type="hidden" name="act_value" value="<?php echo PKR_WWW?>">
			<input type="hidden" name="sub_act_value" value="<?php echo PKR_TABLE?>">
			<input type="hidden" name="t" value="">
			<td width="802" align="center">	
				<script type="text/javascript">
				AC_FL_RunContent( 
				'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
				'width','802',
				'height','341',
				'src','list_tables_sml?protocol=<?php echo CORE_PROTOCOL?>&_myurl=<?php echo _myurl?>&sess=<?php echo session_id()?>&my_idp=<?php echo $_SESSION['my_idp']?>&room=<?php echo $idroom?>',
				'quality','high',
				'wmode', 'transparent',
				'pluginspage','http://www.macromedia.com/go/getflashplayer',
				'movie','list_tables_sml?protocol=<?php echo CORE_PROTOCOL?>&_myurl=<?php echo _myurl?>&sess=<?php echo session_id()?>&my_idp=<?php echo $_SESSION['my_idp']?>&room=<?php echo $idroom?>' 
				); //end AC code
				</script><noscript><object id="mymovie" name="mymovie" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="802" height="341" align="middle">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="movie" value="list_tables_sml.swf?protocol=<?php echo CORE_PROTOCOL?>&_myurl=<?php echo _myurl?>&sess=<?php echo session_id()?>&my_idp=<?php echo $_SESSION['my_idp']?>&room=<?php echo $idroom?>" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="wmode" value="transparent">
				<embed name="mymovie" wmode="transparent" src="list_tables_sml.swf?protocol=<?php echo CORE_PROTOCOL?>&_myurl=<?php echo _myurl?>&sess=<?php echo session_id()?>&my_idp=<?php echo $_SESSION['my_idp']?>&room=<?php echo $idroom?>" quality="high" bgcolor="#ffffff" width="802" height="341" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></EMBED>
				</object></noscript>			
			</td>
			</form>
			</tr>
<?php
		}
?>	
		</table>
		
		<?php
	}	
	
	/**
	* extLogin
	* 
	* External login
	*/		
	function extLogin()
	{
	?>
		<table width="200" cellspacing="5">
		<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" method="post">
		<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
		<input type="hidden" name="sub_act_value" value="<?php echo PKR_EXT_LOGIN?>">
		<input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_EXT_2LOGIN?>">
		<tr>
		<td>
		USER
		</td>
		
		<td>
		<input type="text" size="23" name="usr" maxlength="30">
		</td>	
		</tr>
		
		<tr>
		<td>
		PSWD
		</td>
		
		<td>
		<input type="password" size="23" name="pswd" maxlength="30">
		</td>	
		</tr>	
		
		<tr>
		<td colspan="2" align="center">
		<input type="submit" value="Login">
		</td>	
		</tr>	
		</form>	
		</table>
	
	<?php		
	}	
	
	/**
	* extViewPlayerProfile
	* 
	* External View Profile
	* @param array $arr
	*/		
	function extViewPlayerProfile($arr)
	{
		
		$query = "SELECT SQL_CACHE usr, idplayer, (virtual_money-(n_credit_update*".PKR_DEFAUL_GET_CREDIT.")) as w FROM pkr_player WHERE confirmed=1 ORDER BY w DESC";
		$res = $GLOBALS['mydb']->special_select($query, "idplayer");
		
		// Insert pos field in player ranking array
		array_walk($res,'setPos');
		
		$query = "SELECT usr, idplayer from pkr_player where idplayer = ".$arr['idplayer'];
		$rows = $GLOBALS['mydb']->select($query);

		// Insert pos for user on table
		array_walk($rows,'addElement',$res);
		
		$mypos = $rows[0]['pos'];
		unset($res);
		unset($rows);
		?>
		<br>
		<!--1-->
		<table width="100%" border="0" align="center" border="0">
		<tr>
		<td valign="top">
	
			<!--2-->	
			<table width="370" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000;">
			
			<!--<tr>
			<td colspan="2">
			
				<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; }">
				<tr>		
					<td width="1"><img src="../images/site/tleft.gif" border="0"></td>	
					<td style="{ height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif); }">USER&nbsp;PROFILE:&nbsp;&nbsp;<b><?php echo strtoupper($arr['usr'])?></b></td>
					<td width="1"><img src="../images/site/tright.gif" border="0"></td>
				</tr>
				</table>
			
			</td>
			</tr>
			
			<tr><td colspan="2">&nbsp;</td></tr>-->
			
			<tr>
			<td colspan="2">

				<!--3-->
				<table width="100%">
				<tr>
				<td>
						<!--4-->
						<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000;">
						<?php
						//$str = "idplayer,usr,mail,city,isc_date,virtual_money,supporter,bonus";
						foreach ($arr as $key => $val)
						{
						//&& ($key != "usr")
						if (($key != "supporter") && ($key != "bonus") && ($key != "virtual_money")) 
						{
							$str = "";
							switch ($key)
							{
							case "idplayer":
								$type = "hidden";
								$fval = "";
								$fkey = "";
								$str = "onFocus = 'blur()'";
							break;
							case "n_credit_update":
								$type = "";
								$fval = "";
								$fkey = "";//$key;
								$str = "";
							break;						
							case "isc_date":
								$type = "text";
								$fval = date("d/m/Y",$val);
								$fkey = "GRA OD";//$key;
								$str = "onFocus = 'blur()'";
							break;
							case "points":
								$type = "text";
								$fval = $val;
								$fkey = "PUNKTY";
								$str = "";					
							break;
							case "usr":
								$type = "text";
								$fval = strtoupper($val);
								$fkey = "GRACZ";
								$str = "";					
							break;	
							case "city":
								$type = "text";
								$fval = strtoupper($val);
								$fkey = "MIASTO";
								$str = "";					
							break;							
							case "rank":
								$type = "text";
								$fval = $GLOBALS['rank'][getPlayerRank($val)];
								$fkey = "POZIOM";
								$str = "";					
							break;												
							case "bonus":
								$type = "image";
								$fval = $val;
								$fkey = $key;
								$str = "src='../images/bonus/".$val.".png'";					
							break;
							case "supporter":
								$type = "text";
								if ($val == 1)
									$fval = "si";
								else
									$fval = "no";
								$fkey = $key;
								$str = "onFocus = 'blur()'";
							break;				
							default:
								$fval = "";
								$fkey = "";
								if (!empty($val)) {
									$type = "text";
									$fval = strtoupper($val);
									$fkey = $key;
								}
							break;
								
							}
								if ((!empty($fkey)) || (!empty($fval))) 
								{
								?>	
								<tr>
								<td width="40%">
									<?php echo strtoupper($fkey);?>
								</td>
								<td width="60%">
									<!--<input type="<?php echo $type?>" name="<?php echo $key?>" value="<?php echo $fval?>" size="<?php echo strlen($val)+2?>" <?php echo $str?>>-->
									<b><?php echo $fval?></b>
								</td>
								</tr>
								<?php	
								}
							}
						}
						?>
						<tr>
						<td width="40%">
						RANKING
						</td>
						<td width="60%">
						<b><?php echo $mypos?></b>
						</td>
						</tr>
						<tr>
						
						<td>
						
						<?php			
						$supporter = $arr['supporter'];
						$mybonus = $arr['bonus'];
						$virtual_money = $arr['virtual_money'];
						$ncost = count($this->cost);
						
						$got = $arr['n_credit_update']*PKR_DEFAUL_GET_CREDIT;
						$repayment = $arr['n_credit_update']*0.50;
						$got2 = $got/2;
						$repayment2 = $repayment/2;
						?>				
						
						</table>
						<!--4-->
					
						</td><td align="center" valign="top">
					
							<table width="1" border="0">
							<tr><td>
							<div style="position:relative;margin-top:-50px" id="fishs"></div>
							<?php $str = $this->arrfish2image($this->credit2arr_fish($virtual_money))?>
							</td></tr>
							<tr><td align="center">TWOJE �ETONY <br><b><?php echo number_format($virtual_money,2,',','.')?></b><?php echo PKR_CURRENCY_SYMBOL?>
							</td></tr>
							<tr><td align="center">UTRACONE �ETONY <br><b><?php echo number_format($got,2,',','.')?></b><?php echo PKR_CURRENCY_SYMBOL?>
							</td></tr>							
							</table>
						
							<script language="javascript">
							function setFish() {
								var mydiv = document.getElementById('fishs');
								mydiv.innerHTML = '<?php echo $str ?>';
							}
							document.onLoad = setFish;
							</script>
											
						</td>
						</tr>
						</table>
						<!--3-->
					
					</td>
					</tr>				
					
					<?php
					if ($arr['n_credit_update']>1) {
					?>				
					
					<tr>
					<td colspan="2">&nbsp;</td>
					</tr>					
					
					<tr>
					<td colspan="2">SP�A� SW�J D�UG I ODZYSKAJ POZYCJ� W RANKINGU</td>
					</tr>										
					
					<tr>
					<form action="https://www.paypal.pl/cgi-bin/webscr" name="solve" target="_blank" method="post">
					<input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT?>">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<input type="hidden" name="lc" value="IT">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="return" value="<?php echo _myurl?>">
					<input type="hidden" name="amount" value="<?php echo str_replace(",",".",$repayment)?>">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="item_name" value="Dotacja flashpoker.pl <?php echo $got?><?php echo PKR_CURRENCY_SYMBOL?> gracz #<?php echo $arr['idplayer']?># <?php echo $arr['usr']?> <?php echo $arr['mail']?>">
					<input type="hidden" name="item_number" value="<?php echo 'totalsolve'?>">		
					<td colspan="2"><a href="#" title="click to donate and solve game debit" onClick="document.forms['solve'].submit()"><u>SP�A� CA�Y D�UG PRZEKAZUJ�C <b><?php echo $repayment?>�</b></u></a> *</td>
					</form>
					</tr>			

					<tr>
					<form action="https://www.paypal.pl/cgi-bin/webscr" name="partialsolve" target="_blank" method="post">
					<input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT?>">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<input type="hidden" name="lc" value="IT">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="return" value="<?php echo _myurl?>">
					<input type="hidden" name="amount" value="<?php echo str_replace(",",".",$repayment2)?>">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="item_name" value="Dotacja flashpoker.pl <?php echo $got2?><?php echo PKR_CURRENCY_SYMBOL?> gracz #<?php echo $arr['idplayer']?># <?php echo $arr['usr']?> <?php echo $arr['mail']?>">
					<input type="hidden" name="item_number" value="<?php echo 'partialsolve'?>">		
					<td colspan="2"><a href="#" title="click to donate and solve game debit" onClick="document.forms['partialsolve'].submit()"><u>SP�A� PO�OW� D�UGU PRZEKAZUJ�C <b><?php echo $repayment2?>�</b></u></a> *</td>
					</form>
					</tr>											
					
					<tr>
					<td colspan="2">&nbsp;</td>
					</tr>					
					
					<tr>
					<td colspan="2">*+1 BONUS E +1000<?php echo PKR_CURRENCY_SYMBOL?></td>
					</tr>		
					
					<?php } ?>			
					
					<tr><td colspan="2">
					
						<?php			
						if ($supporter == 0) 
						{
							?>
							<br> 
							<?php
						}
						else
						{
							?>
							<br>CURRENT SUPPORTER LEVEL <b><?php echo $supporter?></b>
							<?php
						}
						?>					
					
					</td>
					</tr>					
					</table>
					<!--2-->
			
			</td>
			</tr>
			</table>
			<!--1-->

				<br><br>
				<table border="0" align="center" width="100%">
				<tr>
				<td>&nbsp;</td>
				<?php
				for ($i = 1;$i<=$ncost;$i++)
				{
					?>
					
					<form action="https://www.paypal.com/cgi-bin/webscr" name="payimg<?php echo $i?>" target="_blank" method="post">
					<input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT?>">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<input type="hidden" name="lc" value="IT">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="return" value="<?php echo _myurl?>">
					<input type="hidden" name="amount" value="<?php echo str_replace(",",".",$this->cost[$i])?>">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="item_name" value="Dotacja flashpoker.pl +<?php echo $this->bonus[$i]?><?php echo PKR_CURRENCY_SYMBOL?> gracz #<?php echo $arr['idplayer']?># <?php echo $arr['usr']?> <?php echo $arr['mail']?>">
					<input type="hidden" name="item_number" value="<?php echo $i?>">			
					<td><a href="#" title="click to donate" onClick="document.forms['payimg<?php echo $i?>'].submit()"><img src="../images/bonus/<?php echo $i?>.png" border="0" title="Supporta flashpoker al costo di <?php echo $this->cost[$i]?>�"></a></td>
					</form>		
					
					<?php					
				}
				?>
				</tr>
				
				<tr bgcolor="#ddddee">
				<td>DOTACJA</td>
				<?php							
				for ($i = 1;$i<=$ncost;$i++)
				{
					?>
					<form action="https://www.paypal.com/cgi-bin/webscr" name="pay<?php echo $i?>" target="_blank" method="post">
					<input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT?>">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<input type="hidden" name="lc" value="IT">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="return" value="<?php echo _myurl?>">
					<input type="hidden" name="amount" value="<?php echo str_replace(",",".",$this->cost[$i])?>">
					<input type="hidden" name="currency_code" value="EUR">
					<input type="hidden" name="item_name" value="Dotacja flashpoker.pl +<?php echo $this->bonus[$i]?><?php echo PKR_CURRENCY_SYMBOL?> gracz #<?php echo $arr['idplayer']?># <?php echo $arr['usr']?> <?php echo $arr['mail']?>">
					<input type="hidden" name="item_number" value="<?php echo $i?>">			
					<td><a href="#" title="Supporta flashpoker con una donazione !" onClick="document.forms['pay<?php echo $i?>'].submit()"><u><?php echo $this->cost[$i]?>�</u></td>
					</form>
					<?php
				}
				?>
				</tr>
				
				<tr>
				<td><b>BONUS</b></td>
				<?php
				for ($i = 1;$i<=$ncost;$i++)
				{
					?>
					<td>+<b><?php echo $this->bonus[$i]/1000?>K</b><?php echo PKR_CURRENCY_SYMBOL?></td>
					<?php					
				}
				?>				
				</tr>
				
				<tr>
				<td>CURR.</td>
				<?php
				for ($i = 1;$i<=$ncost;$i++)
				{
					?><td><?php
					if ($i==$mybonus) {
					?>
					&nbsp;&nbsp;&nbsp;<b><font size="3">^</font></b>
					<?php			
					}
					else
					{
					?>
					&nbsp;
					<?php			
					}
					?></td><?php
				}
				?>				
				</tr>				
				</table>
				
				<br><br>
				
				<table>
				<tr>
				<td width="90%">
					<b>Kliknij na ikonk� ze znaczkiem bonusu i wspom� flashpoker.pl przeka� darowizn�!</b>
					<br>
					<br>					
					Flashpoker.pl podaruje Ci kredyty, kt�re pozwol� Ci na wspi�cie si� na g�r� (RANKING) na stronie !!
                    Transakcja przeprowadzana jest z zachowaniem wszelkich zasad bezpiecze�stwa, poprzez bezpieczne po��czenie (SSL) na stronie Paypal. <a href="http://www.paypal.pl" target=_blank><b><u>Paypal</u></b></a>.
					<br>
					<br>
					Zakredytowanie pieni�dzy nast�puje automatycznie i natychmiast po dokonaniu darowizny. Ponadto Twoje konto nigdy nie zostanie usuni�te, nawet je�eli nie b�dziesz z niego korzysta� przez 30 dni..
					<br>
					<br>
					W celu uzyskania dodatkowych informacji napisz do nas: <a href="mailto:admin@flashpoker.pl"><b><u>admin@flashpoker.pl</u></b></a>
				</td>
				<td valign="middle">
				<img src="../images/site/paypalVerified.png">
				</td>
				</tr>
				</table>
		<br>	
		
		<table align="center">
		<tr>
		<form action="<?php echo $_SERVER['SCRIPT_NAME']?>" name="retry" method="post">
		<input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW?>">
		<input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME?>">
		<input type="hidden" name="room" value="1">
			<td colspan="6" align="center">
				<input type="submit" value="<< POWR�T">&nbsp;<input type="button" value="WYLOGOWANIE" onClick="window.location = '../index/extlogout.php';">
			</td>
		</form>
		</tr>
		
		</table>		
		<?php			
	}	
}
?>