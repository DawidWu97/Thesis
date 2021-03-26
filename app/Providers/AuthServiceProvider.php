<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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
        $this->registerAllPermissions();
        $this->registerAllRoles();

    }

    public function registerAllPermissions()
    {

        foreach (Permission::all() as $permission)
        {
            $name = $permission->title;
            Gate::define($name, function ($user) use ($permission){
                $name = $permission->title;
                return $user->hasPermission($name);
            });
        }

    }
    public function registerAllRoles()
    {

        foreach (Role::all() as $role)
        {
            $name = $role->title;
            Gate::define($name, function ($user) use ($role){
                $name = $role->title;
                return $user->hasRole($name);
            });
        }

    }
}
