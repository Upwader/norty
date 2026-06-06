<?php

// This code is a bit messy. Improvements welcome

class NortyGenerator {

	public function calculateTextContainerSize(string $textContent): array {
		$totalTextWidth = 0;
		$totalTextHeight = fontHeight;
		foreach(str_split($textContent) as $char) {
			$fd = fontData[$char];

			// If the text contains characters like g or p we need some extra space at the bottom which we wouldn't need otherwise.
			// Calculate height of total text.
			$offset = $fd[FONT_CHAR_OFFSET] ?? 0;
			if($totalTextHeight + $offset != $totalTextHeight) {
				$totalTextHeight += $offset;
			}

			$totalTextWidth += $fd[FONT_CHAR_WIDTH] + 1;
		}

		return [
			"width" => $totalTextWidth,
			"height" => $totalTextHeight
		];
	}

	public function parseText(string $text, array $object): string {
		/*

			I'm learning about regexes. I don't really understand them yet.
			This is what I think the regex does:

				Look for:

					1. %: Starts with "%"
					2. ([^%]+): Any character in between, excluding %
					3. %: Ends with "%"

			I'm probably wrong.
			This function is copypasted from a yet unreleased project.

		*/
		return preg_replace_callback('/%([^%]+)%/', function($matches) use($object) {
			$tag = $matches[1];

			if(isset($object[$tag])) {
				return $object[$tag];
			}
			return "%$tag%";
		}, $text);
	}

	public function renderText(string $textContent, mixed $color = null): Imagick {
		$font = new Imagick(cwd."/font.png");
		$text = new Imagick();
		$textSize = $this->calculateTextContainerSize($textContent);

		// make new image in $text with the width we've just calculated
		$text->newImage($textSize["width"], $textSize["height"], new ImagickPixel("transparent"));
		$text->setImageFormat("gif");

		// place each character into $text
		$textImageWidth = 0;
		foreach(str_split($textContent) as $char) {
			$charData = fontData[$char];
			$offset = $charData[FONT_CHAR_OFFSET] ?? 0;
			$width = $charData[FONT_CHAR_WIDTH];
			$height = fontHeight + $offset;
			$x = $charData[FONT_CHAR_XPOS];

			// get chunk of $font that aligns with whatever character we're looping through and smash it into $text
			$region = $font->getImageRegion($width, $height, $x, 0);

			if($color) {
				$region->colorizeImage(new ImagickPixel($color), new ImagickPixel('white'), true);
			}

			$text->compositeImage($region, Imagick::COMPOSITE_OVER, $textImageWidth, 0);

			// +1 to put a pixel of kerning between characters otherwise it looks ugly
			$textImageWidth += $width + 1;
			$region->clear();
		}

		return $text;
	}

	public function generate(array $info): Imagick {
		$template = new Imagick(cwd."/templates/$info[template].gif");
		$templateInfo = templateInformation[$info["template"]];
		$final = new Imagick();

		// if $info has a set text or color use that instead of the template text in the templateInfo
		$x = $this->parseText($info["text"] ?? $templateInfo["text"], $info);
		$text = $this->renderText($x, $info["color"] ?? null);

		// get array of frames on gif
		$coalesced = $template->coalesceImages();

		// calculate horizontal and vertical position of text on frame
		$posX = (int) (($coalesced->getImageWidth() / 2) - ($text->getImageWidth() / 2));
		$posY = (int) ($coalesced->getImageHeight() - $text->getImageHeight() - $templateInfo["textBottomOffset"]);

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

		// i think this might be useless considering im about to close the script but im gonna leave it here anyway
		$text->clear();
		$template->clear();
		$coalesced->clear();

		return $final;
	}

}
