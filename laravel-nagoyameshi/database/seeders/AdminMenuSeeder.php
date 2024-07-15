<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Menu;

class AdminMenuSeeder extends Seeder
{
    public function run()
    {
        Menu::truncate();

        Menu::create([
            'parent_id' => 0,
            'order'     => 1,
            'title'     => 'Dashboard',
            'icon'      => 'fa-bar-chart',
            'uri'       => '/',
        ]);

        Menu::create([
            'parent_id' => 0,
            'order'     => 2,
            'title'     => 'Admin',
            'icon'      => 'fa-tasks',
            'uri'       => '',
        ]);

        Menu::create([
            'parent_id' => 2,
            'order'     => 3,
            'title'     => 'Users',
            'icon'      => 'fa-users',
            'uri'       => 'auth/users',
        ]);

        Menu::create([
            'parent_id' => 2,
            'order'     => 4,
            'title'     => 'Roles',
            'icon'      => 'fa-user',
            'uri'       => 'auth/roles',
        ]);

        Menu::create([
            'parent_id' => 2,
            'order'     => 5,
            'title'     => 'Permission',
            'icon'      => 'fa-ban',
            'uri'       => 'auth/permissions',
        ]);

        Menu::create([
            'parent_id' => 2,
            'order'     => 6,
            'title'     => 'Menu',
            'icon'      => 'fa-bars',
            'uri'       => 'auth/menu',
        ]);

        Menu::create([
            'parent_id' => 2,
            'order'     => 7,
            'title'     => 'Operation log',
            'icon'      => 'fa-history',
            'uri'       => 'auth/logs',
        ]);
    }
}
