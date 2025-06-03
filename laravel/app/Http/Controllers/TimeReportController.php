<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeReportController extends Controller
{
    public function showForm(): View
    {
        return view('time-report-form');
    }

    public function processForm(Request $request)
    {
        $input = $request->input('data');

        // Словарь сотрудников: ФИО => Должность
        $employees = [
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
            'Михаил Фарносов' => 'Фронтэнд-разработчик',
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
        ];

        // Разбиваем на блоки по двум переносам строк
        $blocks = preg_split('/(?:\r?\n){2,}/u', trim($input));

        $result = [];
        foreach ($blocks as $key => $block) {
            $lines = array_map('trim', explode("\n", $block));


            if (count($lines) < 6)
                continue;


            $name = $lines[0];
            $timeLine = $lines[2]; // третья строка — время

            if (! isset($employees[$name])) {
                throw new Exception('Не найден сотрудник:'.$name);
            }

            $position = $employees[$name];

            $time = $this->parseTime($timeLine);

            // Добавляем к должности
            if (! isset($result[$position])) {
                $result[$position] = 0;
            }
            $result[$position] += $time;
        }

        return view('time-report-form', [
            'report' => $result,
            'input' => $input,
        ]);
    }

    public function parseTime($text)
    {
        $text = mb_strtolower(trim($text), 'UTF-8');
        preg_match_all('/\d+\s*(?:ч|час|h|hr|мин|min|m|м)/iu', $text, $matches);
        $times = $matches[0];

        $finalMinutes = 0;
        if (count($times) > 1) {

            preg_match('/^0*(\d+)\s*(?:ч|м)/u', $times[0], $matches);
            if (! empty($matches)) {
                $finalMinutes += (int) $matches[1] * 60;
            }
            preg_match('/^0*(\d+)\s*(?:м)/u', $times[1], $matches);
            if (! empty($matches)) {
                $finalMinutes += (int) $matches[1];
            }
            return $finalMinutes;
        }

        preg_match('/^0*(\d+)\s*(?:ч)/u', $times[0], $matches);
        if (! empty($matches)) {
            return (int) $matches[1] * 60;
        }

        preg_match('/^0*(\d+)\s*(?:м)/u', $times[0], $matches);
        if (! empty($matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

}
