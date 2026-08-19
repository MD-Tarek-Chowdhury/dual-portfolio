<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PortfolioSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
    ];

    protected $casts = [
        'setting_type' => 'string',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::remember("dual_portfolio:setting:{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('setting_key', $key)->first();
            return $setting ? self::castValue($setting) : $default;
        });
    }

    public static function set(string $key, $value, string $type = 'text'): void
    {
        self::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => $value,
                'setting_type' => $type,
            ]
        );
        Cache::forget("dual_portfolio:setting:{$key}");
        Cache::forget('dual_portfolio:settings:all');
    }

    public static function getAll(): array
    {
        $settings = self::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->setting_key] = self::castValue($setting);
        }

        return $result;
    }

    private static function castValue(self $setting): mixed
    {
        return match($setting->setting_type) {
            'boolean' => filter_var($setting->setting_value, FILTER_VALIDATE_BOOLEAN),
            'image_path' => str_starts_with($setting->setting_value, '/images/')
                ? asset($setting->setting_value)
                : asset('storage/' . $setting->setting_value),
            default => $setting->setting_value,
        };
    }

    public static function boot(): void
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget("dual_portfolio:setting:{$model->setting_key}");
            Cache::forget('dual_portfolio:settings:all');
        });

        static::deleted(function ($model) {
            Cache::forget("dual_portfolio:setting:{$model->setting_key}");
            Cache::forget('dual_portfolio:settings:all');
        });
    }
}
