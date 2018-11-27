<?php

use App\User;
use App\Sample;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email = 'admin@admin.ch';
        $user->password = \Hash::make(env('APP_PASSWORD'));
        $user->name = 'Admin';
        $user->save();
    }
}
