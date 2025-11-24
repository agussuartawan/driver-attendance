<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
