<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{

        public function up()
        {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('session_id')->constrained('sessions'); // Menyambung ke tabel sesi
                $table->foreignId('class_id')->constrained(); // Relasi ke tabel kelas
                $table->foreignId('teacher_id')->constrained('users'); // Relasi ke tabel guru
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('lessons');
        }
    }
    
