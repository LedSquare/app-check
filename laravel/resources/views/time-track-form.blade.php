<!DOCTYPE html>
<html lang="ru">

<div class="container mt-5">
    <h2>Парсинг учёта времени</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('time.parse') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="issue" class="form-label">Ссылка на задачу</label>
            <input type="text" name="issue" id="issue" class="form-control" placeholder="https://tracker.2e8.ru/issue/"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Запустить парсинг</button>
    </form>
</div>

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

</html>