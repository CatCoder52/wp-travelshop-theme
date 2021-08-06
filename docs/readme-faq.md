#FAQ

### Missing media objects?
If you are missing pressmind based media objects in your travelshop (using the Querystring API like the "ts-list"-shortcode or a custom php query or a _GET based query on the search route)
does not list all media objects that are stored in pressmind try out the following things:

1. Check your query!

1. Check ```pm-config.php``` if the media object types are set correctly

2. Make a full import
```shell
cd wp-content/travelshop/cli
php import.php fullimport
```


