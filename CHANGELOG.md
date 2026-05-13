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

## [0.1.0] – 2025-06-16
### Added
- Initial public release of Nova HugeRTE.
    - Laravel Nova field wrapping HugeRTE (TinyMCE-compatible) with dark-mode support, autosave, word-count and media embeds.
    - Config-driven skin, plugins and toolbar.
    - Includes Expandable and Dependent field traits for Nova resources.

---

*This is the first version; earlier history does not exist.*
