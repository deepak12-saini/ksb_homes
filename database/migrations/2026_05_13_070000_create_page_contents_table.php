<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('page_contents')) {
            return;
        }

        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 100);
            $table->string('field_key', 100);
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->unique(['page_key', 'field_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
