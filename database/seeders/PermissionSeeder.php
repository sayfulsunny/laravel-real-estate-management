<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage-users']);
        Permission::firstOrCreate(['name' => 'edit profile']);
        Permission::firstOrCreate(['name' => 'view dashboard']);
        // Customer permissions 
        Permission::create(['name' => 'view customer']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'edit customer']);
        Permission::create(['name' => 'delete customer']);

        //Project permissions as needed
        Permission::create(['name' => 'view project']);
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'edit project']);
        Permission::create(['name' => 'delete project']);

        // Expense permissions
        Permission::firstOrCreate(['name' => 'view expense']);
        Permission::firstOrCreate(['name' => 'create expense']);
        Permission::firstOrCreate(['name' => 'edit expense']);
        Permission::firstOrCreate(['name' => 'delete expense']);

        // Expenses-categorie permissions
        Permission::firstOrCreate(['name' => 'view expenses-categorie']);
        Permission::firstOrCreate(['name' => 'create expenses-categorie']);
        Permission::firstOrCreate(['name' => 'edit expenses-categorie']);
        Permission::firstOrCreate(['name' => 'delete expenses-categorie']);

         // Income permissions
        Permission::firstOrCreate(['name' => 'view income']);
        Permission::firstOrCreate(['name' => 'create income']);
        Permission::firstOrCreate(['name' => 'edit income']);
        Permission::firstOrCreate(['name' => 'delete income']);

        // Income-categorie permissions
        Permission::firstOrCreate(['name' => 'view income-categorie']);
        Permission::firstOrCreate(['name' => 'create income-categorie']);
        Permission::firstOrCreate(['name' => 'edit income-categorie']);
        Permission::firstOrCreate(['name' => 'delete income-categorie']);
        
        
        // Commission permissions report
        Permission::firstOrCreate(['name' => 'view commission-report']);
        Permission::firstOrCreate(['name' => 'view commission-history']);

        // Installment permissions 
        Permission::firstOrCreate(['name' => 'view installment']);
        Permission::firstOrCreate(['name' => 'create installment']);
        Permission::firstOrCreate(['name' => 'edit installment']);
        Permission::firstOrCreate(['name' => 'delete installment']);

        // User permissions 
        Permission::firstOrCreate(['name' => 'view user']);
        Permission::firstOrCreate(['name' => 'create user']);
        Permission::firstOrCreate(['name' => 'edit user']);
        Permission::firstOrCreate(['name' => 'delete user']);
       

        // Create roles and assign existing permissions
         $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole->givePermissionTo(['edit profile', 'view dashboard']); 

      

    }
}
