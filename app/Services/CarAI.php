<?php

namespace App\Services;

use App\Models\Vehicle;
use Carbon\Carbon;

class CarAI
{
    public static function analyze(Vehicle $vehicle)
    {
        // Если машины нет
        if (!$vehicle) {
            return [
                'status' => 'Нет данных',
                'advice' => 'Автомобиль не найден',
                'risk' => 'unknown'
            ];
        }

        $mileage = $vehicle->mileage;
        $nextServiceKm = $vehicle->nextMaintenance()->next_service_odometer ?? null;
        $nextServiceDate = $vehicle->nextServiceDate() ? Carbon::parse($vehicle->nextServiceDate()) : null;

        $remainingKm = $vehicle->remainingKm();
        $daysLeft = $nextServiceDate ? now()->diffInDays($nextServiceDate, false) : null;

        // --- ЛОГИКА ОЦЕНКИ ---

        // 1) Опасная зона ТО
        if ($remainingKm !== null && $remainingKm < 500) {
            return [
                'status' => "Срочно требуется обслуживание!",
                'advice' => "До следующего ТО осталось всего {$remainingKm} км. Рекомендуется выполнить ТО в ближайшие дни.",
                'risk' => 'high'
            ];
        }

        if ($daysLeft !== null && $daysLeft < 5) {
            return [
                'status' => "Срок ТО почти пришёл",
                'advice' => "До планового ТО осталось всего {$daysLeft} дней. Запланируйте посещение СТО.",
                'risk' => 'medium'
            ];
        }

        // 2) Большой пробег
        if ($mileage > 200000) {
            return [
                'status' => "Высокий пробег",
                'advice' => "Автомобиль превысил 200 000 км. Проверьте подвеску, масло и уровень жидкостей.",
                'risk' => 'medium'
            ];
        }

        // 3) Нормальное состояние
        return [
            'status' => "Всё в порядке",
            'advice' => "Автомобиль в хорошем состоянии. Продолжайте эксплуатацию.",
            'risk' => 'low'
        ];
    }
}
