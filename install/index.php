<?php

require "header.php";

if ($_SESSION['GOINSTALL'] !== true) {
    if (file_exists(ACCESS_CONFIG_FILE)) {
        require_once ACCESS_CONFIG_FILE;
        if (isset($_POST['usr']) && isset($_POST['pwd'])) {
            if (!(($_POST['usr'] == PKR_USR_ADMIN) && (md5($_POST['pwd']) == PKR_PSWD_ADMIN)))
                exit('<div style="font-family:Verdana,Arial;font-size:12px">Errore usr/pwd<br><a href="#" onClick="history.back()"><< back</a></div>');
        }
        else {
            if (!((PKR_USR_ADMIN == 'admin') && (PKR_PSWD_ADMIN == '21232f297a57a5a743894a0e4a801fc3'))) {
                ?>
                <table style="font-family:Verdana,Arial;font-size:10px">
                    <form action="index.php" method="POST">
                        <tr><td>USR</td><td><input type="text" name="usr"></td></tr>
                        <tr><td>PWD</td><td><input type="password" name="pwd"></td></tr>
                        <tr><td colspan="2"><input type="submit" value="re-install">&nbsp;<input type="button" value="Esci" onClick="window.location = '../index/'"></td></tr>
                    </form>
                </table>
                <?php
                exit();
            }
        }
    }
}

$_SESSION['GOINSTALL'] = true;

if (empty($_REQUEST['is']))
    $install_step = 0;
else
    $install_step = $_REQUEST['is'];

switch ($install_step) {
    case 6:
        ?>
        Congratulations! You have installed Flashpoker !
        <br>
        <br>
        <input type="button" value="Continue >>" onclick="javascript:document.location.href = '../index/'">
        <?php
        break;

    case 5:

        require_once ACCESS_CONFIG_FILE;

        if (!empty($_POST['ouser']) &&
                !empty($_POST['opass']) &&
                !empty($_POST['user']) &&
                !empty($_POST['pass'])) {
            $ouser = $_POST['ouser'];
            $opass = md5($_POST['opass']);

            if (($ouser == PKR_USR_ADMIN) &&
                    ($opass == PKR_PSWD_ADMIN) || 1 == 1) {
                $data = '<?php define("PKR_USR_ADMIN","' . $_POST['user'] . '"); define("PKR_PSWD_ADMIN","' . md5($_POST['pass']) . '"); ?>';
                writeConfigEXT($data, ACCESS_CONFIG_FILE);
                ?>
                <table width="500" class="body_table" cellpadding=4 cellspacing=0>
                    <tr><td colspan="2" align="right"><br>User and Password changed !<br><br>
                            <input type="button" value="Continue >>" onclick="javascript:document.location.href = 'index.php?is=6'">
                        </td></tr></table>
                <?php
            } else {
                ?>
                <table width="500" class="body_table" cellpadding=4 cellspacing=0>
                    <tr><td colspan="2" align="right">Error: User or Password incorrect!<br><br>
                            <input type="button" value="<< Retry" onclick="javascript:document.location.href = 'index.php?is=4'">
                        </td></tr></table>
                <?php
            }
        } else {
            ?>
            <table width="500" class="body_table" cellpadding=4 cellspacing=0>
                <tr><td colspan="2" align="right">Error: Old User or Old Password incorrect !<br><br>
                        <input type="button" value="<< Retry" onclick="javascript:document.location.href = 'index.php?is=4'">
                    </td></tr></table>
            <?php
        }
        break;

    case 4:
        ?>
        <TABLE width="500" class="body_table" cellspacing="10">

            <form action="index.php?is=5" name="install" method="post" onSubmit="
                    if ((document.forms['install'].elements['ouser'].value == '') ||
                            (document.forms['install'].elements['opass'].value == '') ||
                            (document.forms['install'].elements['user'].value == '') ||
                            (document.forms['install'].elements['pass'].value == ''))
                    {
                        alert('You must insert all access information !');
                        return false;
                    }">

                <TR>
                    <TD colspan="2">&nbsp;</TD>
                </TR>						
                <TR>
                    <TD colspan="2" align="center"><b>ACCESS ADMINISTATION CONFIG*</b></TD>
                </TR>		

                <TR>
                    <TD align="right">Old User:
                    </TD>
                    <TD>
                        <INPUT type="ouser" size="40" name="ouser">
                    </TD>
                </TR>	   


                <TR>
                    <TD align="right">Old Pass:
                    </TD>
                    <TD>
                        <INPUT type="password" size="40" name="opass">
                    </TD>
                </TR>	   


                <TR>
                    <TD width="38%" align="right">User:
                    </TD>
                    <TD>
                        <INPUT type="text" size="40" name="user">
                    </TD>
                </TR>	

                <TR>
                    <TD align="right">Password:
                    </TD>
                    <TD>
                        <INPUT type="password" size="40" name="pass">
                    </TD>
                </TR>	

                <TR>
                    <TD colspan="2">&nbsp;</TD>
                </TR>		
                <TR>
                    <TD align="right">
                    </TD>
                    <TD>
                        <input type="submit" value="Continue >>">
                    </TD>
                </TR>		

            </form>
        </TABLE>
        * old user/pass are admin/admin for first installation
        <?php
        break;

    case 3:
        ?>
        <table width="500" class="body_table" cellpadding=4 cellspacing=0>
        <?php
        if (createDB()) {
            ?>
                <tr><td colspan="2" align="right"><br>Congratulations! You may continue the installation.<br><br>
                        <input type="button" value="Continue >>" onclick="javascript:document.location.href = 'index.php?is=4'">
                    </td></tr>
            <?php
        } else {
            ?>
                <tr><td colspan="2" align="right"><br>Error on creating database !<br><br>
                        <input type="button" value="<< Retry" onclick="javascript:document.location.href = 'index.php?is=2'">
                    </td></tr>
                <?php
            }
            ?>
        </table>
            <?php
            break;

        case 2:

            if (empty($_POST['name']) || empty($_POST['user']) || empty($_POST['host'])) {
                ?><table width="500" class="body_table" cellpadding=4 cellspacing=0>
                <tr><td><br>Error: You must insert all database information !<br><br>
                        <input type="button" value="<< Retry" onclick="javascript:document.location.href = 'index.php?is=1'">
                    </td></tr></table>
                <?php
            } else {
                $data = '<?php define("_myurl","' . $_POST['baseurl'] . '"); define("DB_ADDRESS","' . $_POST['host'] . '"); define("DB_NAME","' . $_POST['name'] . '"); define("DB_USER","' . $_POST['user'] . '"); define("DB_PASS","' . $_POST['password'] . '"); ?>';
                writeConfigEXT($data);
                ?>
            <table width="500" class="body_table" cellpadding=4 cellspacing=0>	
            <?php
            $status = connectToDB();

            Message('MySql config file created: ', true);
            Message('MySql status OK: ', $status);

            if (!empty($_POST['mt']) && !empty($_POST['mhost']) && !empty($_POST['mport'])) {
                $data = '<?php define("MEMCACHE_TIMEOUT" , "' . $_POST['mt'] . '"); define("MEMCACHE_PORT" , "' . $_POST['mport'] . '"); define("MEMCACHE_HOST" , "' . $_POST['mhost'] . '"); ?>';
                writeConfigEXT($data, MEMCACHE_CONFIG_FILE);

                Message('Memcache config file created: ', true);
            } else
                Message('Memcache config file created: ', false);

            if ($status) {
                ?>
                    <tr><td colspan="2" align="right"><br>Congratulations! You may continue the installation.<br><br>
                            <input type="button" value="Continue >>" onclick="javascript:document.location.href = 'index.php?is=3'">
                        </td></tr>
                    <?php
                } else {
                    ?>
                    <tr><td colspan="2" align="left"><br>Error: MySql connection failed ! Please retry insert config.<br><br>
                            <input type="button" value="<< Retry" onclick="javascript:document.location.href = 'index.php?is=1'">
                        </td></tr>
                    <?php
                }
                ?>
            </table>
                <?php
            }

            break;


        case 1:

            $dbhost = "";
            $dbuser = "";
            $dbpass = "";
            $dbname = "";
            $memhost = "";
            $memport = "";
            $memtime = "";
            if (file_exists(MYSQL_CONFIG_FILE)) {
                require MYSQL_CONFIG_FILE;
                $dbhost = DB_ADDRESS;
                $dbuser = DB_USER;
                $dbpass = DB_PASS;
                $dbname = DB_NAME;
            }
            if (file_exists(MEMCACHE_CONFIG_FILE)) {
                require MEMCACHE_CONFIG_FILE;
                $memhost = MEMCACHE_HOST;
                $memport = MEMCACHE_PORT;
                $memtime = MEMCACHE_TIMEOUT;
            }
            ?>
        <TABLE width="500" class="body_table" cellspacing="10">

            <form action="index.php?is=2" name="install" method="post" onSubmit="
                    if ((document.forms['install'].elements['name'].value == '') ||
                            (document.forms['install'].elements['user'].value == '') ||
                            (document.forms['install'].elements['host'].value == '')) {
                        alert('You must insert all database information !');
                        return false;
                    }">

                <TR>
                    <TD colspan="2">&nbsp;</TD>
                </TR>						
                <TR>
                    <TD colspan="2" align="center"><b>MYSQL CONFIG</b></TD>
                </TR>		


                <TR>
                    <TD width="38%" align="right">Base URL:
        <?php
        $url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $url .= $_SERVER['SERVER_NAME'];
        $url .= ($_SERVER['SERVER_PORT'] != '80') ? ":" . $_SERVER['SERVER_PORT'] : "";
        $url .= $_SERVER['REQUEST_URI'];
        ?>
                    </TD>
                    <TD>
                        <INPUT type="text" size="55" name="baseurl" value="<?php echo dirname(dirname($url))."/index/index.php"; ?>">
                    </TD>
                </TR>	

                <TR>
                    <TD align="right">Database Name:
                    </TD>
                    <TD>
                        <INPUT type="text" size="40" name="name" value="<?php echo $dbname ?>">
                    </TD>
                </TR>
                <TR>
                    <TD align="right">						Database User:
                    </TD>
                    <TD>
                        <INPUT type="text" size="40" name="user" value="<?php echo $dbuser ?>">
                    </TD>
                </TR>
                <TR>
                    <TD nowrap align="right">						Database Password:
                    </TD>
                    <TD valign="top">
                        <INPUT type="password" size="40" name="password" value="<?php echo $dbpass ?>">
                    </TD>
                </TR>
                <TR>
                    <TD align="right">						Database Host:
                    </TD>
                    <TD>
                        <INPUT type="text" size="40" name="host" value="<?php echo $dbhost ?>">
                    </TD>
                </TR>

                <TR>
                    <TD colspan="2">&nbsp;</TD>
                </TR>						
                <TR>
                    <TD colspan="2" align="center"><b>MEMCACHE CONFIG</b><br><span style="font-size:9">Leave memcache options if dont have it !</span></TD>
                </TR>		

                <TR>
                    <TD align="right">						Memcache Host:
                    </TD>
                    <TD>
                        <INPUT type="text" size="40" name="mhost" value="<?php echo $memhost ?>">
                    </TD>
                </TR>
                <TR>
                    <TD nowrap align="right">						Memcache Port:
                    </TD>
                    <TD valign="top">
                        <INPUT type="password" size="5" name="mport" value="<?php echo $memport ?>">
                    </TD>
                </TR>
                <TR>
                    <TD align="right">						Memcache Timeout:
                    </TD>
                    <TD>
                        <INPUT type="text" size="5" name="mt" value="<?php echo $memtime ?>">
                    </TD>
                </TR>		

                <TR>
                    <TD colspan="2">&nbsp;</TD>
                </TR>		
                <TR>
                    <TD align="right">
                    </TD>
                    <TD>
                        <input type="submit" value="Continue >>">
                    </TD>
                </TR>		

            </form>

        </TABLE>
        <?php
        break;

    case 0:
    default:
        ?>
        <table width="500" class="body_table" cellpadding=4 cellspacing=0>

        <?php
        $canContinue = 1;

        //check PHP version
        $good = phpversion() >= '5' ? 1 : 0;
        $canContinue = $canContinue && $good;
        Message('PHP version >= 5: (' . phpversion() . ')', $good);

        //check PHP session support
        $ses_ok = function_exists('session_save_path');
        Message('PHP session support (recommended):', $ses_ok);

        //check mySQL
        $good = function_exists('mysqli_connect') ? 1 : 0;
        $canContinue = $canContinue && $good;
        Message('mysqli support exists: ', $good);

        // checks safe_mode option. artemK0
        if (ini_get('safe_mode') == '1') {
            $good = false;
        } elseif (ini_get('safe_mode') == '0') {
            $good = true;
        }

        $canContinue = $canContinue && $good;
        Message('PHP setting <i>safe_mode</i> is disabled:', $good);

        $canContinue = isWriteable($canContinue, '../log', 0777, '/log');
        $canContinue = isWriteable($canContinue, '../public', 0777, '/public');
        $canContinue = isWriteable($canContinue, '../includes', 0777, '/includes');

        $canContinue = isWriteable($canContinue, '../includes/remotedbconn.php', 0777, '/includes/remotedbconn.php');
        $canContinue = isWriteable($canContinue, '../includes/remotememcacheconn.php', 0777, '/includes/remotememcacheconn.php');
        $canContinue = isWriteable($canContinue, '../includes/accessconfig.php', 0777, '/includes/accessconfig.php');

        if ($canContinue) {
            ?>
                <tr><td colspan="2" align="right"><br>Congratulations! You may continue the installation.<br><br>
                        <input type="button" value="Continue >>" onclick="javascript:document.location.href = 'index.php?is=1'">
                    </td></tr>

                <tr><td colspan="2" align="right">
                        <input type="button" value="Change User and Password >>" onclick="javascript:document.location.href = 'index.php?is=4'">
                    </td></tr>						
                <?php
            } else {
                ?>
                <tr><td colspan="2" align="right"><br>Error: There are errors on installer check system !</td></tr>
                <?php
            }
            ?>		

        </table>	
            <?php
            break;
    }
    ?>
    <?php
    require "footer.php";
    ?>