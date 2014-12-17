<?php

class Image
{
	protected $image;
	protected $colors;
	protected $fonts;

	public function __construct($x, $y)
	{
		$this->image = imagecreatetruecolor($x, $y);
	}

	public function setBackgroundFromUrl($url)
	{
		$srcImage = imagecreatefromjpeg($url);

		if(imagesx($srcImage) > imagesy($srcImage)){
			$srcSize = imagesy($srcImage);
			$xOffset = (imagesx($srcImage) - imagesy($srcImage))/2;
			$yOffset = 0;
		}elseif(imagesx($srcImage) < imagesy($srcImage)){
			$srcSize = imagesx($srcImage);
			$yOffset = (imagesy($srcImage) - imagesx($srcImage))/2;
			$xOffset = 0;
		}else{ // They are the same
			$srcSize = imagesx($srcImage);
			$xOffset = 0;
			$yOffset = 0;
		}

		imagecopyresampled($this->image, $srcImage, 0, 0, $xOffset, $yOffset, SIZE, SIZE, $srcSize, $srcSize);
	}

	public function textWithShadow($size, $x, $y, $textColor, $shadowColor, $font, $text)
	{
		imagettftext($this->image, $size, 0, $x +2, $y +2, $this->colors[$shadowColor], $this->fonts[$font], $text);
		imagettftext($this->image, $size, 0, $x, $y, $this->colors[$textColor], $this->fonts[$font], $text);
	}

	public function registerFont($name, $path)
	{
		$this->fonts[$name] = $path;
	}

	public function registerColor($name, $red, $green, $blue)
	{
		$this->colors[$name] = imagecolorallocate($this->image, $red, $green, $blue);
	}

	public function writeToFile($path)
	{
		return imagejpeg($this->image, $path);
	}

}
