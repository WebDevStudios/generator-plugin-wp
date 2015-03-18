# generator-plugin-wp [![Build Status](https://secure.travis-ci.org/WebDevStudios/generator-plugin-wp.png?branch=master)](https://travis-ci.org/WebDevStudios/generator-plugin-wp)

> [Yeoman](http://yeoman.io) generator for WordPress plugins.


## Getting Started

```bash
npm install -g yo
```

To install generator-plugin-wp from npm, run:

```bash
npm install -g generator-plugin-wp
```

Finally, initiate the generator:

```bash
yo plugin-wp
```

## Adding Packages with Composer

After generating your plugin, CD into it's directory.

```bash
cd plugins/wds-foo-plugin
```

Now, let's add [CMB2](https://github.com/WebDevStudios/CMB2):

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
