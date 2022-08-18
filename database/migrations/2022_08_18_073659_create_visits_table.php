<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create(config('visit.table'), function (Blueprint $table): void {
            $table->id();

            $table->json('languages');
            $table->string('device');
            $table->string('platform');
            $table->string('browser');
            $table->ipAddress('ip');
            $table->morphs('visitable');
            $table->nullableMorphs('visitor');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('visit.table'));
    }
};
