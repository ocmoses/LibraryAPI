<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

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
        $user = User::create([
            'name' => 'Teacher',
            'username' => 'Teacher',
            'borrower_type_id' => 1,
            'email' => 'teacher@library.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            
        ]);

        $user = User::create([
            'name' => 'Senior Student',
            'username' => 'Senior',
            'borrower_type_id' => 2,
            'email' => 'senior@library.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            
        ]);

        $user = User::create([
            'name' => 'Junior Student',
            'username' => 'Junior',
            'borrower_type_id' => 3,
            'email' => 'junior@library.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            
        ]);

        $user = User::create([
            'name' => 'Librarian',
            'username' => 'librarian',
            'email' => 'librarian@library.com',
            'email_verified_at' => Carbon::now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            
        ]);
    }
}
