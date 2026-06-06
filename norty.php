<?php
	require("nortyConfig.php");
	require(cwd."/nortyConstants.php");
	require(cwd."/views.php");
	require(cwd."/generator.php");

	$error = null;
	// check if there's a referer code
	$ref = $_GET["id"] ?? "";
	$url = allowReferrer ? $ref : "";

	$chosenTemplate = "";
	if(forceDefaultTemplate) {
		$chosenTemplate = defaultTemplate;
	} else {
		$chosenTemplate = $_GET["tmp"] ?? defaultTemplate;
		if(!in_array($chosenTemplate, availableTemplates)) {
			$error = "invalid template";
			$chosenTemplate = defaultTemplate;
		}
	}
	$templateInfo = templateInformation[$chosenTemplate];

	// if the allowed domains list is not empty and the current referrer isn't in it, die
	// $_SERVER["HTTP_REFERER"] ?? "" is in there because Referer is sent by the user and might not be there.
	$referrerURL = @parse_url($_SERVER["HTTP_REFERER"] ?? "");
	if(!empty(allowedDomains) && !in_array($referrerURL["host"] ?? null, allowedDomains)) {
		$error = "domain not allowed";
	}

	// If referrer is on, required, and is empty or unset, show an error.
	if(allowReferrer && requireReferrer && empty($ref)) {
		$error = "referrer required";
	}

	$generator = new NortyGenerator();
	if($error === null) {
		// Increment views, and then get the view count
		$views->inc($url);
		$count = $views->getViews($url);
		
		$final = $generator->generate([
			"template" => $chosenTemplate,
			"views" => $count,
			"year" => currentYearShort,
			"month" => currentMonth,
		]);
	} else {
		$final = $generator->generate([
			"template" => $chosenTemplate,
			"text" => $error,
			"color" => "#ff0000"
		]);
	}

	header("x-powered-by: norty <https://github.com/upwader/norty>", false);
	header("content-type: image/gif");
	$final->setImageFormat("gif");
	// if you don't do this deconstructImages thing imagick freaks out i dont really know why
	echo $final->deconstructImages()->getImagesBlob();
	$final->clear();