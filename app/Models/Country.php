<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Country extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = ["name"];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }
}
