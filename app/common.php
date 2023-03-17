<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Config;

function debugEcho($string) {
	if (Config::DEBUG_ECHO) {
		echo $string;
	}
}