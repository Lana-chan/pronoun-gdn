{{#define content}}
	<div class="section example">
		{{#unless all}}
			<p>{{tidy_url}} is a website for personal pronoun usage examples<p>
			<p>here are some pronouns the site knows about:</p>
			<ul>
				{{#each known_shorthands[:6]}}
				<li>
					<a href="/{{.}}">{{.}}</a>
				</li>
				{{/each}}
			</ul>
			<p class="footer"><a href="/all-pronouns">see all pronouns in the database</a></p>
		{{else}}
			<p>all pronouns the site knows about:</p>
			<ul>
				{{#each known_shorthands}}
				<li>
					<a href="/{{.}}">{{.}}</a>
				</li>
				{{/each}}
			</ul>
		{{/unless}}
	</div>
{{/define}}

{{> base}}