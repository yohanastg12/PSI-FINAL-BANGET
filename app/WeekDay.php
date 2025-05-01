<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeekDay extends Model
{
    use SoftDeletes;

    public $table = 'weekday';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name'
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }
}