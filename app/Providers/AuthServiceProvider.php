<?php

namespace App\Providers;
use App\Advert;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-panel',function (User $user){
           return $user->isAdmin();
        });
        Gate::define('manage-adverts-categories', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin() ;
        });
        Gate::define('manage-regions', function (User $user) {
            return $user->isAdmin();
        });
        /*
        Gate::define('manage-pages', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('manage-tickets', function (User $user) {
            return $user->isAdmin() ;
        });
        Gate::define('manage-adverts', function (User $user) {
            return $user->isAdmin() ;
        });
        Gate::define('manage-banners', function (User $user) {
            return $user->isAdmin();
        });*/
        Gate::define('manage-own-advert', function (User $user,Advert $advert) {
            return $advert->user_id==$user->id;
        });
        Gate::define('show-advert', function (User $user, Advert $advert) {
            return $user->isAdmin() || $user->isModerator() || $advert->user_id === $user->id;
        });
        Gate::define('manage-adverts', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
    }

}
