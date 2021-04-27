# The query string API
You can list products (pressmind media objects) on several ways:

1. use a deeplink on base route for the media object type
2. use a wordpress shortcode
3. use pressmind/sdk php code 

See examples below:

## Example Usage
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

## Query parameter

### pm-ot
pressmind object-type id, (int)
```
GET https://yoursite.de/search/?pm-ot=12
```
```
WORDPRESS SHORTCODE [ts-list pm-ot="12"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\ObjectType::create(12)
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-id
pressmind media object id/s, (int)
```
GET https://yoursite.de/search/?pm-id=12345,12346
```
```
WORDPRESS SHORTCODE [ts-list pm-id="12345,123456"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\MediaObjectID::create([12345,123456])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-po
pressmind pool id/s, (int)
```
GET https://yoursite.de/search/?pm-po=123,124
```
```
WORDPRESS SHORTCODE [ts-list pm-po="123,124"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Pool::create([123,124])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-vi
visibilitiy enumeration

10 = "Nobody"
30 = "Public"
40 = "Extranet"
50 = "Intranet"
```
GET https://yoursite.de/search/?pm-vi=30,40
```
```
WORDPRESS SHORTCODE [ts-list pm-tr="30,40"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Visibility::create([30, 40])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-st
pressmind state enumeration

30 = "Draft"
40 = "Pending Review"
50 = "OK"
60 = "Closed"
70 = "Closed (reason: age)"
80 = "Closed (reason: law)"
90 = "Closed (reason: bad quality)"
100 = "Closed (reason: duplicate content)"
110 = "Closed (reason: technical error)"
200 = "Imported"

custom states are possible, look at the pressmind client

```
GET https://yoursite.de/search/?pm-st=50
```
```
WORDPRESS SHORTCODE [ts-list pm-st="50"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\State::create([50])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-bs
pressmind booking state enumeration (date based)

```
GET https://yoursite.de/search/?pm-bs=1
```
```
WORDPRESS SHORTCODE [ts-list pm-bs="1"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\BookingState::create([1])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-br
media object brand
```
GET https://yoursite.de/search/?pm-br=12
```
```
WORDPRESS SHORTCODE [ts-list pm-br="12"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Brand::create([12])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-tr
transport type/s (string)
```
GET https://yoursite.de/search/?pm-tr=FLUG,PKW
```
```
WORDPRESS SHORTCODE [ts-list pm-tr="FLUG,PKW"]
```

```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Transport::create(['PKW', 'FLUG'])
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-t
Fulltext search in the defined pressmind fields.
see theme-config.php, constant SEARCH_FIELDS 
Additional parameter pm-o required!
```
GET https://yoursite.de/search/?pm-o=12&pm-t=Italien
```
```
WORDPRESS SHORTCODE [ts-list pm-ot="12" pm-t="Italien"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Fulltext::create('Italien', ['fulltext'], 'AND', 'NATURAL LANGUAGE MODE'),
        \Pressmind\Search\Condition\ObjectType::create(12)
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```



### pm-pr
Search by price range. Allowed pattern ([0-9]+)\-([0-9])+
```
GET https://yoursite.de/search/?pm-pr=100-1000
```
```
WORDPRESS SHORTCODE [ts-list pm-pr="100-1000"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\PriceRange::create(100, 1000),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-dr
Search by date range. Allowed pattern: YYYYMMDD-YYYYMMDD
```
GET https://yoursite.de/search/?pm-dr=20201231-20213101
```
```
WORDPRESS SHORTCODE [ts-list pm-dr="20201231-20213101"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\DateRange::create(new DateTime('2020-12-31'), new DateTime('2021-01-31')),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-vr
Search by valid from, valid to range. Allowed pattern: YYYYMMDD-YYYYMMDD
```
GET https://yoursite.de/search/?pm-vr=20201231-20213101
```
```
WORDPRESS SHORTCODE [ts-list pm-vr="20201231-20213101"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Validity::create(new DateTime('2020-12-31'), new DateTime('2021-01-31')),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-c[]
Search by one or more pressmind categorytree attributes
pattern: pm-c[{FIELDNAME_SECTIONNAME}]={ITEM_UUID}{OPERATOR}{ITEM_UUID}
Allowed Operator , or +
```
// list products that contain attributes xxx OR yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx,yyyy

// list products that contain both attributes xxx AND yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx+yyyy
```
```
WORDPRESS SHORTCODE [ts-list pm-c-land_default="xxx+yyyy"]

WORDPRESS SHORTCODE [ts-list pm-c-land_default="xxx,yyyy"]
! brackets [] are not supported in shortcodes, so the pattern is slightly different to the GET request.
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\Category::create('land_default', ['xxx', 'yyy'], 'OR'),
        // \Pressmind\Search\Condition\Category::create('land_default', ['xxx', 'yyy'], 'AND'),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```


### pm-o
Order the result list.
Allowed values:
rand, price-desc, price-asc, name-asc, name-desc, code-asc, code-desc

```
// Order the result by price, lowest price first
GET https://yoursite.de/search/?pm-o=price-asc
```
```
WORDPRESS SHORTCODE [ts-list pm-o="price-asc"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\PriceRange::create(1, 99999)
    ],
    [0,100],
    ['price' => 'asc']
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-l
Paginator, pages through the search result
{PAGE},{NUMBER}
Pattern ([0-9]+\,[0-9]+)
```
// get page one (with 10 items) of the result
GET https://yoursite.de/search/?pm-l=1,10
```
```
WORDPRESS SHORTCODE [ts-list pm-l="1,10"]
```

 
