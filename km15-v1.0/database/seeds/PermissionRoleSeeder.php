<?php

use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maps = ['c'=>'create','r'=>'read','u'=>'update','d'=>'delete'];
        $roles = [
            'administrator'=>[
                'users'=>'c,r,u,d',
                'acl'=>'c,r,u,d',
                'profile'=>'r,u'
            ],
            'employee'=>[
                'profile'=>'r,u'
            ],
            'shipper'=>[
                'profile'=>'r,u'
            ]
        ];

        foreach ($roles as $key => $role){
            $rol = \App\Models\Role::create(['display_name'=>ucwords($key),'name'=>str_slug($key)]);
            foreach ($role as $k => $items){
                $items = explode(',',$items);
                foreach($items as $item){
                    $per = \App\Models\Permission::whereName(str_slug($maps[$item].' '.$k))->first();
                    if(!$per){
                        $per = \App\Models\Permission::create(['display_name'=>ucwords($maps[$item].' '.$k),'name'=>str_slug($maps[$item].' '.$k)]);
                    }
                    $rol->attachPermission($per);
                }
            }
        }
    }
}
