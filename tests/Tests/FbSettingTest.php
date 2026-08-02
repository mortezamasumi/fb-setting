<?php

use Mortezamasumi\FbSetting\Facades\FbSetting;
use Mortezamasumi\FbSetting\Models\FbSetting as ModelsFbSetting;

it('returns the default when the setting is inactive', function () {
    ModelsFbSetting::create([
        'key' => 'maintenance',
        'value' => 'running',
        'active' => false,
    ]);

    expect(FbSetting::get('maintenance', 'offline'))->toBe('offline');
});

it('returns null for a missing key without a default', function () {
    expect(FbSetting::get('not-defined'))->toBeNull();
});

it('returns a falsy default unchanged', function () {
    expect(FbSetting::get('not-defined', 0))->toBe(0);
    expect(FbSetting::get('not-defined', ''))->toBe('');
});

it('returns the whole array default when no attribute key is given', function () {
    $default = ['site_name' => 'My School'];

    expect(FbSetting::get('not-defined', $default))->toBe($default);
});

it('returns the matching value from an array default', function () {
    $default = ['site_name' => 'My School'];

    expect(FbSetting::get('not-defined', $default, 'site_name'))->toBe('My School');
    expect(FbSetting::get('not-defined', $default, 'unknown'))->toBeNull();
});

it('replaces placeholders in the default with the given values', function () {
    expect(FbSetting::get('greeting', 'Hello :name!', values: ['name' => 'Ali']))
        ->toBe('Hello Ali!');
});

it('replaces placeholders in the stored value', function () {
    ModelsFbSetting::create([
        'key' => 'sms-text',
        'value' => 'Hello :name, welcome!',
    ]);

    expect(FbSetting::get('sms-text', values: ['name' => 'Ali']))->toBe('Hello Ali, welcome!');
});

it('returns null when the requested attribute key does not exist', function () {
    ModelsFbSetting::create([
        'key' => 'contact',
        'attributes' => [
            ['key' => 'phone', 'value' => '09120000000'],
        ],
    ]);

    expect(FbSetting::get('contact', null, 'email'))->toBeNull();
});

it('returns all attributes when no attribute key is given', function () {
    ModelsFbSetting::create([
        'key' => 'contact',
        'attributes' => [
            ['key' => 'phone', 'value' => '09120000000'],
        ],
    ]);

    expect(FbSetting::get('contact'))->toBe([
        'phone' => ['key' => 'phone', 'value' => '09120000000'],
    ]);
});
