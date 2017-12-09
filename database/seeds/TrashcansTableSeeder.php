<?php

use Illuminate\Database\Seeder;

class TrashcansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
////        factory(App\Trashcan::class, 10)->create();
//        factory(App\Trashcan::class, 10)->create()->each(function ($u) {
////            $u->trashs()->save(factory(App\Trash::class)->make());
//            $u->save();
//        });

        DB::table('trashcans')->insert([
            'height' => random_int(10, 100),
            'area' => random_int(10, 100),
            'capacity' => random_int(10, 100),
            'address' => str_random(30),
            'latitude' => random_int(10, 100),
            'longitude' => random_int(10, 100),
        ]);
    }
}
