<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['name', 'value'];

    /**
     * Get a configuration value by name.
     */
    public static function get(string $name, ?string $default = null): ?string
    {
        $config = static::where('name', $name)->first();

        return $config ? $config->value : $default;
    }

    /**
     * Set a configuration value by name.
     */
    public static function set(string $name, ?string $value): void
    {
        static::updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );
    }
}
