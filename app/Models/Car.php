<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Car extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'cars';

    protected $dates = [
        'created_at',
        'bought_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'brand',
        'model',
        'engine',
        'vin',
        'plates',
        'user_id',
        'created_at',
        'bought_mileage',
        'bought_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function carRepairs()
    {
        return $this->hasMany(Repair::class, 'car_id', 'id');
    }

    public function carUpcomings()
    {
        return $this->hasMany(Upcoming::class, 'car_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBoughtAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setBoughtAtAttribute($value)
    {
        $this->attributes['bought_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
