<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Group;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $org = Organization::create([
            'name' => 'Lixnet',
            'email' => 'info@lixnet.net',
            'installation_date' => '2020-07-04',
            'licensed' => 100
        ]);
        $user = User::create([
            'firstname' => 'Nelson',
            'lastname' => 'Sammy',
            'email' => 'nelson@lixnet.net',
            'password' => Hash::make('secret'),
            'phone' => '0712345678',
            'organization_id' => 1
        ]);
        $group = [
            [
                'name'=>'Member',
                'organization_id'=>Organization::pluck('id','id')->first()
            ],
            [
                'name'=>'Chairperson',
                'organization_id'=>Organization::pluck('id','id')->first()
            ]
        ];
        Group::insert($group);
        $branch = [
            [
                'name'=>'Head Office',
                'organization_id'=>Organization::pluck('id','id')->first()
            ]
        ];
        Branch::insert($branch);
        //
        //
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
