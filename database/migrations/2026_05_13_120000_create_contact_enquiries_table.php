<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_enquiries')) {
            return;
        }

        Schema::create('contact_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone', 50);
            $table->string('email');
            $table->string('suburb_postcode', 120);
            $table->json('looking_to_do');
            $table->string('land_owner', 10);
            $table->string('site_address', 500)->nullable();
            $table->string('project_type', 120);
            $table->string('budget', 120);
            $table->string('timeline', 120);
            $table->string('project_stage', 120);
            $table->string('project_goal', 120);
            $table->string('estimated_project_value', 255)->nullable();
            $table->string('number_of_dwellings', 50)->nullable();
            $table->string('looking_for_partner', 120)->nullable();
            $table->string('hear_about_us', 120);
            $table->string('hear_about_other', 255)->nullable();
            $table->longText('message')->nullable();
            $table->boolean('consent')->default(false);
            $table->string('attachment_storage_path', 500)->nullable();
            $table->string('attachment_original_name', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_enquiries');
    }
};
