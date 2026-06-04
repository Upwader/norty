<?php
	// Norty "config" file.
	//
	// You might be worried that this file is public and directly next to the Norty main script, publically, in your web server.
	// It's fine. It doesn't matter. It'll just show up as a blank page in your browser.
	// I say this because this is the type of thing I'd worry about when I was 14 putting crap I got off the internet into my web server


	// Don't change the next 3 things unless you're adding a new character to the font set or experimenting with changing the month or year values.

	// Font from font.png, starting horizontal pixel and width of character.
	// "0" starts at X pixel 0 and is 3 characters of width, "1" starts at X pixel 4 and is 3 characters of width, etc.
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
	define("currentMonth", intval(date("n")));
	define("currentYear", intval(date("Y")));

	// Year to be displayed in the GIF. Month displayed is just currentMonth.
	// I'm using a different variable for this since the original gif used a 2 digit year and not a 4 digit year like currentYear is.
	define("currentYearShort", intval(date("y")));

	// Where are the files the program depends on stored? Like the database or the template files for the GIF.
	// PLEASE MODIFY THIS!!!! You don't want these to be public!!!
	const cwd = "./norton";

	// What storage method will be used for the views counter?
	// Available methods:
	// 1. JSON
	// 2. SQLite
	// ...I recommend SQLite.
	const viewsMode = "JSON";

	// Allow more than 1 person to embed this instance of Norty into their website if set to true
	// Otherwise it'll just count this one website's views
	const allowReferer = true;