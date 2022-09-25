<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    public function up(): void
    {
        $admin = Role::whereName('admin')->whereGuardName('web')->firstOrFail();

        $admin->givePermissionTo([
            Permission::create(['name' => 'hostels.create.any']),
        ]);

        Role::create(['name' => 'supervisor'])->givePermissionTo([
            'view.admin-page',
            'users.view.any',
            'hostels.view.any',
            'comments.view.any',
            'votes.view.any',
            'visits.view.any',
            'amenities.view.any',
            'categories.view.any',
        ]);

        Role::create(['name' => 'hosteller'])->givePermissionTo([
            'hostels.create.any',
        ]);
    }
};
