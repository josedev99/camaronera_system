<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'phone' => '212211',
            'email' => 'admin@gmail.com',
            'profile' => 'ADMINISTRADOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('12345678'),
            'image' => 'noimg.png',
            
        ]);

        User::create([
            'name' => 'contador',
            'phone' => '212211',
            'email' => 'contador@gmail.com',
            'profile' => 'CONTADOR',
            'status' => 'ACTIVE',
            'password' => bcrypt('12345678'),
            'image' => 'noimg.png',
            
        ]);

        //permisos en general

        //dash 
        Permission::create(['name' => 'dash']);
        Permission::create(['name' => 'abonos']);
        Permission::create(['name' => 'ventas']);
        Permission::create(['name' => 'compras']);


        //categorias
        Permission::create(['name' => 'category_index']);
        Permission::create(['name' => 'category_create']);
        Permission::create(['name' => 'category_search']);
        Permission::create(['name' => 'category_edit']);
        Permission::create(['name' => 'category_destroy']);

        //roles
        Permission::create(['name' => 'rol_index']);
        Permission::create(['name' => 'rol_create']);
        Permission::create(['name' => 'rol_search']);
        Permission::create(['name' => 'rol_edit']);
        Permission::create(['name' => 'rol_destroy']);

        //permissions
        Permission::create(['name' => 'permission_index']);
        Permission::create(['name' => 'permission_create']);
        Permission::create(['name' => 'permission_search']);
        Permission::create(['name' => 'permission_edit']);
        Permission::create(['name' => 'permission_destroy']);

        //products
        Permission::create(['name' => 'product_index']);
        Permission::create(['name' => 'product_create']);
        Permission::create(['name' => 'product_search']);
        Permission::create(['name' => 'product_edit']);
        Permission::create(['name' => 'product_destroy']);

        //users
        Permission::create(['name' => 'user_index']);
        Permission::create(['name' => 'user_create']);
        Permission::create(['name' => 'user_search']);
        Permission::create(['name' => 'user_edit']);
        Permission::create(['name' => 'user_destroy']);

        //denominations
        Permission::create(['name' => 'denomination_index']);
        Permission::create(['name' => 'denomination_create']);
        Permission::create(['name' => 'denomination_search']);
        Permission::create(['name' => 'denomination_edit']);
        Permission::create(['name' => 'denomination_destroy']);

        //reports
        Permission::create(['name' => 'report_index']);
        Permission::create(['name' => 'report_consult']);
        Permission::create(['name' => 'report_table']);
        
        //assigns

        Permission::create(['name' => 'assign_index']);
        Permission::create(['name' => 'assign_form']);
        Permission::create(['name' => 'assign_table']);

        //sales
        Permission::create(['name' => 'sale_index']);
        Permission::create(['name' => 'sale_product']);
        Permission::create(['name' => 'sale_scan']);
        Permission::create(['name' => 'sale_create']);


        //cashout
        Permission::create(['name' => 'cashout_index']);
        Permission::create(['name' => 'cashout_form']);
        Permission::create(['name' => 'cashout_table']);

        //pdf
        Permission::create(['name' => 'pdf']);
        //excel
        Permission::create(['name' => 'excel']);

        //purchases


        //roles principales
        $admin    = Role::create(['name' => 'ADMINISTRADOR']);
        $empleado = Role::create(['name' => 'CONTADOR']);

        //asignacion de permisos

        $admin->givePermissionTo([
            'dash',
            'category_index',
            'category_create',
            'category_search',
            'category_edit',
            'category_destroy',
            'rol_index',
            'rol_create',
            'rol_search',
            'rol_edit',
            'rol_destroy',
            'permission_index',
            'permission_create',
            'permission_search',
            'permission_edit',
            'permission_destroy',
            'product_index',
            'product_create',
            'product_search',
            'product_edit',
            'product_destroy',
            'user_index',
            'user_create',
            'user_search',
            'user_edit',
            'user_destroy',
            'denomination_index',
            'denomination_create',
            'denomination_search',
            'denomination_edit',
            'denomination_destroy',
            'report_index',
            'report_consult',
            'report_table',
            'assign_index',
            'assign_form',
            'assign_table',
            'sale_index',
            'sale_product',
            'sale_scan',
            'sale_create',
            'cashout_index',
            'cashout_form',
            'cashout_table',
            'pdf',
            'excel',
            'ventas',
            'compras',
            'abonos',
            'home'
                        
        ]);

        $empleado->givePermissionTo([
            'home',
            'pdf',
            'excel',
            'report_index',
            'report_consult',
            'report_table',
        ]);

        //asignar rol al usuario admin
        $uAdmin = User::find(1);
        $uAdmin->syncRoles('ADMINISTRADOR');

        //asignar rol al usuario empleado
        $uEmpleado = User::find(2);
        $uEmpleado->syncRoles('CONTADOR');





    }
}
