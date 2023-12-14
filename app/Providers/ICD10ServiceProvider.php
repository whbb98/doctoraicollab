<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ICD10ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            'icd10_codes', function ($app) {
            $icd10 = json_decode(file_get_contents(base_path('database\\icd10.json')), true);
            $icd_list = [];
            foreach ($icd10 as $key => $el) {
                $icd_list[] = [
                    'id' => $key,
                    'description' => $el[1]
                ];
            }
            return $icd_list;
        }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
