<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class TimeTrackController extends Controller
{
    private array $employees = [
        'Сергей Андриянов' => 'Ген.директор, тимлид/архитектор',
        'Аделина Ушакова' => 'Бухгалтер',
        'Олеся Зиброва' => 'Кадровый/финансовый менеджер/офис-менеджер',
        'Анастасия Лейбкович' => 'Помощник офис-менеджера',
        'Петрова Ольга' => 'Руководитель проектов',
        'Кристина Шахова' => 'Руководитель проектов',
        'Роман Ндимбе' => 'Руководитель проектов',
        'Ольга Молчанова' => 'Руководитель проектов',
        'Анастасия Краснолуцкая' => 'Аналитик',
        'Тансылу Салахиева' => 'Аналитик',
        'Екатерина Лапенко' => 'Аналитик',
        'Мальцева Кристина' => 'Фронтэнд-разработчик',
        'Владислав Перминов' => 'Фронтэнд-разработчик',
        'Александра Васина' => 'Фронтэнд-разработчик',
        'Вячеслав Иконников' => 'Фронтэнд-разработчик',
        'Фарносов Михаил' => 'Фронтэнд-разработчик',
        'Артем Лейбкович' => 'Бэкенд-разработчик',
        'Виталий Громов' => 'Бэкенд-разработчик',
        'Никита Павлюченко' => 'Бэкенд-разработчик',
        'Максим Григорьев' => 'Мобильная разработка',
        'Дмитрий Песоцкий' => 'Мобильная разработка',
        'Анжелика Семенова' => 'Мобильная разработка',
        'Вячеслав Гарчу' => 'Мобильная разработка',
        'Инна Левина' => 'QA-инженер',
        'Анастасия Воржева' => 'QA-инженер',
        'Елена Верходанова' => 'Елена Верходанова',
        'Дмитрий Хитрый' => 'QA-инженер',
        'Алиса Скляренко' => 'QA-инженер',
        'Анастасия Сафина' => 'QA-инженер',
        'Ерощенко Александр' => 'QA-инженер',
        'Краснолуцкая Анастасия' => 'Аналитик',
        'Мари Ананян' => 'Руководитель проектов'
    ];

    public function showForm(): View
    {
        return view('time-track-form');
    }

    public function parseTime(Request $request)
    {

        $url = $request->input('issue');

        $pattern = '/\/issue\/([^\/?#]+)/';
        if (preg_match($pattern, $url, $matches)) {
            $id = $matches[1];
        }

        $youtrackUrl = 'https://tracker.2e8.ru';
        $token = env('TRACK_TOKEN');

        $url = "{$youtrackUrl}/api/issues/{$id}/timeTracking/workItems?fields=author(id,name),creator(id,name),date,duration(id,minutes,presentation),id,name,text,type(id,name)";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json',
        ])->get($url);

        $result = [];
        foreach ($response->json() as $key => $work) {
            $fullname = $work['author']['name'];
            if (! $this->employees[$fullname]) {
                throw new \Exception("Не найден сотрудник: $fullname");
            }

            $position = $this->employees[$fullname];

            $time = (int) $work['duration']['minutes'];

            if (! isset($result[$position])) {
                $result[$position] = 0;
            }
            $result[$position] += $time;
        }


        $result = array_map(fn ($item) => $item / 60, $result);

        return view('time-track-form', [
            'report' => $result,
        ]);
    }

}
