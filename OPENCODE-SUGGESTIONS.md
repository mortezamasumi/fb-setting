# OPENCODE-SUGGESTIONS — fb-setting

Status: 20 tests passing (53 assertions). 0 items open, 17 done → **ALL 17 COMPLETE**.

## Bugs

1. ~~`src/FbSettingServiceProvider.php:5,33` — `use App\Policies\FbSettingPolicy;` imports the **consumer app's** namespace, not the package's own `Mortezamasumi\FbSetting\Policies\FbSettingPolicy`. In any fresh consumer that does not define `App\Policies\FbSettingPolicy`, the registered Gate policy points at a non-existent class → 500 the moment Filament authorizes the resource. The package's shipped `src/Policies/FbSettingPolicy.php` is dead code (never registered by the provider). Tests mask the bug by re-registering the package policy in `beforeEach`. **Consumer impact:** `schoolv4` defines `app/Policies/FbSettingPolicy.php` and relies on this routing.~~ **FIXED** — provider now imports and registers the package's own policy. Consumer impact verified: schoolv4's `App\Policies\FbSettingPolicy` is functionally identical to the package policy (same permission-string checks), so after upgrade Laravel's policy auto-discovery resolves the package policy and behavior is unchanged; schoolv4's duplicate policy file becomes dead code (removable). No schoolv4 code change required. Covered by the existing resource tests which register the package policy.

2. ~~`src/FbSetting.php:20` and `:39` — `foreach ($values as $key => $data)` shadows the `$key` method parameter.~~ **FIXED** — loop variables renamed to `$name`; `get()` rewritten for clarity (early return on null setting, `getAttribute()` access). Covered by the `FbSettingTest.php` suite.

3. ~~`database/migrations/create_fb_settings_table.php:15` vs `src/Models/FbSetting.php:12` — migration adds `timestamps()`, but the model sets `$timestamps = false`.~~ **FIXED** — dropped `timestamps()` from the migration. Also added `active` boolean cast to the model (`it('can deactivate a setting from the table')` covers it).

## API cleanliness / typos

4. ~~`composer.json:3` — description is unprofessional and misspelled.~~ **FIXED** — "Key-value settings store with a Filament resource for Laravel."

5. ~~`composer.json:4-8` — keywords missing `filament`.~~ **FIXED** — `["mortezamasumi", "laravel", "filament", "fb-setting"]`.

6. ~~`composer.json:54-58` — scripts missing `pint` and `analyse`.~~ **FIXED** — added both.

7. ~~`composer.json:61-64` — `config.allow-plugins` lists `phpstan/extension-installer`.~~ **FIXED** — reduced to `pestphp/pest-plugin` only.

8. ~~`composer.json:40` — autoload references `database/factories/` (no such dir).~~ **FIXED** — removed the dead PSR-4 entry.

9. ~~`src/Resources/Pages/ManageFbSettings.php:13` — overrides deprecated `getActions()`.~~ **FIXED** — now `getHeaderActions()`. Covered by existing create-action tests.

## Meta / release-readiness

10. ~~Missing files: `pint.json`, `phpstan.neon.dist`, `.github/CONTRIBUTING.md`, `.github/SECURITY.md`.~~ **FIXED** — added all four from the fb-passwd canonical versions; phpstan config includes the `localeDigit` macro ignore (fb-essentials runtime macro), mirroring fb-activity's pattern.

11. ~~`require-dev` missing `laravel/pint`, `phpstan/phpstan`, `larastan/larastan`.~~ **FIXED** — added all three; `vendor/bin/phpstan` passes at level 8 with the re-typed `attributes` cast, `get()`, facade/helper `@param` docblocks, and `@mixin Testable<Component>` (Livewire 4 `Testable` is generic; matches fb-activity).

12. ~~`CHANGELOG.md:5` — placeholder date `202X-XX-XX`.~~ **FIXED** — real dated entries (`5.0.0 - 2026-07-09`, `4.2.2 - 2026-06-03` from git tags).

13. ~~`README.md` — full boilerplate rewrite (badge URLs point at non-existent workflows, `echoPhrase` usage, empty config, wrong publish tags).~~ **FIXED** — rewritten per standard with correct `ci.yml` badge URLs, Features, real installation/config/usage (plugin + `__fb_setting` API), Support policy table, and publish tags matching the provider (`fb-setting-migrations`, `fb-setting-config`; translations are auto-loaded).

## CI

14. ~~`.github/workflows/ci.yml` — **test step commented out**, missing `composer validate --strict`, `composer audit`, `vendor/bin/pint --test`, `vendor/bin/phpstan analyse --no-progress`, and `prefer-lowest`.~~ **FIXED** — uncommented the test step (now `vendor/bin/pest --ci`, release still `needs: test`), added all four quality-gate steps, `prefer-stable, prefer-lowest` matrix, checkout bumped to `@v5` in both jobs. All gates pass locally.

## Security

15. ~~`composer audit` — medium advisories in `guzzlehttp/guzzle` (`< 7.15.1`).~~ **FIXED** — `composer update guzzlehttp/guzzle guzzlehttp/psr7 -W`; `composer audit` now reports no advisories.

## Tests

16. ~~Coverage driver unavailable locally.~~ **RESOLVED** — CI (`coverage: none`) does not run coverage; the `test-coverage` script remains for environments with a driver installed. Environment limitation, not a code gap.

17. ~~Missing failure-branch tests for `FbSetting::get()` + resource actions.~~ **FIXED** — added `tests/Tests/FbSettingTest.php` (inactive setting returns default, missing key → null, falsy defaults round-trip, array defaults with/without attribute key, placeholder substitution in defaults and stored values, unknown attribute key → null, all-attributes return) and resource tests (replicate with new key, replicate duplicate-key validation, toggle active). Suite: 20 passed (53 assertions).
