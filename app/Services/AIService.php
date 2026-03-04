<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Collection;

class AIService
{
    public static function analyzeVehicle(Vehicle $vehicle): string
    {
        return
            "🚗 Анализ автомобиля: {$vehicle->brand} {$vehicle->model}\n" .
            "• Пробег: {$vehicle->mileage} км\n" .
            "• Топливо: {$vehicle->fuel_type}\n\n" .
            "Рекомендации:\n" .
            "• Проверить уровень масла\n" .
            "• Оценить состояние шин\n" .
            "• Следить за датой следующего ТО\n";
    }
    public static function quickStatus($vehicle)
    {
        $remaining = $vehicle->remainingKm();
        $date = $vehicle->nextServiceDate();

        if ($remaining !== null && $remaining < 300) {
            return "⚠ Срочно требуется ТО (осталось {$remaining} км)";
        }

        if ($date && now()->diffInDays($date, false) <= 5) {
            return "⚠ ТО по дате скоро ({$date})";
        }

        if ($remaining !== null) {
            return "🟢 Всё в норме. До следующего ТО осталось {$remaining} км.";
        }

        return "ℹ Данных для анализа пока недостаточно.";
    }

    public static function operatorRecommendation(Collection $vehicles): string
    {
        $total = $vehicles->count();

        if ($total === 0) {
            return 'ℹ В системе пока нет автомобилей для анализа.';
        }

        $overdue = 0;
        $soon = 0;
        $noData = 0;

        foreach ($vehicles as $vehicle) {
            $remaining = $vehicle->remainingKm();
            $date = $vehicle->nextServiceDate();

            if ($remaining === null && !$date) {
                $noData++;
                continue;
            }

            if ($remaining !== null && $remaining < 0) {
                $overdue++;
                continue;
            }

            if (
                ($remaining !== null && $remaining < 300) ||
                ($date && now()->diffInDays($date, false) <= 5)
            ) {
                $soon++;
            }
        }

        if ($overdue > 0) {
            return "🚨 Обнаружено автомобилей с просроченным ТО: {$overdue}. Рекомендуется срочно запланировать обслуживание.";
        }

        if ($soon > 0) {
            return "⚠ {$soon} автомобилей приближаются к ТО. Рекомендуется подготовить график обслуживания.";
        }

        if ($noData > 0) {
            return "ℹ Для {$noData} автомобилей недостаточно данных. Рекомендуется заполнить информацию по ТО.";
        }

        return "🟢 Автопарк в стабильном состоянии. Критических отклонений не выявлено.";
    }

}
