<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = 'admin@thiuu.com';
        
        $user = User::where('email', $adminEmail)->first();
        
        if (!$user) {
            User::create([
                'name' => 'Thiuu Admin',
                'email' => $adminEmail,
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '0909090909',
                'address' => 'Thiuu HQ',
            ]);
            $this->command->info('Admin user created successfully.');
        } else {
            $user->update([
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]);
            $this->command->info('Admin user updated successfully.');
        }
    }
}
