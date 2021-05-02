<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* file info :
Free License 
# These code was developed with Notepad++ v6.5.2
# Benedict E. Pranata	- [ cyb3rwine@gmail.com ]
# Dinas Komunikasi dan Informatika Kota Surabaya >> dinkominfo.surabaya.go.id	
    + Class  		: Security
    + Description	: Security class for filtering variable and [en/de]cryption
    + Filename 		: Security.class.php
    + Author  		: Benedict E. Pranata
    + Created on 	: 25/SEP/2014 15:18:15
End of file info */

class Enkripsi{
	private $privKey = "04212096@Rizky_Yuanda";
	private $cSalt 	 = "MyNameIsRizky";
	
	/** MD5 hash modified with salt and bas64 **/
	public function myCrypt($pwd,$username){
		$toHash	  = $this->encrypt($pwd);
		$password = str_split($toHash,(strlen($toHash)/2)+1);
		$hash 	  = md5($this->encrypt($username) . $password[0] . $this->cSalt . $password[1]);
		return $hash; 
	}
	
	/* Base64 encrypt with Key */
	public function encrypt($string) {
		$result = '';
		for($i=0; $i<strlen($string); $i++){
			$char = substr($string, $i, 1);
			$keychar = substr($this->privKey, ($i % strlen($this->privKey))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}

		return base64_encode($result);
	}

	/* Base64 decrypt with Key */ 
	public function decrypt($string) {
		$result = '';
		$string = base64_decode($string);

		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($this->privKey, ($i % strlen($this->privKey))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}

		return $result;
	}

	

}