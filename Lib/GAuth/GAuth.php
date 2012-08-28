<?php
/**
 * NTICompass' Google Authenticator for PHP class
 *
 * http://labs.nticompassinc.com
 *
 * Code adapted from
 * http://www.idontplaydarts.com/2011/07/google-totp-two-factor-authentication-for-php/
 */
require_once('Base32.php');

class GAuth{
	var $b32, $keyRegeneration, $otpLength, $seed;

	function __construct($keyRegeneration=30, $otpLength=6){
		$this->b32 = new Base32;
		$this->keyRegeneration = $keyRegeneration;
		$this->otpLength = $otpLength;
		$this->seed = null;
	}

	private function _32to64bit($data){
		// Two 32-bit ints equal one 64-bit int
		return pack('N*', 0) . pack('N*', $data);
	}

	private function _timestamp($binary=FALSE){
		$time = floor(microtime(true) / $this->keyRegeneration);
		if($binary){
			$time = $this->_32to64bit($time);
		}
		return $time;
	}

	private function _generateKey($length=16){
		$alpha = array_merge(range('A','Z'), range(2,7));
		$len = count($alpha)-1;
		$this->seed = '';
		for($i=0; $i<$length; $i++){
			$this->seed .= $alpha[rand(0,$len)];
		}
		return $this->seed;
	}

	public function getKey(){
		return ($this->seed !== null) ? $this->seed : $this->_generateKey();
	}

	private function _oneTimePassword($key, $timestamp=FALSE){
		if($timestamp === FALSE){
			$timestamp = $this->_timestamp(true);
		}
		else{
			$timestamp = $this->_32to64bit($timestamp);
		}
		$hash = hash_hmac('sha1', $timestamp, $key, true);

		// http://www.ietf.org/rfc/rfc4226.txt
		$offset = ord($hash[19]) & 0xf;
		$OTP = ((ord($hash[$offset+0]) & 0x7f) << 24 ) |
			((ord($hash[$offset+1]) & 0xff) << 16 ) |
			((ord($hash[$offset+2]) & 0xff) << 8 ) |
			(ord($hash[$offset+3]) & 0xff);
		$OTP = $OTP % pow(10, $this->otpLength);
		return str_pad($OTP, $this->otpLength, 0, STR_PAD_LEFT);
	}

	public function QRCode($domain, $key=FALSE){
		if($key === FALSE){
			$key = $this->getKey();
		}
		return 'https://chart.googleapis.com/chart?'.
			'chs=200x200&cht=qr&chl='.
			'otpauth://totp/'.urlencode($domain).'?secret='.$key;
	}

	public function verify($otp, $key=FALSE, $window=2){
		if($key === FALSE){
			$key = $this->getKey();
		}
		$binKey = $this->b32->base32_decode($key);
		$timestamp = $this->_timestamp();
		for($ts = $timestamp-$window; $ts <= ($timestamp+$window); $ts++){
			if($otp === $this->_oneTimePassword($binKey, $ts)){
				return true;
			}
		}
		return false;
	}
}