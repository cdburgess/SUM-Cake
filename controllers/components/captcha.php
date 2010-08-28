<?php
class CaptchaComponent extends Object
{
    var $font = 'monofont.ttf';
    var $components = array('Session');
    var $params = array();
    
    function initialize(&$controller, $settings = array()) {
	$this->params = $controller->params;
	$this->_set($settings);
    }
     
    function generateCode($characters) {
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '23456789bcdfghjkmnpqrstvwxyz';
	$code = '';
	$i = 0;
	while ($i < $characters) { 
		$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$i++;
	}
	return $code;
    }

    function create($width='120',$height='40',$characters='6') {
	$code = $this->generateCode($characters);							# generate the security code
	$font_size = $height * 0.75;									# set font to 75% of height
	$image = @imagecreate($width, $height) or die('Cannot Initialize new GD image stream');		# create a new image stream with GD
	$background_color = imagecolorallocate($image, 255, 255, 255);					# set the image background color
	$text_color = imagecolorallocate($image, 125, 125, 125);					# set the text color
	$noise_color = imagecolorallocate($image, 175, 175, 175);					# set the noise color
	/* generate random dots in background */
	for( $i=0; $i<($width*$height)/3; $i++ ) {							# get the area of the image
		imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);	# create random dots
	}																			# end loop
	/* generate random lines in background */
	for( $i=0; $i<($width*$height)/150; $i++ ) {							# get the area of the image
		imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
	}																			# end loop
	/* create textbox and add text */
	$textbox = imagettfbbox($font_size, 0, $this->font, $code);					# build a text box
	$x = ($width - $textbox[4])/2;									# set the text height
	$y = ($height - $textbox[5])/2;									# set the text width
	$angle = rand(-5,5);										# randomiz the float angle of text
	imagettftext($image, $font_size, $angle, $x, $y+$angle, $text_color, $this->font , $code);	# write the text to the image
	imagejpeg($image);										# write the image 
	imagedestroy($image);										# remove the image		
	$this->Session->write('Captcha.SecurityCode', $code);
    }
}
?>