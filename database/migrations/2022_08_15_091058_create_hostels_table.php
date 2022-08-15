<?php

declare(strict_types=1);

use App\Models\User;
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
        Schema::create('hostels', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('status');
            $table->string('address');
            $table->float('latitude', 10, 8);
            $table->float('longitude', 11, 8);
            $table->integer('size'); // square meters
            $table->unsignedBigInteger('monthly_price');
            $table->timestamps();

            $table->foreignIdFor(User::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostels');
    }
};
