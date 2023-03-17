<?php

require_once __DIR__ . "/../app/common.php";
require_once __DIR__ . "/../app/templating.php";

$known_pronouns = [
	["she","her","her","hers","herself"],
	["he","him","his","his","himself"],
	["they","them","their","theirs","themselves"],
	["ze","hir","hir","hirs","hirself"],
	["ze","zir","zir","zirs","zirself"],
	["byte","byte","bytes","bytes","byteself"],
	["xey","xem","xyr","xyrs","xemself"],
	["ae","aer","aer","aers","aerself"],
	["e","em","eir","eirs","emself"],
	["ey","em","eir","eirs","eirself"],
	["fae","faer","faer","faers","faerself"],
	["fey","fem","feir","feirs","feirself"],
	["hu","hum","hus","hus","humself"],
	["it","it","its","its","itself"],
	["jee","jem","jeir","jeirs","jemself"],
	["kit","kit","kits","kits","kitself"],
	["ne","nem","nir","nirs","nemself"],
	["peh","pehm","peh's","peh's","pehself"],
	["per","per","per","pers","perself"],
	["sie","hir","hir","hirs","hirself"],
	["se","sim","ser","sers","serself"],
	["shi","hir","hir","hirs","hirself"],
	["si","hyr","hyr","hyrs","hyrself"],
	["they","them","their","theirs","themself"],
	["thon","thon","thons","thons","thonself"],
	["ve","ver","vis","vis","verself"],
	["ve","vem","vir","virs","vemself"],
	["vi","ver","ver","vers","verself"],
	["vi","vim","vir","virs","vimself"],
	["vi","vim","vim","vims","vimself"],
	["xie","xer","xer","xers","xerself"],
	["xe","xem","xyr","xyrs","xemself"],
	["xey","xem","xeir","xeirs","xemself"],
	["yo","yo","yos","yos","yosself"],
	["ze","zem","zes","zes","zirself"],
	["ze","mer","zer","zers","zemself"],
	["zee","zed","zeta","zetas","zedself"],
	["zie","zir","zir","zirs","zirself"],
	["zie","zem","zes","zes","zirself"],
	["zie","hir","hir","hirs","hirself"],
	["zme","zmyr","zmyr","zmyrs","zmyrself"]
];

class ListContainsFilter {
	private $check;
	private $index;
	
	function __construct($check, $index = 0) {
		$this->check = $check;
		$this->index = $index;
	}
	
	function listContains($list) {
		foreach ($list as $value) {
			if ($value == $this->check) return true;
		}
		return false;
	}
	
	function listContainsOrdered($list) {
		for ($i = 0; $i <= $this->index; $i++) {
			if ($list[$i] != $this->check[$i]) return false;
		}
		return true;
	}
}

function make_pronoun_shorthands() {
	global $known_pronouns;
	$shorthands = [];

	foreach($known_pronouns as $pronouns) {
		$shorthand = [];
		$still_ambiguous = true;
		foreach($pronouns as $index => $pronoun) {
			if ($still_ambiguous) {
				array_push($shorthand, $pronoun);
			}
			$ambiguous = array_filter($known_pronouns, array(new ListContainsFilter($pronouns, $index), 'listContainsOrdered'));
			$still_ambiguous = count($ambiguous) > 1;
			if (!$still_ambiguous) break;
		}
		// not the right way to do this, will break
		if (count($shorthand) > 3) {
			$shorthand = [$shorthand[0], "...", $shorthand[4]];
		}
		array_push($shorthands, implode("/", $shorthand));
	}
	return $shorthands;
}

function find_pronouns($query) {
	global $known_pronouns;
	if (!$query) return false;

	$pronouns = explode("/", $query);
	if (count($pronouns) == 5)
		return $pronouns;

	$filtered_pronouns = $known_pronouns;
	foreach($pronouns as $pronoun) {
		if ($pronoun == "...") continue;
		$filtered_pronouns = array_filter($filtered_pronouns, array(new ListContainsFilter($pronoun), 'listContains'));
	}
	if (count($filtered_pronouns) >= 1)
		return array_values($filtered_pronouns)[0];

	return false;
}

function fit_phrases($pronouns) {
	$phrases = [
		"$0 went to the park.",
		"I went with $1.",
		"$0 brought $2 frisbee.",
		"At least I think it was $3.",
		"$0 threw the frisbee to $4."
	];

	// this is VERY HACKY but quick and dirty and
	// works only because the first pronoun is the only one to appear at start of phrases
	// and ONLY at start of phrases. might be better to just do this in templating
	$pronouns[0] = ucfirst($pronouns[0]);

	$idx_pronouns = ["$0", "$1", "$2", "$3", "$4"];

	$fit_phrases = preg_replace('/(\$\d)/i', "<span class=\"strong\">$1</span>", $phrases);
	$fit_phrases = str_replace($idx_pronouns, $pronouns, $fit_phrases);

	return $fit_phrases;
}

$title = "Pronoun Garden";
$tidy_url = "pronoun.gdn";
$base_url = "https://".$tidy_url."/";

$queries = $_SERVER["QUERY_STRING"];

if ($queries == "/" || $queries == "/all-pronouns") {
	$model = [
		"title" => $title,
		"tidy_url" => $tidy_url,
		"base_url" => $base_url,
		"all" => $queries == "/all-pronouns",
		"known_shorthands" => make_pronoun_shorthands()
	];

	echo $handlebars->render("default", $model);
} else {
	// funny URI parsing goes brrrrrrr
	$queries = preg_replace("/^\/+|\/+$/i", "", $queries); // get rid of trailing slash
	$queries = str_replace("?", "&", $queries); // we don't care if it's ? or &
	$queries = explode("&", $queries); // tokenize by ?/&

	$pronouns = [];
	$phrases = [];
	$short_pronouns = [];
	
	foreach ($queries as $query) {	
		$pquery = preg_replace("/^\/+|^or=|\/+$/i", "", $query);
		$this_pronoun = find_pronouns($pquery);
		if ($this_pronoun) {
			array_push($pronouns, $this_pronoun);
			array_push($phrases, fit_phrases($this_pronoun));
			array_push($short_pronouns, $this_pronoun[0] . '/' . $this_pronoun[1]);
		}
	}
	
	$title_append = implode(" and ", $short_pronouns);
	
	if ($title_append) {
		$title .= ": " . $title_append . " examples";
	}
	
	$model = [
		"title" => $title,
		"tidy_url" => $tidy_url,
		"base_url" => $base_url,
		"pronouns" => $pronouns,
		"short_pronouns" => $short_pronouns,
		"phrases" => $phrases
	];
	
	$handlebars->addHelper("lookup",
			function($template, $context, $args, $source){
					$argv = explode(" ", $args);
					$array = $context->get($argv[0]);
					$index = $context->get($argv[1]);
					return $array[$index];
			}
	);
	
	echo $handlebars->render("examples", $model);
}
