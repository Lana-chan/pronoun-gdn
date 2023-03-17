<?php

# With composer we can autoload the Handlebars package
include_once __DIR__ . "/common.php";

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

# Set the partials files
$partialsDir = __DIR__ . "/../templates";
$partialsLoader = new FilesystemLoader($partialsDir,
	[
		"extension" => "tpl"
	]
);

# We'll use $handlebars throughout this the examples, assuming the will be all set this way
$handlebars = new Handlebars([
	"loader" => $partialsLoader,
	"partials_loader" => $partialsLoader,
	"enableDataVariables" => true
]);