<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'name',
        'location',
        'description',
        'ip_address',
        'current_status',
    ];

    protected $casts = [
        'category' => 'string',
        'current_status' => 'string',
    ];

    public function downtimeLogs()
    {
        return $this->hasMany(DowntimeLog::class)->latest('down_at');
    }

    public function getIsDownAttribute()
    {
        return $this->downtimeLogs()->whereNull('up_at')->exists();
    }
}
