<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('speed_test_logs', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('operation'); // Insert, Edit, Delete, etc.
            $table->integer('num_records'); // Number of records affected
            $table->decimal('execution_time', 8, 6); // Time taken for operation
            $table->timestamps(); // Created at and updated at
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speed_test_logs');
    }
};
