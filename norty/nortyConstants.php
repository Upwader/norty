<?php
	// Most people won't need to change these, unless they're experimenting with adding new things. (among other exceptions)

	// Font from font.png, starting horizontal pixel and width of character.
	// "0" starts at X pixel 0 and is 3 characters of width, "1" starts at X pixel 4 and is 3 characters of width, etc.
	define("fontData", [
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
		"a" => [60, 4],
		"b" => [65, 4],
		"c" => [70, 4],
		"d" => [74, 4],
		"e" => [79, 4],
		"f" => [84, 3],
		"g" => [88, 4, 2],
		"h" => [93, 3],
		"i" => [97, 1],
		"j" => [99, 2],
		"k" => [102, 3],
		"l" => [106, 1],
		"m" => [108, 5],
		"n" => [114, 4],
		"ñ" => [119, 4],
		"o" => [124, 4],
		"p" => [129, 3, 2],
		"q" => [134, 3, 2],
		"r" => [139, 3],
		"s" => [143, 4],
		"t" => [148, 3],
		"u" => [152, 4],
		// perhaps tweak the v kinda looks like the u
		"v" => [157, 3],
		"w" => [161, 5],
		"x" => [167, 4],
		"y" => [172, 3],
		"z" => [176, 3],
		// I added this character after the lowercase set, that's why it's all the way over here instead of at the beginning with the numbers and the slash.
		":" => [180, 4],

		// Uppercase charset later. This character's position WILL be moved.
		"U" => [185, 4],
	]);

	// Default font height decided by most common character height, being 6.
	define("fontHeight", 6);

	// Constants for fontData array. Example, fontData["p"][FONT_CHAR_WIDTH] will return the width of the character p.
	define("FONT_CHAR_XPOS", 0);
	define("FONT_CHAR_WIDTH", 1);
	define("FONT_CHAR_OFFSET", 2);

	// I wouldn't change these. They're used almost everywhere.
	// Perhaps a useless thing to define as a constant, though.
	// This feels like those Twitter posts about people making constants that are just booleans named "BOOL_TRUE" and "BOOL_FALSE"
	// Feel free to comment
	define("currentMonth", intval(date("n")));
	define("currentYear", intval(date("Y")));

	// Year to be displayed in the GIF. Month displayed is just currentMonth.
	// I'm using a different variable for this since the original gif used a 2 digit year and not a 4 digit year like currentYear is.
	define("currentYearShort", intval(date("y")));


	// GIF templates to choose from!
	define("availableTemplates", [
		"88x31",
		"large",
		"largeMac",
		"largeProtectYourself",
		"largeMacProtectYourself",
	]);

	// Right now this only has information on whether the text should be offset from the bottom of the image.
	// Might change "Updated: " to something else later on.
	define("templateInformation", [
		"88x31" => [
			"textBottomOffset" => 0,
			"prefix" => "",
		],
		"large" => [
			"textBottomOffset" => 3,
			"prefix" => "Updated: ",
		],
		"largeMac" => [
			"textBottomOffset" => 3,
			"prefix" => "Updated: ",
		],
		"largeProtectYourself" => [
			"textBottomOffset" => 3,
			"prefix" => "Updated: ",
		],
		"largeMacProtectYourself" => [
			"textBottomOffset" => 3,
			"prefix" => "Updated: ",
		],
	]);