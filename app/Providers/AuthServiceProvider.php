<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        $roles['user'] = DB::table('roles')->select('id')->where('name', 'Utilisateur')->pluck('id')->toArray()[0];
        $roles['mod'] = DB::table('roles')->select('id')->where('name', 'Modérateur')->pluck('id')->toArray()[0];
        $roles['admin'] = DB::table('roles')->select('id')->where('name', 'Administrateur')->pluck('id')->toArray()[0];

        Gate::define('admin-access', function ($user) use($roles) {
            return $user->role_id == $roles['admin'];
        });

        Gate::define('mod-access', function ($user) use($roles) {
            return $user->role_id == $roles['mod'];
        });

        Gate::define('validate-skin', function ($user) use($roles) {
            return $user->role_id == $roles['mod']
                || $user->role_id == $roles['admin'];
        });
        //
    }
}
