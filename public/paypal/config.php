<?php
 /****************************************
 *     ==============================
 *      PayPal_EncryptedButtons v1.0
 *     ==============================
 *
 *         (c) 2004 PhpMemX.Net
 *
 * $Id: Config.php,v 1.2 2004/10/31 18:30:23 chrishogben Exp $
 *
 * The class uses OpenSSL technology to
 * dynamically encrypt your PayPal buttons
 *
 * PayPal - http://www.paypal.com
 *
 * Released under version 3 of the PHP
 * license:
 *
 * http://www.php.net/license
 *
 * @package PayPal_EncryptedButtons_Config
 * @author Chris Hogben <chrishogben@gmail.com>
 * @version 1.1
 *
 * Please see below for the configuration
 * block.
 *
 ****************************************/

 class PayPal_EncryptedButtons_Config {
 
 // {{{ properties
 
 /****************************************
 *
 * Please edit the options below to reflect
 * your system configuration. If they are
 * incorrect, this program may not work as
 * expected.
 *
 ****************************************/
 
 
        /* PayPal Certificate ID Number */
        /* You must upload your public certificate to PayPal before you can use this tool */
        /* For information about uploading your certificate, please see the following site: */
        /* https://www.paypal.com/uk/cgi-bin/webscr?cmd=_profile-website-cert */
        /* Once uploaded, enter your Unique Certificate ID into the option below */
        //var $cert_id = "VXJSCC7GYWG68"; //testing
        //var $cert_id = "WVQZMVRDVLU4A"; //testing2 
        var $cert_id = "A8652C5BL9SKW"; //magikboo23 

        /* Business - Your Main PayPal E-Mail Address */
        //var $business = "testing@youremail";
        //var $business = "testing2@youemail";
        var $business = "insert account mail";    //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< COMPILE
        
        /* Receiver E-Mail - E-Mail Address Payment will be sent to */
        /* Leave blank if the same as above */
        var $receiver = "";
        
        /* Base Directory - Base directory where all files will be stored */
        /* This should be outside the website root, and only readable by you */
        /* The trailing slash is REQUIRED */
        var $basedir = str_replace("\","/",realpath("../paypal/")); 
        //"D:/Inetpub/webs/virtuasportit/public/paypal/";                
        
        /* Certificate Store - Directory in which all certificates are stored */
        /* Can be the name of a subdirectory under basedir, or another path */
        /* The trailing slash is REQUIRED */
        var $certstore = "./certificate/";
        
        /* Temporary Directory - Where temporary files are stored regarding the transaction */
        /* This should be under the base directory OR outside the webroot, and only readable by you/the webserver */
        /* Files from this directory are automatically removed after use */
        /* The trailing slash is REQUIRED */
        var $tempdir = "./temp/";
        
        /* OpenSSL Path - Path to the OpenSSL Binary */
        /* If openssl isn't in your PATH, then change this to where it's located, otherwise leave it as it is */
        /* No trailing slash */
        //var $openssl = "c:/openssl/bin/openssl";
        var $openssl = $basedir."openssl";
        
        
        /* Certificate Names - Names of all the certificates required */

        /* Your Private RSA Key Filename */
        var $my_private = "./certificate/my-prvkey.pem";
        
        /* Your Public Certificate Filename */
        var $my_public = "./certificate/my-pubcert.pem";
        
        /* PayPal's Public Certificate Filename */
        var $paypal_public = "./certificate/paypal_cert_pem.txt";
 
 /****************************************
 *
 * Please do not edit anything below here.
 *
 ****************************************/

 // }}}

 }

?>

