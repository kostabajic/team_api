<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = array('member', 'leader', 'assistant', 'coordinator');

        array_walk($roles, function ($value) {
            DB::table('roles')->insert([
                'title' => $value,
            ]);
        });
    }
}
