<?php

namespace Database\Seeders\User;

use App\Models\User;
use Database\Factories\User\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->create([
            'username' => 'test',
            'firstname' => 'Тест',
            'lastname' => 'Тестов',
            'fathername' => 'Тестович',
            'gender' => 'муж',
            'email' => 'mail@mail.com',
            'password' => '123123',
        ]);

        UserFactory::new()->count(5)->create();
    }
}
