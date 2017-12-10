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

        for ($i = 0; $i < 10; $i++) {
            $trashcan = \App\Trashcan::create([
                'height' => random_int(10, 100),
                'area' => random_int(10, 100),
                'capacity' => random_int(10, 100),
                'address' => str_random(30),
                'latitude' => random_int(35, 37) + mt_rand() / mt_getrandmax(),
                'longitude' => random_int(127, 128) + mt_rand() / mt_getrandmax(),
                'name' => str_random(30),
                'pid' => str_random(30)
            ]);

            \App\Trashcan::find($trashcan->id)->trashs()->create([
                'in' => random_int(0, 10),
                'out' => random_int(0, 10),
                'humidity' => random_int(30, 60),
                'ultrawave' => random_int(0, 100),
                'weight' => random_int(10, 30),
            ]);
        }
    }
}
