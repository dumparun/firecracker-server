<?php

class SecurityUtil {

	public static function getRandomString($size = 10, $characters = NULL) {

		if ($characters == NULL)
			$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randstring = '';
		$stringLen = strlen ( $characters );
		for($i = 0; $i < $size; $i ++) {
			$randstring .= $characters [rand ( 0, $stringLen - 1 )];
		}
		return $randstring;
	
	}
	
	// if max value is not passsed, then max will the maximum for the rand function
	public static function getRandomNumber($min = 0, $max = -1) {

		if ($max == - 1)
			$max = mt_getrandmax ();
		return mt_rand ( $min, $max );
	
	}
	
	// create and retrieve salt to be used along with password
	public static function getSalt() {

		$random = SecurityUtil::getRandomString ( 20 );
		return hash ( 'sha256', $random );
	
	}

	public function createPassword($password, $salt) {

		$hash = crypt ( $password, $this->gensalt_blowfish ( 8, $salt ) );
		if (strlen ( $hash ) == 60)
			return $hash;
	
	}
	
	// This method is copied from PHPPass open source code base from
	// http://www.openwall.com/phpass/
	private function gensalt_blowfish($iteration, $input) {
		// This one needs to use a different order of characters and a
		// different encoding scheme from the one in encode64() above.
		// We care because the last character in our encoded string will
		// only represent 2 bits. While two known implementations of
		// bcrypt will happily accept and correct a salt string which
		// has the 4 unused bits set to non-zero, we do not want to take
		// chances and we also do not want to waste an additional byte
		// of entropy.
		
		$iteration_count_log2;
		
		if ($iteration < 4 || $iteration > 31)
			$iteration = 8;
		
		$iteration_count_log2 = $iteration;
		
		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		$output = '$2a$';
		$output .= chr ( ord ( '0' ) + $iteration_count_log2 / 10 );
		$output .= chr ( ord ( '0' ) + $iteration_count_log2 % 10 );
		$output .= '$';
		
		$i = 0;
		do {
			$c1 = ord ( $input [$i ++] );
			$output .= $itoa64 [$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16) {
				$output .= $itoa64 [$c1];
				break;
			}
			
			$c2 = ord ( $input [$i ++] );
			$c1 |= $c2 >> 4;
			$output .= $itoa64 [$c1];
			$c1 = ($c2 & 0x0f) << 2;
			
			$c2 = ord ( $input [$i ++] );
			$c1 |= $c2 >> 6;
			$output .= $itoa64 [$c1];
			$output .= $itoa64 [$c2 & 0x3f];
		}
		while ( 1 );
		
		return $output;
	
	}

}
?>