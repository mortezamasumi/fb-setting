<?php

namespace Mortezamasumi\FbSetting\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FbSetting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'attributes',
        'active',
    ];

    protected function attributes(): Attribute
    {
        return Attribute::make(
            set: function (?array $value) {
                return json_encode(collect($value)->mapWithKeys(fn ($item) => [$item['key'] => $item['value']])->toArray());
            },
            get: function (?string $value) {
                return collect(json_decode($value))->map(fn ($item, $key) => ['key' => $key, 'value' => $item])->toArray();
            },
        );
    }
}
