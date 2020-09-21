# The Query String API
You can create deeplinks or use the shortcodes to search and display products, also the ajax search uses the query string api.


### Example Usage
```
Use as deeplink:
--
https://yoursite.de/search/?pm-t=spain&pm-dr=20200301-20200531
--

Use as shortcode:
--
[ts-list pm-t="spain" pm-dr="20200301-20200531"]
--

Use as shortcode with a special view-template
--
[ts-list view="Teaser2" pm-t="spain" pm-dr="20200301-20200531"]
--
```

### Query Parameter

####pm-ot
pressmind object-type id, (int)
```
GET https://yoursite.de/search/?pm-ot=12
```

####pm-t
fulltext search in the defined pressmind fields.
see theme-config.php, constant SEARCH_FIELDS 
Additional parameter pm-o required!
```
GET https://yoursite.de/search/?pm-o=12&pm-t=Italien
```

####pm-pr
search by price-range. Allowed Pattern ([0-9]+)\-([0-9])+
```
GET https://yoursite.de/search/?pm-pr=100-1000
```


####pm-dr
search by date-range. Allowed Pattern: YYYYMMDD-YYYYMMDD
```
GET https://yoursite.de/search/?pm-dr=20201231-20213101
```

####pm-c[]
search by one or more pressmind categorytree-attributes
Pattern: pm-c[{FIELDNAME_SECTIONNAME}]={ITEM_UUID}{OPERATOR}{ITEM_UUID}
Allowed Operator , or +
```
// list products that contain attributes xxx OR yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx,yyyy

// list products that contain both attributes xxx AND yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx+yyyy
```

####pm-o
order the result list
Allowed values:
rand, price-desc, price-asc, name-asc, name-desc, code-asc, code-desc

```
// Order the result by price, lowest price first
GET https://yoursite.de/search/?pm-o=price-asc
```

####pm-l
paginator, pages through the search result
{PAGE},{NUMBER}
Pattern ([0-9]+\,[0-9]+)
```
// get page one (with 10 items) of the result
GET https://yoursite.de/search/?pm-l=1,10
```

 