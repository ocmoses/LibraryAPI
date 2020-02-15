<?php

use Illuminate\Database\Seeder;

class BorrowerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('borrower_types')->insert(array(
            array('type' => 'Teacher'),
            array('type' => 'Senior Student'),
            array('type' => 'Junior Student')
        ));
    }
}
