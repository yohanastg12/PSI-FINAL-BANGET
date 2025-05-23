<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionIdToLessonsTable extends Migration
{
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Cara aman dan langsung: 
            $table->foreignId('session_id')
                  ->nullable()
                  ->after('teacher_id')
                  ->constrained('sessions')
                  ->onDelete('set null');
        });
    }    
    
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropColumn('session_id');
        });
    }
}