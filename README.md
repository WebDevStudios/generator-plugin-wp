# generator-plugin-wp [![Build Status](https://secure.travis-ci.org/WebDevStudios/generator-plugin-wp.png?branch=master)](https://travis-ci.org/WebDevStudios/generator-plugin-wp)

> [Yeoman](http://yeoman.io) generator for WordPress plugins.


## Getting Started

Pre-requisites: You'll need [node](https://nodejs.org/download/) which comes with [npm](https://github.com/npm/npm#super-easy-install).

If you don't have [Yeoman](http://yeoman.io/) installed:

```bash
npm install -g yo
```

To install generator-plugin-wp from npm, run:

```bash
npm install -g generator-plugin-wp
```

To use generator-plugin-wp, `cd` to your WordPress plugins folder and:

```bash
yo plugin-wp
```
You'll be prompted with steps for creating your plugin.

## Additional Commands

Once your nifty new plugin has been generated, `cd` into your new plugin's directory. While in the plugin directory, you can run additional commands to automatically generate files.

To create a blank `frontend.php` class:

```bash
yo plugin-wp:include Frontend
```

To add a Javascript boilerplate (with optional browserify or concatenation support)

```bash
yo plugin-wp:js
```

To add a CSS boilerplate (with optional SASS support)

```bash
yo plugin-wp:css
```

### Adding Packages with Composer

If you chose composer as the autoloder option during the plugin's initiation, you can use composer to add additional dependencies.

Let's `cd` into our new plugin's directory and add [CMB2](https://github.com/WebDevStudios/CMB2):

```bash
composer require webdevstudios/cmb2
```

CMB2 will now appear under `vendor`

```bash
-plugins
  -wds-foo-plugin
    -vendor
      -webdevstudios
        -cmb2
```
See the complete list of WebDevStudios packages: https://packagist.org/packages/webdevstudios/
