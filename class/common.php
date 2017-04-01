<?php

define("DEFAULT_CLEAN_TIME", 80000);

$__ip_allowed = array("127.0.0.1", "89.202.147.66");
$__myip = $_SERVER["REMOTE_ADDR"];
if (in_array($__myip, $__ip_allowed))
    define('IP_ALLOWED', true);
else
    define('IP_ALLOWED', false);

/* * #@+
 * [Global Functions] 
 */

/**
 * Del Oldest File
 * 
 * Function used to del oldest file
 *
 * @param string $directory
 */
function del_oldest_file($directory) {
    $now = time();
    if ($handle = opendir($directory)) {
        while (false !== ($file = readdir($handle))) {
            $files[] = $file;
        }
        foreach ($files as $val) {
            if (is_file($directory . $val)) {
                $file_date[$val] = filemtime($directory . $val);
                if (($now - $file_date[$val]) >= DEFAULT_CLEAN_TIME)
                    unlink($directory . $val);
            }
        }
    }
    closedir($handle);
}

/**
 * Write
 * 
 * Function used to write into a file
 *
 * @param string $file
 * @param string $data
 * @param string $type
 * @return bool
 */
function write($file, $data, $type = 'w') {
    $fd = fopen($file, $type);
    if (fwrite($fd, $data))
        $ret = true;
    else
        $ret = false;

    fclose($fd);
    return $ret;
}

/**
 * check email
 *
 * check email
 * @param string $email
 * @return boolean
 */
function check_email($email) {
    // checks for proper syntax 
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email))
        return false;
    else
        return true;

    /* if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email)) || 
      (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)) ) {
      $host = explode('@', $email);

      if(!function_exists('checkdnsrr')){
      function checkdnsrr($host, $type=''){
      if(!empty($host)){
      $type = (empty($type)) ? 'MX' :  $type;
      exec('nslookup -type='.$type.' '.escapeshellcmd($host), $result);
      $it = new ArrayIterator($result);
      foreach(new RegexIterator($it, '~^'.$host.'~', RegexIterator::GET_MATCH) as $result){
      if($result){
      return true;
      }
      }
      }
      return false;
      }
      }
      else
      {
      if(checkdnsrr($host[1].'.', 'MX') ) return true;
      if(checkdnsrr($host[1].'.', 'A') ) return true;
      if(checkdnsrr($host[1].'.', 'CNAME') ) return true;
      }
      }
      return false; */
}

/**
 * Get Player Rank
 * 
 * Get rank from points of player
 * @param double $ptg
 * @return int
 */
function getPlayerRank($ptg) {
    $points = (double) $ptg;
    if ($points < -1000)
        return 0;
    else if (($points >= -1000) && ($points < 0))
        return 1;
    else if (($points >= 0) && ($points < 10000))
        return 2;
    else if (($points >= 10000) && ($points < 50000))
        return 3;
    else if (($points >= 50000) && ($points < 100000))
        return 4;
    else if (($points >= 100000) && ($points < 200000))
        return 5;
    else if (($points >= 200000) && ($points < 250000))
        return 6;
    else if (($points >= 250000) && ($points < 350000))
        return 7;
    else if (($points >= 350000) && ($points < 500000))
        return 8;
    else if (($points >= 500000) && ($points < 1000000))
        return 9;
    else if (($points >= 1000000) && ($points < 1500000))
        return 10;
    else if (($points >= 1500000) && ($points < 2000000))
        return 11;
    else if (($points >= 2000000) && ($points < 10000000))
        return 12;
    else
        return 13;
}

/**
 * AddElement
 * 
 * Function used to add element to an array by array_walk calling
 *
 * @param string $val
 * @param string $key
 * @param string $arr
 * @return bool
 */
function addElement(&$val, $key, $arr) {
    if (isset($arr[$val['idplayer']]['pos']))
        $val['pos'] = $arr[$val['idplayer']]['pos'];
    else
        $val['pos'] = "nd";

    $n = getPlayerRank($val['points']);
    $val['rank'] = $GLOBALS['rank'][$n];
}

/**
 * setPos
 * 
 * Function used to add position in a array by array_walk calling
 *
 * @param string &$val
 * @param string $key
 */
$cnt = 0;

function setPos(&$val, $key) {
    global $cnt;
    $cnt++;
    $val['pos'] = $cnt;
}

/**
 * Read
 * 
 * Function used to read a file
 *
 * @param string $file
 * @return bool
 */
function read($file) {
    if (file_exists($file)) {
        //echo file_get_contents ($file);
        $fp = fopen($file, 'r');
        fpassthru($fp);
        flush();
        fclose($file);
        return true;
    } else
        return false;
}

/**
 * Send Data
 * 
 * Function used to send data on well format for client
 *
 * @param array $arr
 */
function send_data($arr) {
    // print to the output
    echo trans_data($arr);
}

/**
 * Trans Data
 * 
 * Elaborate data information before returns that data.
 * Protocoll used could be XML or JSON (default)
 *
 * @param array $arr
 * @return string
 */
function trans_data($arr) {
    if (CORE_PROTOCOL == 'xml') {
        require "../class/class.xml.php";
        $xml = new xml();
        $str_xml = $xml->array_to_xml($arr);
    } else {
        require "../class/array2json.php";
        $str_xml = array2json($arr);
    }
    $str_xml = Base64_encode($str_xml);
    $str_xml = utf8_encode($str_xml);
    $byte = number_format(strlen("&flashVar=" . urlencode($str_xml)) * 8 / 1024, 2) . "kb";
    return "&byte=" . $byte . "&flashVar=" . urlencode($str_xml);
}

/**
 * Clean
 * 
 * Clean String data
 *
 * @param string $str
 * @return string
 */
function clean($str) {
    $vars = $str;

    if ($GLOBALS['db_type'] == 'mysql') {
        if (version_compare(phpversion(), "4.3.0") == "-1")
            $vars = mysql_escape_string($vars);
        else
            $vars = mysql_real_escape_string($vars);
    } else
        $vars = mysqli_real_escape_string($GLOBALS["db_connection"], $vars);

    return $vars;
}

/**
 * Receive Data
 * 
 * Function used to receive data from client
 *
 * @param array $post
 * @return array
 */
function receive_data($post) {
    $flashvars = $post['flashvars'];
    //if(get_magic_quotes_gpc())
    //$flashvars = stripslashes(unserialize(urldecode($flashvars)));
    $arr = unserialize(urldecode($flashvars));
    return $arr;
}

/**
 * by key
 * 
 * Util function used on usort to order array associative
 *
 * @param array $a
 * @param array $b
 * @return int
 */
function by_key($a, $b) {
    $ka = key($a);
    $kb = key($b);
    if ($ka == $kb)
        return 0;
    return ($ka > $kb) ? -1 : 1;
}

/**
 * columnSort
 * 
 * Util function used to sort an associative array by a key name
 *
 * @param array $unsorted
 * @param string $column
 * @return array
 */
function columnSort($unsorted, $column) {
    $sorted = $unsorted;
    for ($i = 0; $i < sizeof($sorted) - 1; $i++) {
        for ($j = 0; $j < sizeof($sorted) - 1 - $i; $j++)
            if ($sorted[$j][$column] < $sorted[$j + 1][$column]) {
                $tmp = $sorted[$j];
                $sorted[$j] = $sorted[$j + 1];
                $sorted[$j + 1] = $tmp;
            }
    }
    return $sorted;
}

/**
 * Get Messager Register
 * 
 * Get message for user register
 *
 * @param string $usr
 * @param string $mail
 * @param string $confirm_code
 * @return string
 */
function getMsgRegister($usr, $mail, $confirm_code) {
    $msg = "Witamy w " . SERVER_NAME . " ! ";
    $msg .= "\n\nThanks " . $usr . " for your registration pls follow this link in order to confirm your email: ";
    $msg .= "\n" . _myurl . "?act_value=" . PKR_WWW . "&sub_act_value=" . PKR_CONFIRM . "&usr=" . urlencode($usr) . "&mail=" . urlencode($mail) . "&code=" . $confirm_code;
    $msg .= "\n\n ";
    $msg .= "\n";

    //$msg = printf($__view_lan['registration_mail'],SERVER_NAME,$usr,_myurl,PKR_WWW,PKR_CONFIRM,urlencode($usr),urlencode($mail),$confirm_code);

    $msg .= "";
    return $msg;
}

/**
 * Get Messager Confirm
 * 
 * Get message confirm for user register
 *
 * @param string $usr
 * @param string $mail
 * @return string
 */
function getMsgConfirm($usr, $mail) {
    $msg = "Thank you " . $usr . ", for your registration to " . SERVER_NAME . ", your mail is " . $mail;
    $msg .= "\n\nBecome supporter and get more from flashpoker ! Click here\n";

    //$msg = printf($__view_lan['registration_mail_success'],$usr,SERVER_NAME,$mail);

    $msg .= "https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=billing%40virtuasport%2eit&item_name=donazione%20flashpoker%2eit&item_number=d_flshpkr&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=IT&bn=PP%2dDonationsBF&charset=UTF%2d8";
    return $msg;
}

/**
 * Error Handler
 * 
 * Function used to handle PHP error or warning
 *
 * @param int $errno
 * @param string $errmsg
 * @param string $filename
 * @param int $linenum
 * @param array $vars
 */
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) {
    // orario per la registrazione
    $dt = date("Y-m-d H:i:s (T)");

    // definisce una matrice associativa con i messaggi di errore
    // in realt� i soli campi che saranno considerati sono
    // E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE
    $errortype = array(
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_PARSE => "Parsing Error",
        E_NOTICE => "Notice",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR => "User Error",
        E_USER_WARNING => "User Warning",
        E_USER_NOTICE => "User Notice",
        E_STRICT => "Runtime Notice"
    );

    // indica gli errori per i quali fare salvare la trace delle variabili
    $user_errors = array(E_USER_ERROR);

    $err = "<errorentry>\n";
    $err .= "\t<datetime>" . $dt . "</datetime>\n";
    $err .= "\t<errornum>" . $errno . "</errornum>\n";
    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

    if (in_array($errno, $user_errors)) {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    }
    $err .= "</errorentry>\n\n";

    // for testing
    if ($errno != E_NOTICE)
        write("../log/warn.log", $err, "a");

    // salva nell'errorlog e invia un e-mail se vi sono errori critici
    if (($errno == E_ERROR) || ($errno == E_CORE_ERROR) || ($errno == E_COMPILE_ERROR))
        mail(CONST_BUG_MAIL, $__view_lan["system_critical_error"], $err);
}

$old_error_handler = set_error_handler("userErrorHandler");
