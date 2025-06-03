<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Парсер времени</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
        }

        textarea {
            width: 100%;
            height: 600px;
            margin-bottom: 20px;
        }

        .report {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <h2>Введите данные для анализа:</h2>

    <form method="POST" action="{{ route('time.report.process') }}">
        @csrf
        <textarea name="data">{{ old('data', $input ?? '') }}</textarea>
        <button type="submit">Обработать</button>
    </form>

    @if(isset($report))
        <h3>Результат анализа:</h3>
        <div class="report">
            @if(count($report))
                <ul>
                    @foreach($report as $position => $time)
                        <li><strong>{{ $position }}:</strong> {{ $time }}</li>
                    @endforeach
                </ul>
            @else
                <p>Нет данных для отображения.</p>
            @endif
        </div>
    @endif

</body>

</html>