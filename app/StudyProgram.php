<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use SoftDeletes;

    public $table = 'study_program';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'end_time'
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }
}