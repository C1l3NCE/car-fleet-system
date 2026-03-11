<style>
    body {
        font-family: DejaVu Sans, sans-serif !important;
    }

    * {
        font-family: DejaVu Sans, sans-serif !important;
    }
</style>
<h2>Отчёт по затратам на автомобиль</h2>

<p><b>Автомобиль:</b> {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->reg_number }})</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Категория</th>
        <th>Сумма (₸)</th>
    </tr>
    <tr>
        <td>ТО</td>
        <td>{{ $maintenanceSum }}</td>
    </tr>
    <tr>
        <td>Ремонты</td>
        <td>{{ $repairSum }}</td>
    </tr>
    <tr>
        <td>Заправки</td>
        <td>{{ $fuelSum }}</td>
    </tr>
    <tr>
        <th>ИТОГО</th>
        <th>{{ $total }}</th>
    </tr>
</table>

<p style="margin-top:20px">Дата формирования: {{ date('d.m.Y H:i') }}</p>
