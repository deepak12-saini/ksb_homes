<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('instagram_posts')) {
            return;
        }

        Schema::table('instagram_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('instagram_posts', 'thumbnail_url')) {
                $table->string('thumbnail_url', 1000)->nullable()->after('embed_code');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('instagram_posts')) {
            return;
        }

        Schema::table('instagram_posts', function (Blueprint $table) {
            if (Schema::hasColumn('instagram_posts', 'thumbnail_url')) {
                $table->dropColumn('thumbnail_url');
            }
        });
    }
};
