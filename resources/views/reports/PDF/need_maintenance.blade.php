<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Автомобили, требующие ТО</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #555; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Автомобили, требующие ТО</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Автомобиль</th>
            <th>Гос. номер</th>
            <th>Остаток км</th>
            <th>Дата ТО</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $v)
        <tr>
            <td>{{ $v->id }}</td>
            <td>{{ $v->brand }} {{ $v->model }}</td>
            <td>{{ $v->reg_number }}</td>
            <td>{{ $v->remainingKm() ?? '—' }}</td>
            <td>
                {{ $v->nextServiceDate()
                    ? \Carbon\Carbon::parse($v->nextServiceDate())->format('d.m.Y')
                    : '—' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
