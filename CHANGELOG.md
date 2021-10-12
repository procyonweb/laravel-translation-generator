# Changelog

All notable changes to `laravel-translation-generator` will be documented in this file

## [4.0.0] - 2021-10-12
### Changed
- Prepare package to handle different sources

## [3.0.0] - 2020-03-23
### Changed
- [BC] Switch to Phrase.com translation service (see new config file)
- Downloading fresh files before generating new keys

## [2.1.2] - 2020-01-20
### Changed
- Added new config to override download options. See [documentation](https://lokalise.com/api2docs/curl/#transition-download-files-post).
- Remove file after unzip

## [2.1.1] - 2020-01-20
### Changed
- Fixed Download command

## [2.1.0] - 2020-01-20
### Added
- Added Lokalise API to upload and download translations.

## [2.0.0] - 2020-01-17
### Added
- Changelog, new license and contribution files
### Changed
- [BC] Changed file search from `glob` to `RecursiveDirectoryIterator`. Please update the config appropriately.