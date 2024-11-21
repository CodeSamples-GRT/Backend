<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'name' => 'Alex Test',
            'email' => 'alex@test.com',
        ]);
        $user2 = User::factory()->create([
            'name' => 'Bob Test',
            'email' => 'bob@test.com',
        ]);
        $chatRoot = ChatRoom::factory()->create(['name' => 'general']);

        ChatMessage::factory()
            ->times(4)
            ->sequence(function (Sequence $sequence) use ($user1, $user2) {
                $dt = now()->startOfMonth()->addMinutes($sequence->index * 5);
                return [
                    'user_id' => $sequence->index % 2 === 0 ? $user1->id : $user2->id,
                    'created_at' => $dt,
                    'updated_at' => $dt,
                ];
            })
            ->create([
                'room_id' => $chatRoot->id,
            ]);
    }
}
