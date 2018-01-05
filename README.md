Contao-Bootstrap Layout
=====================

[![Build Status](http://img.shields.io/travis/contao-bootstrap/layout/master.svg?style=flat-square)](https://travis-ci.org/contao-bootstrap/layout)
[![Version](http://img.shields.io/packagist/v/contao-bootstrap/layout.svg?style=flat-square)](http://packagist.com/packages/contao-bootstrap/layout)
[![License](http://img.shields.io/packagist/l/contao-bootstrap/layout.svg?style=flat-square)](http://packagist.com/packages/contao-bootstrap/layout)
[![Downloads](http://img.shields.io/packagist/dt/contao-bootstrap/layout.svg?style=flat-square)](http://packagist.com/packages/contao-bootstrap/layout)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

This extension provides Bootstrap integration into Contao. 

Contao-Bootstrap is a modular integration. The layout component allows to define a grid based layout using the 
backend layout editor.

Features
--------

 - Grid based layouts 
 - Auto replace defined css classes 
 - Auto replace image and table classes
 
Changelog
---------

See [changelog](CHANGELOG.md)
 
Requirements
------------

 - PHP 7.1
 - Contao ~4.4
 
 
Install
-------

### Managed edition

When using the managed edition it's pretty simple to install the package. Just search for the package in the
Contao Manager and install it. Alternatively you can use the CLI.  

```bash
# Using the contao manager
$ php contao-manager.phar.php composer require contao-bootstrap/layout~2.0@beta

# Using composer directly
$ php composer.phar require contao-bootstrap/layout~2.0@beta
```

### Standard edition

Without the contao manager you also have to register the bundle

```php

class AppKernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle('metapalettes', $this->getRootDir()),
            new ContaoBootstrap\Core\ContaoBootstrapCoreBundle(),
            new Netzmacht\Html\NetzmachtHtmlBundle(),
            new ContaoBootstrap\Layout\ContaoBootstrapLayoutBundle(),
        ];
    }
}

```
