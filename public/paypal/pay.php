<html>
<head>
<title>PHP Encrypted Website Payments example</title>
</head>
<body>
<h1>PHP Encrypted Website Payments example</h1>
<?php
$url = "https://www.paypal.com/cgi-bin/webscr"; 

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //non verificare
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); //verificare
curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DES-CBC3-SHA');
curl_setopt($ch, CURLOPT_CAINFO, '/etc/pki/tls/certs/localhost.crt'); 

//curl_setopt($ch, CURLOPT_SSLCERT, '/etc/pki/tls/certs/localhost.crt'); 
//curl_setopt($ch, CURLOPT_SSLKEY, 'snakeoil-ca-rsa.key');  
//curl_setopt($ch, CURLOPT_SSLKEYPASSWD, 'jdmkey'); 

$returned = curl_exec($ch);

if (curl_errno($ch)) {
    trigger_error(curl_error($ch), E_USER_ERROR);
} else {
    curl_close($ch);
}

echo $returned;
?>
</body>
</html>
