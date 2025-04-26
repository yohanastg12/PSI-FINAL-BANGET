<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeekdayToLessonsTable extends Migration
{
  
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedTinyInteger('weekday')->after('teacher_id');
        });
    }
    
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('weekday');
        });
    }
    }
