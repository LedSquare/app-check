<?php

use Aspect\Models\Stages\Shape\ShapeCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('a_shapes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ShapeCategory::class, 'a_shape_category_id')->index();
            $table->string('filepath');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shapes');
    }
};
