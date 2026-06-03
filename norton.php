<?php
	const fontData = [
		"0" => [0, 3],
		"1" => [4, 3],
		"2" => [8, 4],
		"3" => [13, 4],
		"4" => [18, 4],
		"5" => [23, 4],
		"6" => [28, 4],
		"7" => [33, 4],
		"8" => [38, 4],
		"9" => [43, 4],
		"/" => [48, 4],
		" " => [53, 6],
	];

	function write() {
		global $views;
		$file = fopen("./norton/views.json", "w");

		if(flock($file, LOCK_EX)) {
			$new = json_encode($views, JSON_PRETTY_PRINT);
			ftruncate($file, 0);
			rewind($file);
			fwrite($file, $new, strlen($new));
		} else {
			sleep(1);
			write();
		}
	}

	$template = new Imagick("./norton/norton2.gif");
	$font = new Imagick("./norton/font.png");
	$overlay = new Imagick("./norton/overlay.png");

	$final = new Imagick();
	$text = new Imagick();



	$month = date("n");
	$year = date("Y");
	$views = json_decode(file_get_contents("./norton/views.json"), true);
	if(!isset($views[$year])) {
		$views[$year] = [];
	}
	if(!isset($views[$year][$month])) {
		$views[$year][$month] = 0;
	}
	$views[$year][$month]++;
	write();


	$textContent = date("m/y") . " " . $views[$year][$month];
	$textplode = str_split($textContent);
	$totalTextWidth = 0;
	foreach($textplode as $char) {
		$totalTextWidth += fontData[$char][1] + 1;
	}
	$text->newImage($totalTextWidth, 6, new ImagickPixel("transparent"));
	$text->setImageFormat("gif");

	$textImageWidth = 0;
	foreach($textplode as $char) {
		$charData = fontData[$char];
		$width = $charData[1];
		$x = $charData[0];

		$region = $font->getImageRegion($width, 6, $x, 0);
		$text->compositeImage($region, Imagick::COMPOSITE_OVER, $textImageWidth, 0);

		$textImageWidth += $width + 1;
		$region->clear();
	}



	$coalesced = $template->coalesceImages();
	$posX = ($coalesced->getImageWidth() / 2) - ($text->getImageWidth() / 2);
	$posY = $coalesced->getImageHeight() - $text->getImageHeight();

	foreach($coalesced as $_frame) {
		$delay = $_frame->getImageDelay();
		$frame = new Imagick();
		$frame->readImageBlob($_frame->getImageBlob());

		$frame->compositeImage($overlay, Imagick::COMPOSITE_OVER, 0, 0);
		$frame->compositeImage($text, Imagick::COMPOSITE_OVER, $posX, $posY);
		$frame->setImageDelay($delay);

		$final->addImage($frame);
		$frame->clear();

	}



	header("content-type: image/gif");
	$final->setImageFormat("gif");
	$final = $final->deconstructImages();
	echo $final->getImagesBlob();

	$text->clear();
	$template->clear();
	$coalesced->clear();
	$final->clear();
	$overlay->clear();