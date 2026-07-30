<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Local/XAMPP databases may have orphaned projects rows without a primary key,
        // which prevents InnoDB foreign keys from attaching.
        $this->ensureProjectsPrimaryKey();

        Schema::dropIfExists('project_images');

        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['project_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_images');
    }

    private function ensureProjectsPrimaryKey(): void
    {
        if (! Schema::hasTable('projects')) {
            return;
        }

        $hasPrimary = collect(DB::select('SHOW INDEX FROM projects'))
            ->contains(fn ($index) => $index->Key_name === 'PRIMARY');

        if ($hasPrimary) {
            return;
        }

        DB::statement('ALTER TABLE projects MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }
};
