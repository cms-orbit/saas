<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('container_slug')->index();
            $table->string('theme')->nullable();
            $table->json('data')->nullable(); // For additional configuration (DB info, etc.)
            $table->string('status')->default('active'); // draft, active, suspended, archived
            $table->timestamps();
        });

        Schema::create('route_endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // domain, subdomain, path
            $table->string('value')->unique();
            $table->morphs('endpointable'); // Instance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_endpoints');
        Schema::dropIfExists('instances');
    }
};
