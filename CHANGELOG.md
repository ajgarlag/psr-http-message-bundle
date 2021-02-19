# [CHANGELOG](http://keepachangelog.com/)
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.2.0...main)

## [1.2.0](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.1.2...1.2.0) - 2021-02-19

### Added
- Add compiler pass classes to register required services
- Add compiler pass classes to conditionally tag argument value resolver and view event listener

### Changed
- Define `Http(Foundation|Message)FactoryInterface` services if they are not provided by other package
- Define lower priority for argument value resolver and view event listener

### Deprecated
- Deprecate all `ajgarlag_psr_http_message.psr7...` services identifiers

## [1.1.2](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.1.1...1.1.2) - 2021-02-18

### Fixed
- Use correct namespace to detect SensioFrameworkExtraBundle version

## [1.1.1](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.1.0...1.1.1) - 2021-02-17

### Fixed
- Add package and version to deprecated services definitions

## [1.1.0](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.0.1...1.1.0) - 2021-02-04

### Changed
- Relax version requirement for [`symfony/psr-http-message-bridge`](https://github.com/symfony/psr-http-message-bridge)
- Do not conflict with [`sensio/framework-extra-bundle`](https://github.com/symfony/psr-http-message-bridge):>=5.3

### Deprecated
- Depending on old `sensio_framework_extra_...` services identifiers.

## [1.0.1](https://github.com/ajgarlag/psr-http-message-bundle/compare/1.0.0...1.0.1) - 2021-02-04

### Fixed
- Typo in conflict with [`sensio/framework-extra-bundle`](https://github.com/sensiolabs/SensioFrameworkExtraBundle)

## [1.0.0](https://github.com/ajgarlag/psr-http-message-bundle/releases/tag/1.0.0) - 2021-02-03

**Initial release**
