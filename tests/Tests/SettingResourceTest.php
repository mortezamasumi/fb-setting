<?php

use Illuminate\Support\Facades\Gate;
use Mortezamasumi\FbSetting\Facades\FbSetting;
use Mortezamasumi\FbSetting\Models\FbSetting as ModelsFbSetting;
use Mortezamasumi\FbSetting\Policies\FbSettingPolicy;
use Mortezamasumi\FbSetting\Resources\FbSettingResource;
use Mortezamasumi\FbSetting\Resources\Pages\ManageFbSettings;
use Mortezamasumi\FbSetting\Tests\Services\User;

beforeEach(function () {
    Gate::before(fn () => true);
    Gate::policy(ModelsFbSetting::class, FbSettingPolicy::class);

    /** @var Pest $this */
    $this->actingAs(User::factory()->create());
});

it('can render index page', function () {
    /** @var Pest $this */
    $this
        ->get(FbSettingResource::getUrl('index'))
        ->assertSuccessful();
});

it('can show empty table', function () {
    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->assertCanSeeTableRecords([])
        ->assertCountTableRecords(0);
});

it('can show data in table', function () {
    ModelsFbSetting::create([
        'key' => 'test-key',
        'value' => 'test value',
        'attributes' => [[
            'key' => 'attribute-key',
            'value' => 'attribute value',
        ]],
    ]);

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->assertCountTableRecords(1);
});

it('can create key-value setting', function () {
    $data = [
        'key' => 'test-key',
        'value' => 'test value',
    ];

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountAction('create')
        ->setActionData($data)
        ->callMountedAction()
        ->assertHasNoActionErrors();

    $this->assertDatabaseHas(ModelsFbSetting::class, $data);

    expect(FbSetting::get('test-key'))->toBe('test value');
});

it('can create key-attribute setting using facade', function () {
    $data = [
        'key' => 'test-key',
        'attributes' => [
            [
                'key' => 'attribute-key',
                'value' => 'attribute value',
            ],
            [
                'key' => 'attribute-key1',
                'value' => 'attribute value1',
            ],
        ],
    ];

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountAction('create')
        ->setActionData($data)
        ->callMountedAction()
        ->assertHasNoActionErrors();

    expect(FbSetting::get('test-key', null, 'attribute-key'))->toBe('attribute value');

    expect(FbSetting::get('test-key', null, 'attribute-key1'))->toBe('attribute value1');
});

it('can get validation error', function () {
    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountAction('create')
        ->setActionData([])
        ->callMountedAction()
        ->assertHasActionErrors([
            'key' => ['required'],
            'value',
            'attributes',
        ]);
});

it('can edit setting', function () {
    $record = ModelsFbSetting::create([
        'key' => 'test-key',
        'value' => 'test value',
    ]);

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountTableAction('edit', $record)
        ->assertActionDataSet($record->toArray())
        ->setActionData([
            'value' => 'another test value',
        ])
        ->callMountedAction()
        ->assertHasNoActionErrors();

    expect(FbSetting::get('test-key'))->toBe('another test value');
});

it('can replicate a setting with a new key', function () {
    $record = ModelsFbSetting::create([
        'key' => 'source-key',
        'value' => 'test value',
    ]);

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountTableAction('replicate', $record)
        ->setActionData([
            'key' => 'replicated-key',
        ])
        ->callMountedAction()
        ->assertHasNoActionErrors();

    expect(FbSetting::get('replicated-key'))->toBe('test value');
});

it('cannot replicate a setting with a duplicate key', function () {
    ModelsFbSetting::create([
        'key' => 'existing-key',
        'value' => 'existing value',
    ]);

    $record = ModelsFbSetting::create([
        'key' => 'source-key',
        'value' => 'test value',
    ]);

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->mountTableAction('replicate', $record)
        ->setActionData([
            'key' => 'existing-key',
        ])
        ->callMountedAction()
        ->assertHasTableActionErrors([
            'key' => ['unique'],
        ]);
});

it('can deactivate a setting from the table', function () {
    $record = ModelsFbSetting::create([
        'key' => 'test-key',
        'value' => 'test value',
        'active' => true,
    ]);

    /** @var Pest $this */
    $this
        ->livewire(ManageFbSettings::class)
        ->call('updateTableColumnState', 'active', $record->getKey(), false);

    expect($record->refresh()->active)->toBeFalse();
});
