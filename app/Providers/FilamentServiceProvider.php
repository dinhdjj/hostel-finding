<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Support\Components\ViewComponent;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Str;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function (): void {
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );

            Filament::registerStyles([
                app(Vite::class)('resources/css/places-autocomplete-dropdown.css'),
            ]);

            Filament::registerScripts([
                app(Vite::class)('resources/js/filament-admin.js'),
            ], shouldBeLoadedBeforeCoreScripts: true);
        });

        ViewComponent::macro('localizeLabel', function () {
            // @phpstan-ignore-next-line
            $this->label(function (?string $model = null, $column = null, ...$args): string {
                /** @phpstan-ignore-next-line */
                $name = $this->getName();
                $model = new ReflectionClass($model ?? $column->getTable()->getModel());
                $modelName = Str::lower($model->getShortName());
                $key = 'models.'.$modelName.'.'.$name;
                $trans = __($key);

                if ($trans === $key) {
                    $trans = Str::of($name)
                        ->beforeLast('.')
                        ->afterLast('.')
                        ->kebab()
                        ->replace(['-', '_'], ' ')
                        ->toString()
                    ;

                    $trans = __($trans);
                }

                return ucfirst($trans);
            });

            return $this;
        });
    }
}
