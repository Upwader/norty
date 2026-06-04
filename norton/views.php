<?php
	class Views {
		public function getViews($name): int {
			return 0;
		}

		public function inc($name): void {

		}
	}

	require("viewsJSON.php");
	require("viewsSQLite.php");

	$views = new ("views".viewsMode)();

