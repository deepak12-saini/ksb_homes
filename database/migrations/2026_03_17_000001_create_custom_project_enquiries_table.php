<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_project_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone', 50);
            $table->string('postcode', 20)->nullable();
            $table->text('project_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_project_enquiries');
    }
};
