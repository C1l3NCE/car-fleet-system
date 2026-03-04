<table>
    <thead>
        <tr>
            <th>Автомобиль</th>
            <th>Гос. номер</th>
            <th>Осталось км</th>
            <th>Дата ТО</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $v)
        <tr>
            <td>{{ $v->brand }} {{ $v->model }}</td>
            <td>{{ $v->reg_number }}</td>
            <td>{{ $v->remainingKm() }}</td>
            <td>{{ $v->nextServiceDate() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
