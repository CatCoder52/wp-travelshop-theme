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

## Overview
**Search by...**
* [Object Type (pm-ot)](#pm-ot-object-type)
* [ID (pm-id)](#pm-id-id)
* [Pool (pm-po)](#pm-po-pool)
* [Visibility (pm-vi)](#pm-vi-visibility)
* [State (pm-st)](#pm-st-state)
* [Booking State (pm-bs)](#pm-bs-booking-state)
* [Brand (pm-br)](#pm-br-brand)
* [Transport (pm-tr)](#pm-tr-transport-type)
* [Term/Fulltext (pm-t)](#pm-t-term--fulltext)
* [Price Range (pm-pr)](#pm-pr-price-range)
* [Duration Range (pm-du)](#pm-du-duration-range)
* [Date Range (pm-dr)](#pm-dr-date-range)
* [Valid from/ Valid to (pm-vr)](#pm-vr-valid-from-valid-to)
* [Category Tree Item/s (pm-c)](#pm-c-category-tree-items)
* [HousingOption / occupancy / room search](#pm-ho-housingoption-occupancy--room-search)
  
**Other**
* [Order by (pm-o)](#pm-o-order)
* [Pagination (pm-l)](#pm-l-limit)


## Query parameter

### pm-ot (Object Type)
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

### pm-id (ID)
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

### pm-po (Pool)
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

### pm-vi (Visibility)
visibilitiy enumeration

| enum  |description|
|---    |---        |
| 10    |Nobody     |
| 30    |Public     |
| 40    |Extranet   |
| 50    |Intranet   |
| 60    |Hidden     |

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

### pm-st (State)
pressmind state enumeration

| enum  |description                        |
|---    |---                                |
|30     |Draft                              |
|40     |Pending Review                     |
|50     |OK                                 |
|60     |Closed                             |
|70     |Closed (reason: age)               |
|80     |Closed (reason: law)               |
|90     |Closed (reason: bad quality)       |
|100    |Closed (reason: duplicate content) |
|110    |Closed (reason: technical error)   |
|200    |Imported                           |

custom states are possible, take look at the pressmind PIM config

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

### pm-bs (Booking State)
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

### pm-br (Brand)
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

### pm-tr (Transport Type)
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

### pm-t (Term / Fulltext)
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



### pm-pr (Price Range)
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

### pm-du (Duration Range)
Search by price range. Allowed pattern ([0-9]+)\-([0-9])+
```
GET https://yoursite.de/search/?pm-du=3-5
```
```
WORDPRESS SHORTCODE [ts-list pm-du="3-5"]
```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\DurationRange::create(3, 5),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-dr (Date Range)
Search by departure in defined date range. <br>
Allowed pattern:
<br>YYYYMMDD-YYYYMMDD (fixed range)
<br>or
<br>OFFSET-OFFSET means {relative range-offset based on today}-{relative offset from today} eg. "+90-+120" or "90-120"
<br>or
<br>OFFSET {relative range from today from today} e.g. "+90" same as "0-90"

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

### pm-vr (Valid from, Valid to)
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

### pm-c[] (Category Tree Item/s)
Search by one or more pressmind categorytree attributes.
Pattern:<br> pm-c[{FIELDNAME_SECTIONNAME}]={ITEM_UUID}{OPERATOR}{ITEM_UUID}
Allowed Operators "," or "+"<br>
It also possible to search for categorytree items that are joined with a objectlink, 
just set the FIELDNAME_SECTIONNAME from the linked object.

```
// list products that contain attributes xxx OR yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx,yyyy

// list products that contain both attributes xxx AND yyy
GET https://yoursite.de/search/?pm-c[land_default]=xxx+yyyy
```
```
WORDPRESS SHORTCODE [ts-list pm-ot="123" pm-c-land_default="xxx+yyyy"]

WORDPRESS SHORTCODE [ts-listpm-ot="123" pm-c-land_default="xxx,yyyy"]
! Brackets [] are not supported in shortcodes, so the pattern is slightly different to the GET request.
! The parameter pm-ot (object type id) is mandatory

```
```php
// pressmind/sdk search conditions
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\ObjectType::create(123),
        \Pressmind\Search\Condition\Category::create('land_default', ['xxx', 'yyy'], 'OR'),
        // \Pressmind\Search\Condition\Category::create('land_default', ['xxx', 'yyy'], 'AND'),
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```

### pm-ho (HousingOption occupancy / room search)
Search products that contains rooms or cabins based on the given occupancies.
The example searches a product that have a 
room for 2 people (double room) and a room for 3 people.

```
GET https://yoursite.de/search/?pm-ho=2,3
```

```
WORDPRESS SHORTCODE [ts-list pm-ho="2,3"]
```

```php
$search = new Pressmind\Search(
    [
        \Pressmind\Search\Condition\HousingOption::create(2,3)
    ]
);
foreach ($search->getResults() as $mediaObject) {
    echo $mediaObject->render('Teaser1', 'de');
}
```



### pm-o (Order)
Order the result list.
Allowed values:
rand, date_departure-desc, date_departure-asc, price-desc, price-asc, name-asc, name-desc, code-asc, code-desc

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

### pm-l (Limit)
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

 
