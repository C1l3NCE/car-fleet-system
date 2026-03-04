<?php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, array $details = []): void
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'details'    => $details,
            'ip'         => request()->ip(),
            'user_agent' => substr(request()->userAgent(), 0, 255),
        ]);
    }
}
