<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['name','number_plate','ownership','type','gps_id','driver_id'];

    public function driver(){
        return $this->hasOne(User::class, 'id', 'driver_id');
    }

    public function trips(){
        return $this->hasMany(Trip::class, 'vehicle_id', 'id')->orderBy('created_at','DESC');
    }
}
