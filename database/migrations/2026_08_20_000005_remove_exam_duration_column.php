<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('exams', 'question_duration_seconds')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->dropColumn('question_duration_seconds');
            });
        }
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedSmallInteger('question_duration_seconds')->default(20)->after('is_published');
        });
    }
};
