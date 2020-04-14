<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'can add item']);
        Permission::create(['name' => 'can edit item']);
        Permission::create(['name' => 'can delete item']);
        Permission::create(['name' => 'can add to cart']);
        Permission::create(['name' => 'can checkout item']);
    }
}
