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

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * @return Attribute<array<int|string, array{key: int|string, value: mixed}>, ?array<int, array{key: string, value: string}>>
     */
    protected function attributes(): Attribute
    {
        return Attribute::make(
            set: function (?array $value): string {
                $map = [];

                foreach ($value ?? [] as $item) {
                    if (is_array($item) && isset($item['key'])) {
                        $map[$item['key']] = $item['value'] ?? null;
                    }
                }

                return (string) json_encode($map);
            },
            get: function (?string $value): array {
                $decoded = json_decode($value ?? '', true);

                if (! is_array($decoded)) {
                    return [];
                }

                return collect($decoded)
                    ->map(fn (mixed $item, int|string $key): array => ['key' => $key, 'value' => $item])
                    ->toArray();
            },
        );
    }
}
