<?php
	/*
		Norty "config" file.

		You might be worried that this file is public and directly next to the Norty main script, publically, in your web server.
		It's fine. It doesn't matter. It'll just show up as a blank page in your browser.
		I say this because this is the type of thing I'd worry about when I was 14 putting crap I got off the internet into my web server
	*/


	/*
		Where are the files the program depends on stored? Like the database or the template files for the GIF.
		THIS NEEDS TO BE MODIFIED FOR THE PROGRAM TO WORK.
		Also PLEASE put the Norty folder in a place that isn't publically accessible unless you want to leak your database
		(refer to https://andrew.upwader.com/res/i/myspace2.mp4)
	*/
	const cwd = "./norty";

	/*
		What storage method will be used for the views counter?
		Available methods:
			1. JSON (stored in cwd/norty.json)
			2. SQLite (stored in cwd/norty.db)
		...I recommend SQLite.
		Please note that if you move to a different db format, it won't move your data.
	*/
	const viewsMode = "SQLite";

	/*
		Allow more than 1 person to embed this instance of Norty into their website if set to true by allowing them to identify their website through a ?ref parameter
		Otherwise it'll just count this one website's views
	*/
	const allowReferrer = false;

	/*
		Require referrer ?ref parameter to be set, otherwise, show an error.	
	*/
	const requireReferrer = false;

	/*
		If this array isn't empty, it will require that whatever place Norty is being embedded from is from a specific domain.
	*/
	const allowedDomains = [
		// "andrew.upwader.com",
		// "myspace.f46n.org",
	];

	/*
		Default template to use. Can be overriden with query parameter ?tmp, unless forceDefaultTemplate is set to true.
		Available:
			1. 88x31
			2. large
			3. largeMac
			4. largeProtectYourself
			5. largeMacProtectYourself
		Check them in the cwd/templates folder
	*/
	const defaultTemplate = "88x31";

	/*
		Force default template to be used.
	*/
	const forceDefaultTemplate = false;