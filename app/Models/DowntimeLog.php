<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DowntimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'down_at',
        'up_at',
        'reason',
        'effect',
        'duration_minutes',
    ];

    protected $casts = [
        'down_at' => 'datetime',
        'up_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($log) {
            if ($log->up_at && $log->down_at) {
                $log->duration_minutes = $log->down_at->diffInMinutes($log->up_at, false);
            }
        });

        static::saved(function ($log) {
            $device = $log->device;
            if ($device) {
                $hasOpenLog = DowntimeLog::where('device_id', $device->id)->whereNull('up_at')->exists();
                $device->current_status = $hasOpenLog ? 'offline' : 'online';
                $device->saveQuietly();
            }
        });
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
