# Pronoun Garden

a very shameless clone of [Pronoun Island](https://github.com/witch-house/pronoun.is) written in PHP in a few hours by maple "mavica" syrup whose pronouns are [byte or it](pronoun.gdn/byte?or=it)

thanks and sorry to [@morganastra](https://twitter.com/morganastra), whose pronouns are [ze or she](pronoun.gdn/ze/zir?or=she) for the original Pronoun Island.

## Hosting

i expect an nginx file passing arguments to PHP-CGI like so:

```
	location / {
			try_files $uri /index.php?$uri$is_args$args;
	}

	location ~ \.php$ {
			fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
			fastcgi_split_path_info ^(.+\.php)(/.+)$;
			fastcgi_index index.php;
			include fastcgi_params;
			fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
	}
```

## License

```
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42 modified):
 * <maple@maple.pet> wrote this file.  As long as you retain this notice and
 * my credit somewhere you can do whatever you want with this stuff.  If we
 * meet some day, and you think this stuff is worth it, you can buy me a beer
 * in return.
 * ----------------------------------------------------------------------------
 */
 ```