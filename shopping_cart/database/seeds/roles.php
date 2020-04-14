<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Role::create(['name' => 'user']);
		Role::create(['name' => 'admin']);
		Role::create(['name' => 'super admin']);
    }
}
