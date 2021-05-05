# PWA Support

The travelshop theme has basic PWA support, intended as boilerplate for further developments.

## Features
* PWA installation
* Offline caching

## Configuration

```
manifest-pwa.php
```
This file is the main bootstrap for the pwa initialization.
Edit this file to setup colors, icons and so on.

```
wp-travelshop-theme/travelshop/assets/js/service-worker.js
```
This file is a basic service-worker which contains a basic offline caching method.
Registration is done in file travelshop/assets/js/ui.js.
