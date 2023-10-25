<?php

namespace App\Providers;

use App\Http\Libs\Roles;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post', function (User $user) {
            return $user->role === Roles::ADMIN;
        });

        Gate::define('destroy-post', function (User $user) {
            return $user->role === Roles::ADMIN;
        });

        Gate::define('store-post', function (User $user) {
            return $user->role === Roles::ADMIN;
        });

        Gate::define('show-post', function (User $user) {
            return in_array($user->role, [Roles::ADMIN, Roles::USER]);
        });

        Gate::define('index-post-user', function (User $user) {
            return $user->role === Roles::USER;
        });

        Gate::define('index-post-admin', function (User $user) {
            return $user->role === Roles::ADMIN;
        });
    }
}
