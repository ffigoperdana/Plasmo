<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/MainHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ($this->jetstreamComponentAliases() as $alias => $component) {
            Blade::component($component, $alias);
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Register Livewire components from the old namespace location
        Livewire::component('create-hospital', \App\Http\Livewire\CreateHospital::class);
        Livewire::component('create-user', \App\Http\Livewire\CreateUser::class);
        Livewire::component('table.main', \App\Http\Livewire\Table\Main::class);
        Livewire::component('table.hospital', \App\Http\Livewire\Table\Hospital::class);
    }

    protected function jetstreamComponentAliases(): array
    {
        return [
            'jet-action-message' => 'components.action-message',
            'jet-action-section' => 'components.action-section',
            'jet-authentication-card' => 'components.authentication-card',
            'jet-authentication-card-logo' => 'components.authentication-card-logo',
            'jet-button' => 'components.button',
            'jet-confirms-password' => 'components.confirms-password',
            'jet-confirmation-modal' => 'components.confirmation-modal',
            'jet-danger-button' => 'components.danger-button',
            'jet-dialog-modal' => 'components.dialog-modal',
            'jet-form-section' => 'components.form-section',
            'jet-input' => 'components.input',
            'jet-input-error' => 'components.input-error',
            'jet-label' => 'components.label',
            'jet-secondary-button' => 'components.secondary-button',
            'jet-section-border' => 'components.section-border',
            'jet-validation-errors' => 'components.validation-errors',
            'jet-welcome' => 'components.welcome',
        ];
    }
}
