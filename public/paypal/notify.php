<?php
require "../../includes/dbconn.php";
require "../../class/globals.php";
$bonus = $GLOBALS['bonus'];

//File will be rewritten if already exists
function write_file($filename,$newdata) {
      $f=fopen($filename,"w");
      fwrite($f,$newdata);
      fclose($f);  
}

function append_file($filename,$newdata) {
      $f=fopen($filename,"a");
      fwrite($f,$newdata);
      fclose($f);  
}

function read_file($filename) {
      $f=fopen($filename,"r");
      $data=fread($f,filesize($filename));
      fclose($f);  
      return $data;
}

function write($filename,$newdata) {
      if (file_exists($filename))
      {
	      append_file($filename,"\n".$newdata);
	  }
	  else
	  {
		  write_file($filename,$newdata);  
      }
}
   
$logdir = "../../log/";

$file_notify = $logdir."paypal_notify.txt";
$file_log = $logdir."paypal_log.txt";

$file_adv_notify = $logdir."paypal_adv_notify.txt";
$file_adv_log = $logdir."paypal_adv_log.txt";

// leggi il post del sistema PayPal e aggiungi cmd
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// reinvia al sistema PayPal per la convalida
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

$sample_string = urlencode("Dotacja @site@ +40000$ gracz #11# boo23 @adminmail@");
$sample_url = "?item_name=".$sample_string."&item_number=8&payment_status=Completed&txtn_id=FVKDFKDKVDFKMVDKV";

// assegna variabili inviate a variabili locali
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
	
	// HTTP ERROR
	//echo "<br> HTTP ERROR";
	write($file_notify,date("d/m/Y")."###(HTTP ERROR) ". $txn_id . "###" . $item_name . "###" . $item_number . "###" . $payment_amount . "###" . $payment_currency . "###" . $payer_email . "###" . $payment_status);
	
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) 
	{
		$res = fgets ($fp, 1024);

		if (strcmp ($res, "VERIFIED") == 0)
		{
		
		// controlla che payment_status sia Completed
		// controlla che txn_id non sia stato gi� elaborato
		// controlla che receiver_email sia il tuo indirizzo email PayPal principale
		// controlla che payment_amount/payment_currency siano corretti
		// elabora pagamento
		//echo "<br> VERIFIED";
		//if ($payment_status=="Completed")
			//echo "<br>Pagamento oggetto <b>".$item_name."</b> completo";
			   
		   if ( ($payment_status == 'Completed') and (substr_count($item_name,"Dotacja @site@")>0) )
		   {			
			   preg_match_all('/\#(.*)#/',$item_name,$matches);
			   $iduser = $matches[1][0];
			   
			   write($file_adv_notify,date("d/m/Y")."###(VERIFIED) ". $txn_id . "###" . $item_name . "###" . $item_number . "###" . $payment_amount . "###" . $payment_currency . "###" . $payer_email . "###" . $payment_status);	   
			   			
			   write($file_adv_log,"------ START ". date("d/m/Y") ." ------");
			   
			   /* Connessione e selezione del database */
			   $connessione = mysql_connect(DB_ADDRESS, DB_USER, DB_PASS);
			   
			   if (!$connessione)
			   		write($file_adv_log,"Error to connecto to DB_NAME ".DB_ADDRESS." ". mysql_error()); 
			   
			   write($file_adv_log,"Connessione: ".$connessione);
			   
			   if (!mysql_select_db(DB_NAME))
			   		write($file_adv_log,"Error to connecto to DB_NAME ".DB_NAME); 
				
			   write($file_adv_log,"Item: ".$item_name); 
			   				   
			   if ($item_name == 'partialsolve')
			   	$query = "update pkr_player set supporter = supporter+1, bonus = bonus+1, n_credit_update = n_credit_update/2, virtual_money = virtual_money+1000  where idplayer = ".$iduser;
			   elseif ($item_name == 'totalsolve')
			   	$query = "update pkr_player set supporter = supporter+1, bonus = bonus+1, n_credit_update = 0, virtual_money = virtual_money+1000 where idplayer = ".$iduser;
			   else
			   	$query = "update pkr_player set supporter = supporter+1, bonus = '".$item_number."', virtual_money = virtual_money+".$bonus[$item_number]." where idplayer = ".$iduser;
			   
			   write($file_adv_log,$query);
			   
			   $risultato = mysql_query($query); // or die("Query fallita: " . mysql_error() );
			   if (!$risultato)
			   		write($file_adv_log,"Query failed: ".$query);	
			   
			   
			   write($file_adv_log,"Risultato query: ".$risultato);
			   
			   /* Liberazione delle risorse del risultato */
			   //mysql_free_result($risultato);
			
			   /* Chiusura della connessione */
			   mysql_close($connessione);					
			   
			   write($file_adv_log,"------ END ------"); 				   
			   	   
	   	   }			
		}
		else if (strcmp ($res, "INVALID") == 0) {
			// registra investigazione manuale
			//echo "<br> INVALID";
			write($file_notify,date("d/m/Y")."###(INVALID) ". $txn_id . "###" . $item_name . "###" . $item_number . "###" . $payment_amount . "###" . $payment_currency . "###" . $payer_email . "###" . $payment_status);
		}
	}
	fclose ($fp);
}
?>