<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $path = __DIR__.'/locations.sql';
        $sql = file_get_contents($path);
        DB::statement("SET GLOBAL max_allowed_packet=1073741824");
        DB::unprepared($sql);
    }
}
