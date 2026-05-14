<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('architecture')->nullable()->after('image');
            $table->string('location')->nullable()->after('architecture');
            $table->string('status')->nullable()->after('location');
            $table->string('property_type')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['architecture', 'location', 'status', 'property_type']);
        });
    }
};
