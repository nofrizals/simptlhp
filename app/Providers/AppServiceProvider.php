<?php

namespace App\Providers;

use App\Models\VerifikasiSsr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    public function boot(): void
    {
        Carbon::setLocale('id');
        View::composer('partials.sidebar', function ($view) {
            $data = VerifikasiSsr::whereNull('approve_by')->whereNull('reject_by')->where('id_status', '<>', 3);
            if (session('tim')) {
                $data->whereHas('rekomendasi.temuan.kasus.instansi', function (Builder $query) {
                    $query->where('id_tim', session('tim'));
                });
            }
            $countApprove = $data->count();
            $view->with('countApprove', $countApprove);
        });
    }
}
