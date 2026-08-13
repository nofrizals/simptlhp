<?php

namespace App\Providers;

use App\Models\VerifikasiSsr;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Carbon::setLocale('id');
        View::composer('partials.sidebar', function ($view) {
            $countApprove = VerifikasiSsr::where('approve_by', null)->orWhere('reject_by', null)->count();

            $view->with('countApprove', $countApprove);
        });
    }
}
