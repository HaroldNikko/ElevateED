<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('info', function (Blueprint $table) {
            // Make sure schoolID allows NULL or has valid references already
            $table->unsignedBigInteger('schoolID')->nullable()->change();

            $table->foreign('schoolID')
                  ->references('schoolID')
                  ->on('schooldetails')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('info', function (Blueprint $table) {
            $table->dropForeign(['schoolID']);
        });
    }
};
