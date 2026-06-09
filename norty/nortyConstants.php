<?php
	// Most people won't need to change these, unless they're experimenting with adding new things. (among other exceptions)

	// Font from font.png, starting horizontal pixel and width of character. Optionally, a 3rd value stating an offset from the top for letters that hang below others like g, p, or q.
	define("fontData", [
		// This, fully done by hand, started at June 9th 2026 11:50 AM, finished 12:43
		// Blank spaces are symbols I couldn't find characters for
		"\0" => [0, 6],
		"♦" => [6, 5],
		"▒" => [12, 4],


		"\r" => [28, 5],
		"\n" => [34, 5],
		"º" => [40, 3],
		"±" => [44, 3],

		"\t" => [54, 5],
		"┘" => [60, 3],
		"┐" => [64, 3],
		"┌" => [68, 3],
		"└" => [72, 3],
		"┼" => [76, 5],
		"¯" => [82, 4],

		"─" => [92, 4],


		"├" => [107, 3],
		"┤" => [111, 3],
		"┴" => [115, 5],
		"┬" => [121, 5],
		"│" => [127, 1],
		"≤" => [129, 3],
		"≥" => [133, 3],
		"π" => [137, 5],
		"≠" => [143, 5],
		"£" => [149, 5],
		" " => [157, 6],
		"!" => [163, 1],
		"\"" => [165, 3],
		"#" => [169, 5],
		"$" => [175, 5],
		// Barely even resembles a percentage sign. I might be wrong.
		"%" => [181, 3],
		"&" => [185, 3],
		"'" => [190, 3],
		"(" => [194, 2],
		")" => [197, 2],
		"*" => [200, 4],
		"+" => [205, 5],
		"," => [211, 3, 1],
		"-" => [215, 4],
		// No clue. Looks like a plus to me? But there's already a plus symbol. Might be a dot?
		"." => [220, 3],
		"/" => [224, 4],
		"0" => [229, 3],
		"1" => [233, 3],
		"2" => [237, 4],
		"3" => [242, 4],
		"4" => [247, 4],
		"5" => [252, 4],
		"6" => [257, 4],
		"7" => [262, 4],
		"8" => [267, 4],
		"9" => [272, 4],
		":" => [277, 2],
		";" => [280, 3, 1],
		"<" => [284, 3],
		"=" => [288, 3],
		">" => [292, 3],
		"?" => [296, 3],
		"@" => [300, 5],
		"A" => [306, 4],
		"B" => [311, 4],
		"C" => [316, 4],
		"D" => [321, 4],
		"E" => [326, 4],
		"F" => [331, 4],
		"G" => [336, 4],
		"H" => [341, 4],
		"I" => [346, 3],
		"J" => [350, 4],
		"K" => [355, 4],
		"L" => [360, 3],
		"M" => [364, 4],
		"N" => [369, 4],
		"O" => [374, 4],
		"P" => [379, 4],
		"Q" => [384, 4],
		"R" => [389, 4],
		"S" => [394, 4],
		"T" => [399, 5],
		"U" => [405, 4],
		"V" => [410, 4],
		"W" => [415, 4],
		"X" => [420, 4],
		"Y" => [425, 5],
		"Z" => [435, 4],
		"[" => [436, 3],
		"\\" => [440, 4],
		"]" => [445, 3],
		"^" => [449, 3],
		"`" => [455, 2],
		"a" => [458, 4],
		"b" => [463, 4],
		"c" => [468, 3],
		"d" => [472, 4],
		"e" => [477, 4],
		"f" => [482, 4],
		"g" => [487, 4, 1],
		"h" => [492, 4],
		"i" => [497, 3],
		"j" => [501, 3],
		"k" => [505, 4],
		"l" => [510, 3],
		"m" => [514, 5],
		"n" => [520, 4],
		"o" => [525, 4],
		"p" => [530, 4],
		"q" => [535, 4],
		"r" => [540, 4],
		"s" => [545, 3],
		"t" => [549, 4],
		"u" => [554, 4],
		"v" => [559, 3],
		"w" => [563, 5],
		"x" => [569, 4],
		"y" => [574, 4],
		"z" => [579, 4],
		"{" => [584, 4],
		"|" => [589, 1],
		"}" => [591, 4],
		"~" => [596, 4],

		// I added these myself.
		"ñ" => [603, 4],
		"Ñ" => [608, 4],
		"☺" => [620, 7],
	]);

	// Default font height decided by most common character height, being 6.
	define("fontHeight", 8);

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

	/*
		"textBottomOffset" is how many pixels off the bottom of the image will the text be away from.
		"text" is a template string of what the gif text will say.

		If you add a new template, add it to availableTemplates and add the information here.

		Might change "Updated: " to something else later on.
	*/
	define("templateInformation", [
		"88x31" => [
			"textBottomOffset" => 0,
			"text" => "%month%/%year% %views%",
		],
		"large" => [
			"textBottomOffset" => 3,
			"text" => "Updated: %month%/%year% %views%",
		],
		"largeMac" => [
			"textBottomOffset" => 3,
			"text" => "Updated:%month%/%year% %views%",
		],
		"largeProtectYourself" => [
			"textBottomOffset" => 3,
			"text" => "Updated: %month%/%year% %views%",
		],
		"largeMacProtectYourself" => [
			"textBottomOffset" => 3,
			"text" => "Updated:%month%/%year% %views%",
		],
	]);