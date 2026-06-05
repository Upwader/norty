<?php
	require("nortyConfig.php");
	require(cwd."/nortyConstants.php");
	require(cwd."/views.php");

	$ref = $_GET["id"] ?? "";
	$url = allowReferer ? $ref : "";
	$views->inc($url);
	$count = $views->getViews($url);

	$chosenTemplate = $_GET["tmp"] ?? defaultTemplate;
	if(!in_array($chosenTemplate, availableTemplates)) {
		$chosenTemplate = defaultTemplate;
	}
	$templateInfo = templateInformation[$chosenTemplate];

	$template = new Imagick(cwd."/$chosenTemplate.gif");
	$font = new Imagick(cwd."/font.png");
	$final = new Imagick();
	$text = new Imagick();


	// calculate width of image that holds text by adding up all the used characters together using fontData
	$textContent = $templateInfo["prefix"] . currentMonth . "/" . currentYearShort . " " . $count;
	$textplode = str_split($textContent);
	$totalTextWidth = 0;
	$totalTextHeight = fontHeight;
	foreach($textplode as $char) {
		$fd = fontData[$char];

		// If the text contains characters like g or p we need some extra space at the bottom which we wouldn't need otherwise.
		// Calculate height of total text.
		$offset = $fd[FONT_CHAR_OFFSET] ?? 0;
		if($totalTextHeight + $offset != $totalTextHeight) {
			$totalTextHeight += $offset;
		}

		$totalTextWidth += $fd[FONT_CHAR_WIDTH] + 1;
	}

	// make new image in $text with the width we've just calculated
	$text->newImage($totalTextWidth, $totalTextHeight, new ImagickPixel("transparent"));
	$text->setImageFormat("gif");

	// place each character into $text
	$textImageWidth = 0;
	foreach($textplode as $char) {
		$charData = fontData[$char];
		$offset = $charData[FONT_CHAR_OFFSET] ?? 0;
		$width = $charData[FONT_CHAR_WIDTH];
		$height = fontHeight + $offset;
		$x = $charData[FONT_CHAR_XPOS];

		// get chunk of $font that aligns with whatever character we're looping through and smash it into $text
		$region = $font->getImageRegion($width, $height, $x, 0);
		$text->compositeImage($region, Imagick::COMPOSITE_OVER, $textImageWidth, 0);

		// +1 to put a pixel of kerning between characters otherwise it looks ugly
		$textImageWidth += $width + 1;
		$region->clear();
	}


	// get array of frames on gif
	$coalesced = $template->coalesceImages();

	// calculate horizontal and vertical position of text on frame
	$posX = ($coalesced->getImageWidth() / 2) - ($text->getImageWidth() / 2);
	$posY = $coalesced->getImageHeight() - $text->getImageHeight() - $templateInfo["textBottomOffset"];

	foreach($coalesced as $_frame) {
		// if you don't do this to copy the frame into a new Imagick object it won't copy the font text on top of the image
		$delay = $_frame->getImageDelay();
		$frame = new Imagick();
		$frame->readImageBlob($_frame->getImageBlob());

		// slap text on top of gif frame
		$frame->compositeImage($text, Imagick::COMPOSITE_OVER, $posX, $posY);
		$frame->setImageDelay($delay);

		// add frame to $final gif sequence
		$final->addImage($frame);
		$frame->clear();
	}



	header("x-powered-by: norty <https://github.com/upwader/norty>", false);
	header("content-type: image/gif");
	$final->setImageFormat("gif");
	// if you don't do this deconstructImages thing imagick freaks out i dont really know why
	echo $final->deconstructImages()->getImagesBlob();

	// i think this might be useless considering im closing the script but im gonna leave it here anyway
	$text->clear();
	$template->clear();
	$coalesced->clear();
	$final->clear();