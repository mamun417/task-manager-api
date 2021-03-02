<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('role_id', 1)->first();

        if (!$admin) {
            User::create([
                'role_id' => 1, // admin
                'name' => 'Admin Name',
                'email' => 'admin@test.com',
                'phone' => '00 33 1 40 00 00 00',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

        }

        factory(User::class, 20)->create();
    }
}
