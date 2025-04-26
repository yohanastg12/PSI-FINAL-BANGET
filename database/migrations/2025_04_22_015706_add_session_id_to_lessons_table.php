<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionIdToLessonsTable extends Migration
{
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->integer('session_id')->nullable()->after('teacher_id');  // Menambahkan kolom session_id setelah teacher_id
        });
    }
    
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('session_id');  // Menghapus kolom session_id jika migration di-rollback
        });
    }
    }
