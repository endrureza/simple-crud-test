<?php

use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\MCluster::class, 10)->create()->each(function($cluster) {
            $cluster->types()->saveMany(
                factory(\App\MType::class, 3)->make()
            );
        });
    }
}
