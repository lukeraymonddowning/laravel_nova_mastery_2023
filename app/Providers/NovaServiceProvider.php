<?php

namespace App\Providers;

use App\Nova\Author;
use App\Nova\Book;
use App\Nova\Customer;
use App\Nova\Dashboards\Main;
use App\Nova\Genre;
use App\Nova\Lenses\BookStock;
use App\Nova\Publisher;
use App\Nova\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::initialPath('/resources/customers');

        Nova::mainMenu(fn ($request) => [
            MenuItem::dashboard(Main::class)->name('Overview'),

            MenuSection::make('Customers', [
                MenuItem::resource(Customer::class),
            ])->icon('user-group'),

            MenuSection::make('Books', [
                MenuItem::resource(Book::class),
                MenuItem::lens(Book::class, BookStock::class),
                MenuItem::resource(Author::class),
                MenuItem::resource(Publisher::class),
                MenuItem::resource(Genre::class),
            ])->icon('book-open')->collapsable(),

            MenuSection::make('Support', [
                MenuItem::resource(User::class),
            ])->icon('cog'),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
