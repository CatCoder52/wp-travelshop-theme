# TravelShop Example
This is an example Travelshop Theme for WordPress.
It's based on the pressmind® web-core SDK.

#### Demo-Page
[https://travelshop-theme.pressmind.de](https://travelshop-theme.pressmind.de)

#### Screenshot
![Overview Image Demo-Page](./travelshop/assets/img/overview.jpg)

#### What is it not?
* it's not the pressmind's truetravel source, it's just an integration example for the pressmind® web-core sdk
* a full featured, plug & play travelshop
* it's not a booking engine, but you can integrate your own booking engine, or you can use the pressmind® IB3 booking engine

#### What is it?
* a good starting point for developing a WordPress based travelshop based on the pressmind® PIM
* the travelshop matches the german tour-operator market

#### For Freelance Web-Developers & Agencies
If you're planning a travelshop for german tour-operators, it's possible to use this theme as a starting point for your project.
Keep in mind that you need pressmind®, so you do not build or integrate complex booking technology.

In most cases this is the basic setup for each travelshop:
* pressmind® Professional (PIM-System for tour-operators)
* pressmind® IB3 (seamless booking engine, with connectors to a lot of german tour-operator Systems like BusPro, Blank, DaVinci, TouPac, turista 2/3, STADIS)
* pressmind® web-core SDK or this theme

This setup has most effort, if you like to design and build a nice travelshop. The pressmind® applications will reduce your complexity

#### Quick Install
* Download the [latest theme Build](https://github.com/pressmind/wp-travelshop-theme/releases/latest)
* Extract the zip or tarball file to your WordPress theme directory
*  After extracting the zip file your themes folder should look something like this:
    * themes
        * some_other_theme/
        * travelshop/
            * assets/
            * cli/
            * Custom/
            * functions/
            * src/
            * template-parts
            * ...
* create a database and a database user
* on a console move to the themes folder (cd /var/www/vhosts/my-project/wp-content/themes/travelshop)
* run "composer install inside the themes directory (wp-content/themes/travelshop)"
* run "php install.php " in travelshop/cli/ and enter the requested credentials
* activate the theme
* run "php import.php fullimport " in travelshop/cli/
* after a few minutes your travelshop is running

#### More Information:
* [Installation via Composer](./travelshop/installation.md)
* [Common Theme Documentation](./travelshop/readme-theme.md)
* [QueryString API](./travelshop/readme-querystring-api.md)

