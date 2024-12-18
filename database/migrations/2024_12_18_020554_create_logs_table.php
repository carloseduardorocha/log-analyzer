<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('consumer_id');
            $table->unsignedBigInteger('service_id');
            $table->string('client_ip', 45)->nullable();
            $table->string('request_method', 10)->nullable();
            $table->string('request_uri', 255)->nullable();
            $table->unsignedInteger('response_status')->nullable();
            $table->unsignedInteger('proxy_latency');
            $table->unsignedInteger('gateway_latency');
            $table->unsignedInteger('request_latency');
            $table->timestamp('started_at')->nullable();
            $table->timestamps();

            $table->foreign('consumer_id')->references('id')->on('consumers')->onDelete('no action');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
