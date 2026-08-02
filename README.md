# FB Setting — Key-Value Settings for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mortezamasumi/fb-setting.svg?style=flat-square)](https://packagist.org/packages/mortezamasumi/fb-setting)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mortezamasumi/fb-setting/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/mortezamasumi/fb-setting/actions?query=branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mortezamasumi/fb-setting.svg?style=flat-square)](https://packagist.org/packages/mortezamasumi/fb-setting)
[![License](https://img.shields.io/packagist/l/mortezamasumi/fb-setting.svg?style=flat-square)](LICENSE.md)

A key-value settings store for Laravel backed by a single `fb_settings` table, with a Filament resource to manage entries from the panel. Read settings anywhere with a tiny helper, support nested attributes and placeholder substitution, and control which keys are active.

---

## Features

- **Simple key-value API** — `__fb_setting('key', $default)` returns the active value, or your default
- **Nested attributes** — a setting can hold multiple named attributes accessed by key
- **Placeholder substitution** — replace `:name` tokens with runtime values in defaults and stored values
- **Filament resource** — manage settings from the panel (create, edit, replicate, delete, toggle active)
- **Localized** — ships English and Persian translations

---

## Installation

```bash
composer require mortezamasumi/fb-setting
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="fb-setting-migrations"
php artisan migrate
```

Add the plugin to your Filament panel provider:

```php
use Mortezamasumi\FbSetting\FbSettingPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FbSettingPlugin::make(),
        ]);
}
```

---

## Configuration

Publish the config file with:

```bash
php artisan vendor:publish --tag="fb-setting-config"
```

The published `config/fb-setting.php` lets you tune the navigation entry (label, icon, badge, sort order). By default the resource appears under the **System** group with a `heroicon-o-cog` icon.

Translations ship in the `fb-setting` namespace (`resources/lang/en`, `resources/lang/fa`) and are loaded automatically.

---

## Usage

Read a setting with the global helper (or the `FbSetting` facade):

```php
// Simple value, falling back to a default when missing or inactive:
$schoolName = __fb_setting('school_name', 'My School');

// Nested attributes:
$phone = __fb_setting('contact', null, 'phone');

// Placeholder substitution:
$message = __fb_setting('sms_template', 'Hello :name', values: ['name' => $user->name]);
```

Settings are managed from the Filament panel: create a key with a plain `value` or with a list of `attributes`, and toggle `active` to enable or disable it.

---

## Support policy

| PHP | Laravel |
| --- | --- |
| 8.3 | 12 |

---

## Testing

```bash
composer test
```

The test suite covers the lookup API (defaults, attributes, placeholders, inactive keys) and the resource flows (create, edit, replicate, validation, toggle) using an in-memory SQLite database.

---

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover a security vulnerability, please review our [security policy](.github/SECURITY.md) on how to report it.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

---

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md) for details.
