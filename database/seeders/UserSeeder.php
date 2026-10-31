<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $clave = env('ADMIN_PASSWORD');

        if (! $clave) {
            $this->command->error('Define ADMIN_PASSWORD en tu archivo .env antes de ejecutar este seeder.');
            return;
        }

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@techstock.com')],
            [
                'name'     => 'Administrador',
                'password' => Hash::make($clave),
            ]
        );
    }
}