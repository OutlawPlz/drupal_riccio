# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

Log of unreleased changes.

### Added

- Implemented Riccio config entity to define Riccio's options.
- Defined Riccio library in `riccio.libraries.yml` file.
- Added `riccio.install` file.
- Added `riccio-requirements()` function, it checks if Riccio's library exists
and calculates Riccio's version if `package.json` is found. Then prints infos
in the *Status report* page.
