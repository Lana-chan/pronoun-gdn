{{#define content}}
	{{#if phrases}}
		{{#each phrases}}
			<div class="section example">
				<h2>Here are some examples using my {{#lookup ../short_pronouns @index}} pronouns:</h2>
				{{#each .}}
					<p>{{{ . }}}</p>
				{{/each}}
			</div>
		{{/each}}
	{{else}}
		<div class="section example">
			<h2>we couldn't find those pronouns in our database :(</h2>
			<p>if you think we should have them, please reach out!</p>
		</div>
	{{/if}}
{{/define}}

{{> base}}