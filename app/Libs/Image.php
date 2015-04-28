<?php namespace App\Libs;

class Image {

	public static function getImageInfoFromBase64($base64Str){
		$imageDecode = base64_decode($base64Str);
		$imageInfo = getimagesizefromstring($imageDecode);

		$result = new \stdClass;
		$result->width = $imageInfo[0];
		$result->height = $imageInfo[1];

		$result->ext = '';
		if($imageInfo['mime'] == 'image/png'){
			$result->ext = '.png';
		}else if($imageInfo['mime'] == 'image/gif'){
			$result->ext = '.gif';
		}
		
		return $result;
	}

	public static function placeholder($height, $width, $text) {
		// Dimensions
		//header ("Content-type: image/png");
		$getsize = $height.'x'.$width;
		$dimensions = explode('x', $getsize);
		// Create image
		$image = imagecreate($dimensions[0], $dimensions[1]);
		// Colours
		$bg = 'ccc';
		$bg = Image::hex2rgb($bg);
		$setbg = imagecolorallocate($image, $bg['r'], $bg['g'], $bg['b']);
		$fg = '555';
		$fg = Image::hex2rgb($fg);
		$setfg = imagecolorallocate($image, $fg['r'], $fg['g'], $fg['b']);
		// Text
		//$text = isset($_GET['text']) ? strip_tags($_GET['text']) : $getsize;
		//$text = str_replace('+', ' ', $text);
		// Text positioning
		$fontsize = 4;
		$fontwidth = imagefontwidth($fontsize);
		// width of a character
		$fontheight = imagefontheight($fontsize);
		// height of a character
		$length = strlen($text);
		// number of characters
		$textwidth = $length * $fontwidth;
		// text width
		$xpos = (imagesx($image) - $textwidth) / 2;
		$ypos = (imagesy($image) - $fontheight) / 2;
		// Generate text
		imagestring($image, $fontsize, $xpos, $ypos, $text, $setfg);
		// Render image
		imagepng($image);
	}

	public static function fromBase64($base64Str, $outputFile){
		$ifp = fopen( $outputFile, "wb" ); 
	    fwrite( $ifp, base64_decode( $base64Str) ); 
	    fclose( $ifp ); 
	    return basename($outputFile);
	}

	public static function hex2rgb($colour) {
		$colour = preg_replace("/[^abcdef0-9]/i", "", $colour);
		if (strlen($colour) == 6) {
			list($r, $g, $b) = str_split($colour, 2);
			return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
		} elseif (strlen($colour) == 3) {
			list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
			return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
		}
		return false;
	}

}
