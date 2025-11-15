<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // attendance, receipt, schedule, etc
            $table->string('title');
            $table->text('message');
            $table->string('icon')->default('bell');
            $table->string('color')->default('blue'); // blue, yellow, orange, red, green
            $table->string('url')->nullable();
            $table->morphs('notifiable'); // polymorphic relation untuk user atau role (sudah include index)
            $table->unsignedBigInteger('related_id')->nullable(); // ID dari attendance, receipt, dll
            $table->string('related_type')->nullable(); // Attendance, Receipt, dll
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
