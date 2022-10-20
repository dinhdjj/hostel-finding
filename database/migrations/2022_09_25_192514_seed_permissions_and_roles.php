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
            'amenities.create.any',
            'amenities.delete.any',
            'amenities.update.any',
            'amenities.view.any',
            'view.admin-page',
            'hostels.create.any',
            'hostels.delete.any',
            'hostels.update.any',
            'hostels.view.any',
            'comments.delete.any',
            'comments.update.any',
            'comments.view.any',
            'votes.delete.any',
            'votes.update.any',
            'votes.view.any',
            'categories.create.any',
            'categories.delete.any',
            'categories.update.any',
            'categories.view.any',
        ]);

        Role::create(['name' => 'hosteller'])->givePermissionTo([
            'view.admin-page',
            'hostels.create.any',
        ]);
    }
};
