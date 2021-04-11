# TravelShop Example
This is an example Travelshop Theme for WordPress.
It's based on the  [pressmind® SDK](https://github.com/pressmind/sdk)

#### Demo-Page
[https://travelshop-theme.pressmind.de](https://travelshop-theme.pressmind.de)

#### Screenshot
![Overview Image Demo-Page](./travelshop/assets/img/overview.jpg)

#### What is it not?
* it's not the pressmind's truetravel source, it's just a WordPress integration example for the [pressmind® SDK](https://github.com/pressmind/sdk)
* a full featured, plug & play travelshop
* it's not a booking engine, but you can integrate your own booking engine, or you can use the pressmind® IB3 booking engine

#### What is it?
* a good starting point for developing a WordPress based travelshop based on the pressmind® PIM
* the travelshop matches the german touroperator market

#### For Freelance Web-Developers & Agencies
If you're planning a travelshop for german (DACH) touroperators, it's possible to use this theme as a starting point for your project.
Keep in mind that you need pressmind®, so you do not build or integrate complex booking technology.

In most cases this is the basic setup for each travelshop:
* pressmind® Professional (PIM-System for touroperators)
* pressmind® IB3 (seamless booking engine, with connectors to a lot of german touroperator Systems like BusPro, Blank, DaVinci, TouPac, turista 2/3, STADIS)
* [pressmind® SDK](https://github.com/pressmind/sdk) or this theme

#### Features
* Display different tourism based products (packages, hotels, roundtrips, daytrips, etc)
* List products in a defined order
* Search products by defined attributes
* Search by travel date
* Search by duration-range
* Search by price-range
* Search by text
* Display cheapest available price
* Display bookable content, delivered by touroperator systems
* Link to a external IBE's like pressmind IB3
* Image Handling: Thumbnailer, Optimization
* Amazon S3 support
* ... and many more

#### System overview

![system overview](./travelshop/assets/img/pressmind_travelshop.png)


#### More Information:
* [Installation Documentation](./travelshop/installation.md)
* [Common Theme Documentation](./travelshop/readme-theme.md)

#### How to generate product lists? 
It's possible to output product listings on three different ways:

* list by the media object default list route by GET params
* list by shortcodes
* list by the default pressmind SDK framework

For examples and more informations look at the 
theme specific [QueryString API](./travelshop/readme-querystring-api.md)


#### Theme Developer Documentation
Take a look at the [pressmind web-core project](https://github.com/pressmind/web-core-skeleton-basic/#quickstart), 
most of the pressmind sdk implementation in this theme is based on those examples.



