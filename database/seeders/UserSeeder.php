<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'sayid al husain',
            'email' => 'sayyid.dega@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(80),
        ]);
    }
}
