<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список автомобилей</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Список автомобилей автопарка</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Марка</th>
            <th>Модель</th>
            <th>Гос. номер</th>
            <th>Водитель</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $v)
        <tr>
            <td>{{ $v->id }}</td>
            <td>{{ $v->brand }}</td>
            <td>{{ $v->model }}</td>
            <td>{{ $v->reg_number }}</td>
            <td>{{ $v->driver->name ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top: 20px;">
    Дата формирования: {{ now()->format('d.m.Y H:i') }}
</p>

</body>
</html>
