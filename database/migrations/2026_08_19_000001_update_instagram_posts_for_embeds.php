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
            if (! Schema::hasColumn('instagram_posts', 'embed_code')) {
                $table->text('embed_code')->nullable()->after('instagram_url');
            }

            if (! Schema::hasColumn('instagram_posts', 'admin_note')) {
                $table->string('admin_note', 255)->nullable()->after('embed_code');
            }
        });

        if (Schema::hasColumn('instagram_posts', 'image')) {
            Schema::table('instagram_posts', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }

        if (Schema::hasColumn('instagram_posts', 'caption')) {
            Schema::table('instagram_posts', function (Blueprint $table) {
                $table->dropColumn('caption');
            });
        }

        if (Schema::hasColumn('instagram_posts', 'published_at')) {
            Schema::table('instagram_posts', function (Blueprint $table) {
                $table->dropColumn('published_at');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('instagram_posts')) {
            return;
        }

        Schema::table('instagram_posts', function (Blueprint $table) {
            if (Schema::hasColumn('instagram_posts', 'embed_code')) {
                $table->dropColumn('embed_code');
            }

            if (Schema::hasColumn('instagram_posts', 'admin_note')) {
                $table->dropColumn('admin_note');
            }

            if (! Schema::hasColumn('instagram_posts', 'caption')) {
                $table->string('caption', 500)->nullable();
            }

            if (! Schema::hasColumn('instagram_posts', 'image')) {
                $table->string('image')->nullable();
            }

            if (! Schema::hasColumn('instagram_posts', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }
};
