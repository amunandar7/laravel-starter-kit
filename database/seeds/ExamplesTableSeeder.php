<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ExampleStatus;

class ExamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $categoriesCount = 5;
        for($i = 0; $i < $categoriesCount; $i++) {
            DB::table('example_categories')->insert([
                'name' => $faker->word,
                'description' => $faker->text(50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        for($i = 0; $i < 100; $i++) {
            DB::table('examples')->insert([
                'example_category_id' => rand(1, $categoriesCount),
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt($faker->password(6,10)),
                'example_date' => $faker->date("Y-m-d"),
                'description' => $faker->randomHtml(4,4),
                'status' => rand(0, sizeof(ExampleStatus::getLabels())-1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
