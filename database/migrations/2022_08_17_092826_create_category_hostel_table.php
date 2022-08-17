<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Hostel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_hostel', function (Blueprint $table): void {
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Hostel::class)->constrained()->cascadeOnDelete();

            $table->primary(['category_id', 'hostel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_hostel');
    }
};
