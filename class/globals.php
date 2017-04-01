<?php
/*$phpver = substr(phpversion(),0,strpos(phpversion(), '-'));
$arr_phpver = explode(".",$phpver);
$phpver = $arr_phpver[0];
$phpver = ($phpver>=5) ? 5 : 4;
define("PHPVERSION",$phpver);*/

$GLOBALS['cost'] = array(
						1 => "2.00",
						2 => "3.00",
						3 => "5.00",
						4 => "7.00",
						5 => "10.00",
						6 => "12.00",
						7 => "15.00",
						8 => "20.00",
						9 => "25.00",
						10 => "30.00",
						11 => "35.00",
						12 => "40.00",
						13 => "45.00",
						14 => "50.00",
						15 => "100.00"
						);

$GLOBALS['bonus'] =  array(   
						1 => "5000",
						2 => "10000",
						3 => "15000",
						4 => "20000",
						5 => "25000",
						6 => "30000",
						7 => "35000",
						8 => "40000",
						9 => "45000",
						10 => "50000",
						11 => "55000",
						12 => "60000",
						13 => "65000",
						14 => "80000",
						15 => "100000"
						);

$GLOBALS['point'] = array(
						PKR_ROYALFLUSH => 500,
						PKR_STRAIGHTFLUSH => 200,
						PKR_FOUROFAKIND => 100,
						PKR_FULLHOUSE => 50,
						PKR_FLUSH => 30,
						PKR_STRAIGHT => 15,
						PKR_THREEOFAKIND => 8,
						PKR_TWOPAIR => 5,
						PKR_PAIR => 2,
						PKR_HIGHCARD => 1
					    );
					    
$GLOBALS['rank'] = array(
						"folder",
						"lost",
						"suckle",
						"greenhorn",
						"novice",
						"conjugation",
						"intermediate",
						"able",
						"veteran",
						"expert",
						"killer",
						"champion",
						"superhuman",
						"superman"
						);
						


?>