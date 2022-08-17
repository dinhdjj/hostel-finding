<?php

declare(strict_types=1);

use App\Models\Comment;
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
        Schema::create('comments', function (Blueprint $table): void {
            $table->id();
            $table->string('content');
            $table->timestamps();
            $table->foreignIdFor(Comment::class, 'parent_id')->nullable()->constrained('comments');
            $table->foreignIdFor(User::class, 'owner_id')->constrained('users');
            $table->foreignIdFor(Hostel::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
