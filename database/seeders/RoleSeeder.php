<?php

namespace Database\Seeders;

use App\Constants\RoleNames;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Create roles
		$adminRole = Role::create(['name' => RoleNames::ADMIN]);
		$userRole = Role::create(['name' => RoleNames::USER]);

		// Create permissions
		$userPermissions = [
			['name' => 'view transaction history', 'guard_name' => 'web'],
			['name' => 'can deposit money', 'guard_name' => 'web'],
			['name' => 'can withdraw money', 'guard_name' => 'web'],
		];

		$adminPermissions = [
			['name' => 'view users', 'guard_name' => 'web'],
			['name' => 'edit users', 'guard_name' => 'web'],
			['name' => 'access horizon', 'guard_name' => 'web'],
		];

		Permission::insert(array_merge($userPermissions, $adminPermissions));

		// Assign permissions to roles
		foreach ($userPermissions as $permission) {
			$adminRole->givePermissionTo($permission['name']);
			$userRole->givePermissionTo($permission['name']);
		}

		foreach ($adminPermissions as $permission) {
			$adminRole->givePermissionTo($permission['name']);
		}
	}
}
