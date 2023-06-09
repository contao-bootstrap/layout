
Changelog
=========

Unreleased
----------

3.0.0 (2023-06-09)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.1.2...3.0.0)

### Added

 - Add `block_section_container_fluid` template

### Changed

 - Use bootstrap 5 classes for replace classes feature

### Breaking

 - Remove `block_sction_jumbotron*` templates
 - Remove `fe_bootstrap_no_schema` template


2.1.2 (2022-11-21)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.1.1...2.1.2)

### Fixed

 - Prevent possible PHP 8 warning


2.1.1 (2022-04-21)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.1.0...2.1.1)

### Fixed

 - Fix version constraint of dependency ([#20](https://github.com/contao-bootstrap/layout/pull/20))


2.1.0 (2022-04-20)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.4...2.1.0)

### Added

 - Add support for `icons.css` of the Contao css framework

### Changed

 - Bump minimum PHP version to 7.4
 - Bump Symfony requirements to ^4.4 or ^5.4
 - Bump Contao requirements to ^4.9 or ^4.13
 - Changed coding standard

2.0.4 (2019-11-15)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.3...2.0.4)

### Fixed

 - Add img css class to picture image instead of to attributes ([#15](https://github.com/contao-bootstrap/layout/issues/15))
 - Do not add html5 shiv for Contao >= 4.8 ([#13](https://github.com/contao-bootstrap/layout/issues/13))

2.0.3 (2018-09-06)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.2...2.0.3)

 - Update translations
 - Fix incompatibility with Contao 4.4

2.0.2 (2018-08-27)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.1...2.0.2)

 - Do not require that bootstrap environment is public.


2.0.1 (2018-07-24)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.0...2.0.1)

 - Update translations


2.0.0 (2018-01-05)
------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.0-beta4...2.0.0)

 - Fix floating classes (#7)


2.0.0-beta4 (2017-12-01)
------------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.0-beta3...2.0.0-beta4)

Implemented enhancements:

 - Rewrite `rounded` and `rounded-*` classes to the picture element.
 - Mark dca/hook listeners as public


2.0.0-beta3 (2017-09-29)
------------------------

[Full Changelog](https://github.com/contao-bootstrap/layout/compare/2.0.0-beta2...2.0.0-beta3)

Implemented enhancements:

 - Add table and image class replacements.
 - Rewrite css classes modifier to a filter.
 - Update readme and add changelog.
