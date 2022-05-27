<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = json_decode(file_get_contents(storage_path() . "/json/data.json"), true);
        foreach ($events as $event) {
            $event['startDate'] = (Carbon::today()->addDays(rand(0, 150))->format('Y-m-d'));
            $event['endDate'] = (Carbon::createFromFormat('Y-m-d', $event['startDate'])->addDays(rand(0, 20))->format('Y-m-d'));
            Event::firstOrCreate($event);
        }
        return;
    }
}
