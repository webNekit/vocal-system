<?php

namespace Database\Seeders;

use App\Models\assignment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('role', ['user', 'mentor'])->get();

        // Проверяем, есть ли достаточно пользователей для назначения
        if ($users->count() > 1) {
            // Создаем несколько записей в таблице assignments, связывая user и mentor
            $user = $users->firstWhere('role', 'user'); // Первый пользователь с ролью 'user'
            $mentor = $users->firstWhere('role', 'mentor'); // Первый пользователь с ролью 'mentor'

            // Если найден пользователь и наставник
            if ($user && $mentor) {
                Assignment::create([
                    'user_id' => $user->id,
                    'mentor_id' => $mentor->id,
                ]);
            }

            // Пример для создания других записей, например, второй пользователь и наставник
            $user2 = $users->skip(1)->firstWhere('role', 'user');
            $mentor2 = $users->skip(1)->firstWhere('role', 'mentor');

            if ($user2 && $mentor2) {
                Assignment::create([
                    'user_id' => $user2->id,
                    'mentor_id' => $mentor2->id,
                ]);
            }
        }
    }
}
