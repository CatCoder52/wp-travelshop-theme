# WordPress travelshop theme
This is a responsive travelshop theme for WordPress.
The frontend is based on pure bootstrap components and a few common web libraries.
The backend is based on the pressmind® PIM system and the [pressmind® SDK](https://github.com/pressmind/sdk).
This theme is the perfect starting point in order to build professional travelshops.

![Device Overview](./docs/assets/mockup.jpg)

#### Demo page
[https://development-travelshop-theme-de.pressmind.dev/](https://development-travelshop-theme-de.pressmind.dev/)

#### Screenshot
![Overview Image Demo-Page](./docs/assets/overview.jpg)

## Overview
* [Lighthouse Performance](#lighthouse-performance)
* [Mobile experience](#mobile-experience)
* [Progressive Web App](#progressive-web-app)
* [Additional information (What is it, what not?)](#additional-information)
* [Features](#features)
* [Device compatibility](#device-compatibility)
* [Browser compatibility](#browser)
* [Plugin compatibility (tested)](#plugin-compatibility-tested)
* [System overview](#system-overview)
* [Developer informations](#developer-informations)

### Lighthouse Performance
Current lighthouse performance at revision 3de848c (10.05.2021)
(tested on demo page, without redis caching). 

![Lighthouse](./docs/assets/lighthouse.jpg)

### Mobile experience

![Lighthouse](./docs/assets/mobile.jpg)

### Progressive Web App  
Basic PWA support is enabled. Page can be used as PWA in online mode. 
The service worker provides a offline page if no network is available. 
Use workbox if you plan a offline mode or a advanced local caching strategy.

### Additional information
#### What is it not?
* A full featured, plug & play travelshop.
* It is not a booking engine, but you can integrate your own booking engine or you can use the pressmind® IB3 booking engine.

#### What is it?
* A good starting point for developing a WordPress based travelshop based on the pressmind® PIM.
* The travelshop matches the german tour operator market.

#### For developers
If you are planning a travelshop for german (DACH) tour operators, it is possible to use this theme as a starting point for your project.
Keep in mind that you need pressmind®, so you do not build or integrate complex booking technology.

In most cases, this is the basic setup for each travelshop:
* pressmind® Professional (PIM-System for tour operators) see [pressmind.de](https://www.pressmind.de)
* pressmind® IB3 (seamless booking engine, with connectors to a lot of german tour operator systems like BusPro, Blank, DaVinci, TouPac, turista 2/3, STADIS)
* [pressmind® SDK](https://github.com/pressmind/sdk) or this theme
* for custom ux design take also a look at [Google UX Playbook for travel](https://services.google.com/fh/files/events/pdf_travel_ux_playbook.pdf)

### Features
* Display different tourism based products (packages, hotels, round trips, day trips, etc.)
* List products in a defined order
* Search products by defined attributes
* Search by travel date
* Search by duration range
* Search by price range
* Search by text (with auto-complete suggestions)
* Display cheapest available price
* Display bookable content, delivered by tour operator systems
* Fav-List feature
* Link to an external IBE like pressmind IB3
* Image handling: Thumbnailer, optimization
* Amazon S3 support
* Travelblog
* ... and many more

### Device compatibility
- iPhone 5 - iPhone X, portrait/landscape
- iPad (Pro), portrait/landscape

### Browser
* IE > 11
* Edge (current)
* Chrome (current)
* Firefox (current)

### Plugin compatibility (tested)
* Revolution Slider
* Elementor
* BeaverBuilder (several beaverbuilder modules are included), see [here](./docs/readme-beaverbuilder.md)
* Contact Form 7 (several features and examples added, see [here](./docs/readme-forms.md))
* ... all other (but make a deep test before use in production)

### System overview

![system overview](./docs/assets/pressmind_travelshop.png)


### Developer informations:

#### Installation
* [System requirements](./docs/readme-system-requirements.md)
* [Step by step guide for installation & customization](./docs/readme-step-by-step-guide.md) (!recommend for onboarding)
* [Installation Documentation](./docs/readme-installation.md)
* [PHPStorm Setup](./docs/readme-phpstorm.md)
* [Track changes in your own project/github repo](./docs/readme-track-changes-in-new-projects.md)
  
### Main developing topics
* [Common Theme Documentation](./docs/readme-theme.md)
* [Shortcodes](./docs/readme-shortcodes.md)
* !MUST KNOW:  [QueryString API](./docs/readme-querystring-api.md)
* [Multilanguage Support](./docs/readme-multilanguage.md)
* [Build in pressmind® IB3 template](./docs/readme-ibe-template.md)
* [Using the blog feature](./docs/readme-blog.md)
* [BeaverBuilder support](./docs/readme-beaverbuilder.md)
* [Modal screens and windows support](./docs/readme-modals.md)
* [Contact Form 7 support](./docs/readme-forms.md)
* Take a look at the [pressmind web-core project](https://github.com/pressmind/web-core-skeleton-basic/#quickstart),
  most of the pressmind sdk implementation in this theme is based on those examples.
* [Maintenance & troubleshooting](./docs/readme-maintenance.md)

#### Quick dev question:<br> How to generate product lists (based on pressmind® PIM)? 
It is possible to output product listings on four different ways:

* list by the media object list route using ($_GET)
* list by [shortcodes](./docs/readme-shortcodes.md)
* list programmatically with the pressmind SDK framework, take a look here: [QueryString API](./docs/readme-querystring-api.md)
* list with a beaverbuilder module (if enabled) (see [beaverbuilder integration](./docs/readme-beaverbuilder.md))

