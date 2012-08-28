<?php
/**
 * NTICompass' crappy base32 library for PHP
 * 
 * http://labs.nticompassinc.com
 */
class Base32{
	var $encode, $decode, $type;

	// Supports RFC 4648 (default) or Crockford (http://www.crockford.com/wrmg/base32.html)
	function __construct($alphabet='rfc4648'){
		$alphabet = strtolower($alphabet);
		$this->type = $alphabet;
		// Crockford's alphabet removes I,L,O, and U
		$crockfordABC = range('A', 'Z');
		unset($crockfordABC[8], $crockfordABC[11], $crockfordABC[14], $crockfordABC[20]);
		$crockfordABC = array_values($crockfordABC);

		$alphabets = array(
			'rfc4648' => array_merge(range('A','Z'), range(2,7), array('=')),
			'crockford' => array_merge(range(0,9), $crockfordABC, array('='))
		);
		$this->encode = $alphabets[$alphabet];
		$this->decode = array_flip($this->encode);
		// Add extra letters for Crockford's alphabet
		if($alphabet === 'crockford'){
			$this->decode['O'] = 0;
			$this->decode['I'] = 1;
			$this->decode['L'] = 1;
		}
	}

	private function bin_chunk($binaryString, $bits){
		$binaryString = chunk_split($binaryString, $bits, ' ');
		if($this->endsWith($binaryString, ' ')){
			$binaryString = substr($binaryString, 0, strlen($binaryString)-1);
		}
		return explode(' ', $binaryString);
	}

	// String <-> Binary conversion
	// Based off: http://psoug.org/snippet/PHP-Binary-to-Text-Text-to-Binary_380.htm

	private function bin2str($binaryString){
		// Make sure binary string is in 8-bit chunks
		$binaryArray = $this->bin_chunk($binaryString, 8);
		$string = '';
		foreach($binaryArray as $bin){
			// Pad each value to 8 bits
			$bin = str_pad($bin, 8, 0, STR_PAD_RIGHT);
			// Convert binary strings to ascii
			$string .= chr(bindec($bin));
		}
		return $string;
	}

	private function str2bin($input){
		$bin = '';
		foreach(str_split($input) as $s){
			// Return each character as an 8-bit binary string
			$s = decbin(ord($s));
			$bin .= str_pad($s, 8, 0, STR_PAD_LEFT);
		}
		return $bin;
	}

	// starts/endsWith from:
	// http://stackoverflow.com/questions/834303/php-startswith-and-endswith-functions/834355#834355

	private function startsWith($haystack, $needle){
		$length = strlen($needle);
		return substr($haystack, 0, $length) === $needle;
	}

	private function endsWith($haystack, $needle){
		$length = strlen($needle);
		return substr($haystack, -$length) === $needle;
	}

	// base32 info from: http://www.garykessler.net/library/base64.html

	// base32_encode
	public function base32_encode($string){
		// Convert string to binary
		$binaryString = $this->str2bin($string);

		// Break into 5-bit chunks, then break that into an array
		$binaryArray = $this->bin_chunk($binaryString, 5);

		// Pad array to be divisible by 8
		while(count($binaryArray) % 8 !== 0){
			$binaryArray[] = null;
		}

		$base32String = '';

		// Encode in base32
		foreach($binaryArray as $bin){
			$char = 32;
			if(!is_null($bin)){
				// Pad the binary strings
				$bin = str_pad($bin, 5, 0, STR_PAD_RIGHT);
				$char = bindec($bin);
			}
			// Base32 character
			$base32String .= $this->encode[$char];
		}

		return $base32String;
	}

	// base32_decode
	public function base32_decode($base32String){
		$base32Array = str_split(str_replace('-', '', strtoupper($base32String)));
		$binaryArray = array();
		$string = '';
		foreach($base32Array as $str){
			$char = $this->decode[$str];
			if($char !== 32){
				$char = decbin($char);
				$string .= str_pad($char, 5, 0, STR_PAD_LEFT);
			}
		}
		while(strlen($string) %8 !== 0){
			$string = substr($string, 0, strlen($string)-1);
		}
		return $this->bin2str($string);
	}
}