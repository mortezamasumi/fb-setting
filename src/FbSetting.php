<?php

namespace Mortezamasumi\FbSetting;

use Mortezamasumi\FbSetting\Models\FbSetting as ModelsFbSetting;

class FbSetting
{
    public function get(string $key, mixed $default = null, ?string $attrKey = null, array $values = []): mixed
    {
        if (! ($content = ModelsFbSetting::where('key', $key)->where('active', true)->first())) {
            if (! empty($default)) {
                if (is_array($default)) {
                    if (empty($attrKey)) {
                        return $default;
                    } else {
                        return $default[$attrKey] ?? null;
                    }
                } else {
                    foreach ($values as $key => $data) {
                        $default = str_replace(':'.$key, $data, $default ?? '');
                    }
                }
            }

            return $default;
        }

        if (is_array($content->attributes) && count($content->attributes) > 0) {
            if (empty($attrKey)) {
                return $content->attributes;
            } else {
                return $content->attributes[$attrKey]['value'] ?? null;
            }
        }

        $content = $content->value ?? '';

        foreach ($values as $key => $data) {
            $content = str_replace(':'.$key, $data, $content);
        }

        return $content;
    }
}
