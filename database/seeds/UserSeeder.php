<?php

use App\Permission\Models\Permission;
use App\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $useradmin=User::create([
            'usuario'=>'Administrador',
            'email'=>'admin@gps.com',
            'password'=>bcrypt('12345678'),
            'tipo'=>'ADMIN'
        ]);
        $useracliente=User::create([
            'usuario'=>'cliente',
            'email'=>'cliente@gps.com',
            'password'=>bcrypt('12345678'),
            'tipo'=>'CLIENTE'
        ]);

    
        $roladmin=Role::create([
            'name'=>'Admin',
            'slug'=>'admin',
            'description'=>'Administrado',
            'full-access'=>'yes',
            'eliminar'=>'no'
        ]);
        $rolcliente=Role::create([
            'name'=>'Cliente',
            'slug'=>'Cliente',
            'description'=>'cliente',
            'full-access'=>'no',
            'eliminar'=>'no'
        ]);
        Role::create([
            'name'=>'Empresa',
            'slug'=>'Empresa',
            'description'=>'Empresa',
            'full-access'=>'no',
            'eliminar'=>'no'
        ]);


        $useracliente->roles()->sync([$rolcliente->id]);
        $useradmin->roles()->sync([$roladmin->id]);

        $permission_all=[];
        //permisos roles
                $permission=Permission::create([
                    'name'=>'Lista roles',
                    'slug'=>'roles.index',
                    'description'=>'Un usuario puede ver lista roles'
                ]);
                $permission_all[]=$permission->id;

                $permission=Permission::create([
                    'name'=>'crear roles',
                    'slug'=>'roles.create',
                    'description'=>'Un usuario puede ver crear roles'
                ]);
                $permission_all[]=$permission->id;

                $permission=Permission::create([
                    'name'=>'editar roles',
                    'slug'=>'roles.edit',
                    'description'=>'Un usuario puede ver editar roles'
                ]);
                $permission_all[]=$permission->id;

                $permission=Permission::create([
                    'name'=>'ver roles',
                    'slug'=>'roles.show',
                    'description'=>'Un usuario puede ver el rol'
                ]);
                $permission_all[]=$permission->id;

                $permission=Permission::create([
                    'name'=>'eliminar roles',
                    'slug'=>'roles.destroy',
                    'description'=>'Un usuario puede ver eliminar roles'
                ]);
                $permission_all[]=$permission->id;

        //permiso 

                $permission=Permission::create([
                    'name'=>'modulo de gps',
                    'slug'=>'modulo.gps',
                    'description'=>'Un usuario puede ver el modulo gps'
                ]);
                $permission_all[]=$permission->id;

                $permission=Permission::create([
                    'name'=>'modulo de mantenimiento',
                    'slug'=>'modulo.mantenimiento',
                    'description'=>'Un usuario puede ver el mantenimiento'
                ]);
                $permission_all[]=$permission->id;

               // $roladmin->permissions()->sync($permission_all);
    }
}
