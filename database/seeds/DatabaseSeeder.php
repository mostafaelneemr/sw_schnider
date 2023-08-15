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
        $sql = file_get_contents(base_path('sensors.sql'));

        \Illuminate\Support\Facades\DB::unprepared( $sql );
    }
}
