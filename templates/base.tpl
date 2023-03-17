<!DOCTYPE html>
<html>
	<head>
		<title>{{title}}</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta property="og:title" content="{{title}}">
		<meta property="og:type" content="website">
		<meta property="og:description" content="">
		<meta property="og:url" content="{{base_url}}">
		
		<meta name="description" content="">

		<link rel="icon" type="image/ico" href="/favicon.ico">
		<link rel="canonical" href="{{base_url}}">

		<link rel="stylesheet" href="/assets/css/common.css">
	</head>
	<body>
		<div class="section title">
			<a href="/"><h1>{{title}}</h1></a>
		</div>
		{{#invoke content}}
		<div class="section footer">
			<p>Full usage: <span class="mono">{{base_url}}subject-pronoun/object-pronoun/possessive-determiner/possessive-pronoun/reflexive</span> displays examples of your pronouns.

			<p>this is a bit unwieldy. if we have a good guess we'll let you use just the first one or two.</p>

			<p>you can also pass any number of aditional pronouns in "or" arguments like so: <span class="mono">{{base_url}}he?or=she&or=they/.../themselves</span>
		</div>
		<div class="section footer">
			<p>written (initially) in a couple of hours in a single PHP file by <a href="https://maple.pet/">maple "mavica" syrup</a>, whose pronouns are <a href="/byte?or=it">byte or it</a>. i wanted to see if i could do it.</p>

			<p>thanks and sorry to <a href="https://www.twitter.com/morganastra">@morganastra</a>, whose pronouns are <a href="/ze/zir?or=she">ze or she</a>, for the now defunct <a href="https://pronoun.is/">pronoun island</a>, which i've completely ripped off.</p>

			<p>{{tidy_url}} is jank and <a href="https://github.com/lana-chan/pronoun-gdn">open source</a> under a modified beerware license<p>

			<p>PHP-CGI is still cool <3</p>
		</div>
	</body>
</html>
