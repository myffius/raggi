<?php

	class RImage extends RFile
	{
		protected $_image;
		protected $_imagePath;
		protected $_imageType;
		protected $_imageMime;
	
		public function load($filePath)
		{
			$this->_imagePath = $filePath;
			$imageInfo = getimagesize($this->_imagePath);
	
			$this->_imageType = $imageInfo[2];
			$this->_imageMime = isset($imageInfo['mime']) ? $imageInfo['mime'] : null;
	
			if ( $this->_imageType == IMAGETYPE_JPEG)
				$this->_image = imagecreatefromjpeg($this->_imagePath);
			else if ($this->_imageType == IMAGETYPE_GIF)
				$this->_image = imagecreatefromgif($this->_imagePath);
			else if ($this->_imageType == IMAGETYPE_PNG)
				$this->_image = imagecreatefrompng($this->_imagePath);
			else
				throw new RException('Неподдерживаемый тип изображения');
	
			return $this;
		}
	
		public function save($filePath, $imageType = IMAGETYPE_JPEG, $compression = 75)
		{
			return $this->outputImage($filePath, $imageType, $compression);
		}

		public function render($imageType = IMAGETYPE_JPEG, $compression = 75)
		{
			return $this->outputImage(null, $imageType, $compression);
		}
	
		protected function outputImage($filePath = null, $imageType = IMAGETYPE_JPEG, $compression = 75)
		{
			if($imageType == IMAGETYPE_JPEG)
				imagejpeg($this->_image, $filePath, $compression);
			else if ($imageType == IMAGETYPE_GIF)
				imagegif($this->_image, $filePath);
			else if ($imageType == IMAGETYPE_PNG )
				imagepng($this->_image, $filePath);
			return $this;
		}
	
		public function resize($width, $height)
		{
			$image = imagecreatetruecolor($width, $height);
			imagecopyresampled($image, $this->_image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
			$this->_image = $image;
			return $this;
		}
	
		public function setHeight($height, $proportions = true)
		{
			$width = $this->getWidth();
			if ($proportions)
			{
				$ratio = $height / $this->getHeight();
				$width = $this->getWidth() * $ratio;
			}
			return $this->resize($width, $height);
		}
	
		public function setWidth($width, $proportions = true)
		{
			$height = $this->getHeight();
			if ($proportions)
			{
				$ratio = $width / $this->getWidth();
				$height = $this->getHeight() * $ratio;
			}
			return $this->resize($width, $height);
		}
	
		public function setMaxSide($size)
		{
			$width = $this->getWidth();
			$height = $this->getHeight();
			if ($width > $height && $width > $size)
				return $this->setWidth($size);
			else if ($height > $size)
				return $this->setHeight($size);
			return $this;
		}
	
		public function setMinSide($size)
		{
			$width = $this->getWidth();
			$height = $this->getHeight();
			if ($width < $height && $width < $size)
				return $this->setWidth($size);
			else if ($height < $size)
				return $this->setHeight($size);
			return $this;
		}
	
		public function scale($scale)
		{
			$width = $this->getWidth() * $scale / 100;
			$height = $this->getheight() * $scale / 100;
			return $this->resize($width, $height);
		}
	
		public function getWidth()
		{
			return imagesx($this->_image);
		}
	
		public function getHeight()
		{
			return imagesy($this->_image);
		}
	
		public function getImageType()
		{
			return $this->_imageType;
		}
	
		public function toGray()
		{
			return $this->applyFilter(IMG_FILTER_GRAYSCALE);
		}
	
		public function invert()
		{
			return $this->applyFilter(IMG_FILTER_NEGATE);
		}
	
		public function getColorId($red, $green = null, $blue = null)
		{
			if (is_array($red))
				list($red, $green, $blue) = $red;
			else if (is_string($red))
				list($red, $green, $blue) = $this->colorEncode($red);
	
			return imagecolorallocate($this->_image, $red, $green, $blue);
		}
	
		public function gaussianBlur()
		{
			$gaussian = array(array(1.0, -2.0, 1.0), array(2.0, 4.0, -2.0), array(-1.0, 2.0, 1.0));
			imageconvolution($this->_image, $gaussian, 16, 0);
			return $this;
		}
	
		public function colorEncode($hexColor)
		{
			$hexColor = trim($hexColor, '#');
			if(strlen($hexColor) == 3)
			{
				$red   = hexdec(substr($hexColor,0,1).substr($hexColor,0,1));
				$green = hexdec(substr($hexColor,1,1).substr($hexColor,1,1));
				$blue  = hexdec(substr($hexColor,2,1).substr($hexColor,2,1));
			}
			else
			{
				$red   = hexdec(substr($hexColor,0,2));
				$green = hexdec(substr($hexColor,2,2));
				$blue  = hexdec(substr($hexColor,4,2));
			}
			return array($red, $green, $blue);
		}
	
		public function colorDecode(array $rgbColor)
		{
			$hexColor = '#';
			$hexColor .= str_pad(dechex($rgbColor[0]), 2, '0', STR_PAD_LEFT);
			$hexColor .= str_pad(dechex($rgbColor[1]), 2, '0', STR_PAD_LEFT);
			$hexColor .= str_pad(dechex($rgbColor[2]), 2, '0', STR_PAD_LEFT);
	
			return $hexColor;
		}
	
		protected function applyFilter($filter)
		{
			imagefilter($this->_image, $filter);
			return $this;
		}
	}
