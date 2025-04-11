<?php

namespace App\Providers;

use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->isDatabaseReady()) {
            Cache::forget('translations');
            $this->loadTranslationsFromDatabase();
        }

    }

    /**
     * @return void
     */
    protected function loadTranslationsFromDatabase(): void
    {
        $translations = Cache::rememberForever('translations', function () {
            return Translation::all()->groupBy('locale')->mapWithKeys(function ($translations, $locale) {
                return [$locale => $translations->pluck('value', 'key')->toArray()];
            });
        });

        foreach ($translations as $locale => $messages) {
            app('translator')->addLines($messages, $locale);
        }
    }

    /**
     *
     * @return bool
     */
    protected function isDatabaseReady(): bool
    {
        try {
            return Schema::hasTable('translations');
        } catch (\Exception $e) {
            return false;
        }
    }
}
