<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $truncateTables = ['bands', 'albums'];
        $seedModels = ['Band', 'Album'];

        // Truncate Tables
        DB::statement('SET foreign_key_checks = 0');
        foreach ($truncateTables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET foreign_key_checks = 1');

        // Run Faker Seeder
        foreach ($seedModels as $model) {
            $className = 'App\\'.$model;
            $class = get_class(new $className);
            factory($class, 30)->create();
        }
    }
}
