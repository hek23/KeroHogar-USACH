<?php

use Illuminate\Database\Seeder;
use App\TimeBlock;

class TimeBlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TimeBlock::class)->create([
            'start' => '08:00',
            'end' => '10:00',
        ]);
        factory(TimeBlock::class)->create([
            'start' => '10:00',
            'end' => '13:00',
        ]);
        factory(TimeBlock::class)->create([
            'start' => '14:00',
            'end' => '17:00',
        ]);
        factory(TimeBlock::class)->create([
            'start' => '17:00',
            'end' => '20:00',
        ]);
    }
}
