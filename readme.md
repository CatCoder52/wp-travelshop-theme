# TravelShop Example
This is a example Travelshop Theme for WordPress. 
It's based on the pressmind® web-core SDK. 

#### Demopage
[https://travelshop-theme.pressmind.de](https://travelshop-theme.pressmind.de)

#### What is it not?
* it's not the pressmind's truetravel source, it's just an integration example for the pressmind® web-core sdk
* a full featured, plug & play travelshop 
* it's not a booking engine, but you can integrate you're own booking engine or you can use the pressmind® IB3 booking engine

#### What is it?
* a good startingpoint for developing a WordPress based travelshop based on the pressmind® PIM
* the travelshop matches the german touroperator market

#### For Freelance Webdeveloper's & Agencies
If you're planning a travelshop for german touroperators, it's possible to use this theme as a startingpoint for you're project.
Be in mind that you need pressmind®, so you do not build or integrate complex booking technology.

In most cases this is the basic setup for each travelshop:
* pressmind® Professional (PIM-System for touroperators)
* pressmind® IB3 (seamless booking engine, with connectors to a lot of german touroperator Systems like BusPro, Blank, DaVinci, TouPac, turista 2/3, STADIS) 
* pressmind® web-core SDK or this theme

This setup has most effort, you an design and build a nice travelshop and the pressmind® applications reduce you're complexity

#### Quick Install
* Download latest theme Build: [travelshop.zip](https://travelshop-theme.pressmind.de/download/travelshop.zip)
* Extract travelshop.zip to your WordPress theme directory
* create a database
* setup both database credentials and pressmind api credentials in travelshop/vendor/pressmind/lib/config.json
* activate the theme
* run "php install.php " in travelshop/vendor/pressmind/lib/cli/
* run "php import.php fullimport " in travelshop/vendor/pressmind/lib/cli/
* after a few minutes you're travelshop is running

#### More Information:
* [Installation via Composer](./travelshop/installation.md)
* [Common Theme Documentation](./travelshop/readme-theme.md)
* [QueryString API](./travelshop/readme-querystring-api.md)

