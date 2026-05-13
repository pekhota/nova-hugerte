# Changelog

All notable changes to **Nova HugeRTE** will be documented in this file.  
The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the project adheres to [Semantic Versioning](https://semver.org).

---

## [1.2.1] – 2026-05-13

### Changed

- Moved `laravel/nova` from `require-dev` to `require` so novapackages.com correctly detects Nova 5 compatibility.
- Removed `illuminate/support` from `require` — it is already a transitive dependency of Nova.
- Removed redundant `suggest` block for `laravel/nova` now that it is a direct dependency.
- Added `composer.lock` to `.gitignore` and removed it from version control — lock files should not be committed in library packages.

---

## [1.2.0] – 2026-04-02

### Changed

- Added Laravel 13 support (updated `illuminate/support` constraint to include `^13.0`).

---

## [1.1.0] – 2025-10-07

### Added

- Lazy load option: the HugeRTE editor can now be deferred until the field is visible, reducing initial page load cost.
- `lazyLoad` config key in `config/nova-hugerte.php` to enable lazy loading globally.

---

## [1.0.0] – 2025-06-17

### Added

- Initial public release of Nova HugeRTE.
- `HugeRTE` Nova field wrapping the HugeRTE (TinyMCE-compatible) editor with dark-mode support, autosave, word-count, and media embeds.
- Config-driven skin, plugins, and toolbar via `config/nova-hugerte.php`.
- `Expandable` and `Dependent` field traits for Nova resources.
- Pre-built `dist/` assets — no separate build step required when installing.
- GitHub Actions CI pipeline for PHP linting and testing.
