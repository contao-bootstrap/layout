Contao-Bootstrap Layout
=====================

[![Version](http://img.shields.io/packagist/v/contao-bootstrap/layout.svg?style=for-the-badge&label=Latest)](http://packagist.org/packages/contao-bootstrap/layout)
[![GitHub issues](https://img.shields.io/github/issues/contao-bootstrap/layout.svg?style=for-the-badge&logo=github)](https://github.com/contao-bootstrap/layout/issues)
[![License](http://img.shields.io/packagist/l/contao-bootstrap/layout.svg?style=for-the-badge&label=License)](http://packagist.org/packages/contao-bootstrap/layout)
[![Build Status](https://img.shields.io/github/workflow/status/contao-bootstrap/layout/contao-bootstrap-layout/master?style=for-the-badge)](https://github.com/contao-bootstrap/layout/actions/workflows/diagnostics.yml)
[![Downloads](http://img.shields.io/packagist/dt/contao-bootstrap/layout.svg?style=for-the-badge&label=Downloads)](http://packagist.org/packages/contao-bootstrap/layout)

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

- PHP ^8.1
- Contao ^4.13 || ^5.3



Install
-------

### Managed edition

When using the managed edition it's pretty simple to install the package. Just search for the package in the
Contao Manager and install it. Alternatively you can use the CLI.

```bash
# Using the contao manager
$ php contao-manager.phar.php composer require contao-bootstrap/layout ^3.0

# Using composer directly
$ php composer.phar require contao-bootstrap/layout ^3.0
```

### Symfony application

If you use Contao in a symfony application without contao/manager-bundle, you have to register following bundles
manually:

```php

class AppKernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new \ContaoCommunityAlliance\MetaPalettes\CcaMetaPalettesBundle(),
            new \Netzmacht\Contao\Toolkit\Bundle\NetzmachtContaoToolkitBundle(),
            new \ContaoBootstrap\Core\ContaoBootstrapCoreBundle(),
            new \ContaoBootstrap\Layout\ContaoBootstrapLayoutBundle(),
        ];
    }
}

```
