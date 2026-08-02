<?php

namespace Mortezamasumi\FbSetting;

use Mortezamasumi\FbSetting\Models\FbSetting as ModelsFbSetting;

class FbSetting
{
    /**
     * @param  array<string, string>  $values
     */
    public function get(string $key, mixed $default = null, ?string $attrKey = null, array $values = []): mixed
    {
        $setting = ModelsFbSetting::query()
            ->where('key', $key)
            ->where('active', true)
            ->first();

        if ($setting === null) {
            if (! empty($default)) {
                if (is_array($default)) {
                    return $attrKey === null
                        ? $default
                        : ($default[$attrKey] ?? null);
                }

                foreach ($values as $name => $data) {
                    $default = str_replace(':'.$name, $data, (string) $default);
                }
            }

            return $default;
        }

        $attributes = $setting->getAttribute('attributes');

        if (is_array($attributes) && count($attributes) > 0) {
            if ($attrKey === null) {
                return $attributes;
            }

            $attribute = $attributes[$attrKey] ?? null;

            return is_array($attribute) ? ($attribute['value'] ?? null) : null;
        }

        $value = $setting->getAttribute('value') ?? '';

        foreach ($values as $name => $data) {
            $value = str_replace(':'.$name, $data, $value);
        }

        return $value;
    }
}
