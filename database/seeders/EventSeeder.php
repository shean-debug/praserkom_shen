<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            ['title' => 'Jakarta Music Fest 2026', 'category' => 'Festival', 'ticket_price' => 450000, 'description' => 'Festival musik tiga hari dengan banyak penampil.'],
            ['title' => 'Malam Akustik Senja', 'category' => 'Musik', 'ticket_price' => 150000, 'description' => 'Konser akustik intim dengan suasana senja.'],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
