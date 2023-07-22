# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Releases

### [0.1.12] - 2023-07-22

* README.md updates

### [0.1.11] - 2023-07-22

* Refactoring
* README.md updates

### [0.1.10] - 2023-07-21

* Add autoload directory within vendor

### [0.1.9] - 2023-07-20

* Add command line interpreter
* Fix recursive issue with output timezone
* Update README.md

### [0.1.8] - 2023-07-18

* Update README.md
* Add more DateRange tests

### [0.1.7] - 2023-07-17

* Add hour, minute and second parser
* Add this, next, last parser for hour, minute and second

### [0.1.6] - 2023-07-16

* Add timezone support

### [0.1.5] - 2023-07-09

* Add more parser options like next-year, last-year, etc.

### [0.1.4] - 2023-07-08

* Add more parser options like next-month, this-month, last-month, this-year, etc.
* README.md updates

### [0.1.3] - 2023-07-08

* Add more parser options like tomorrow, etc.
* README.md updates
* Refactoring

### [0.1.2] - 2023-07-08

* Add "yesterday" to "today" to README.md and tests.

### [0.1.1] - 2023-07-08

* README.md changes


### [0.1.0] - 2023-07-07

* Initial release with the first implementation
* Add src
* Add tests
  * PHP Coding Standards Fixer
  * PHPMND - PHP Magic Number Detector
  * PHPStan - PHP Static Analysis Tool
  * PHPUnit - The PHP Testing Framework
  * Rector - Instant Upgrades and Automated Refactoring
* Add README.md
* Add LICENSE.md

## Add new version

```bash
# Checkout master branch
$ git checkout main && git pull

# Check current version
$ vendor/bin/version-manager --current

# Increase patch version
$ vendor/bin/version-manager --patch

# Change changelog
$ vi CHANGELOG.md

# Push new version
$ git add CHANGELOG.md VERSION && git commit -m "Add version $(cat VERSION)" && git push

# Tag and push new version
$ git tag -a "$(cat VERSION)" -m "Version $(cat VERSION)" && git push origin "$(cat VERSION)"
```
