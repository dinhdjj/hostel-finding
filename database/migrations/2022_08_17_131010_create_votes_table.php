<?php

declare(strict_types=1);

use App\Models\Hostel;
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
        Schema::create('votes', function (Blueprint $table): void {
            $table->id();
            $table->float('score', 2, 1)->max(1); // 1.0 = 100%
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'owner_id')->constrained('users');
            $table->foreignIdFor(Hostel::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
