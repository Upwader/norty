<?php
	class Views {
		public function getViews(string $name): int {
			return 0;
		}

		public function inc(string $name): void {

		}
	}

	require("viewsJSON.php");
	require("viewsSQLite.php");

	$views = new ("views".viewsMode)();

