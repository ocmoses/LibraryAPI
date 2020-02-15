<?php

use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('books')->insert(array(
            array('title' => 'Things Fall Apart', 
                  'author' => 'Chinua Achebe', 
                  'total' => 3, 
                  'available' => 2),
            array('title' => 'Half of a Yellow Sun', 
                  'author' => 'Chimamanda Adichie', 
                  'total' => 1, 
                  'available' => 1),
            array('title' => 'The Lion and the Jewel', 
                  'author' => 'Wole Soyinka', 
                  'total' => 1, 
                  'available' => 0),
            array('title' => 'Oliver Twist', 
                  'author' => 'Charles Dickens', 
                  'total' => 2, 
                  'available' => 1),
            
        ));
    }
}
