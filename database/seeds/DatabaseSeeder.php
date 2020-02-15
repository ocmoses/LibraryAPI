<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(BorrowerTypesSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
