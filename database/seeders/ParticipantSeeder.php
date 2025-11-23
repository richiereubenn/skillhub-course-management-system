<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        Participant::create([
            'name' => 'Alice Johnson',
            'phone' => '081234567890',
            'email' => 'alice@example.com',
            'address' => 'Jl. Mawar No. 10, Jakarta'
        ]);

        Participant::create([
            'name' => 'Bob Williams',
            'phone' => '081987654321',
            'email' => 'bob@example.com',
            'address' => 'Jl. Melati No. 5, Bandung'
        ]);

        Participant::create([
            'name' => 'Charlie Brown',
            'phone' => '081234998877',
            'email' => 'charlie@example.com',
            'address' => 'Jl. Anggrek No. 7, Surabaya'
        ]);
    }
}
