# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

Log of unreleased changes.

## v0.1.0

Released on 2017/09/19

### Added

- Implemented Riccio config entity to define Riccio's options.
- Defined Riccio library in `riccio.libraries.yml` file.
- Added `riccio.install` file.
- Added `riccio-requirements()` function, it checks if Riccio's library exists
and calculates Riccio's version if `package.json` is found. Then prints infos
in the *Status report* page.
- Added `getOptions()` function. It returns the options as saved in database.
- Added `riccioInit.js` file. It searches for `[data-riccio-options]` in HTML
and creates a new Riccio instance using the given options.
- Added `EntityReferenceRiccioFormatter` field formatter with relative
`field.formatter.settings.entity_reference_riccio` schema.
- Added `riccio_theme()`, `template_preprocess_riccio()` and `riccio.html.twig`.

### Removed

- Removed `per_row_from_css` and `media_queries_from_css` forms. If `per_row`
and `media_queries` are blank, then calculates values from CSS.
