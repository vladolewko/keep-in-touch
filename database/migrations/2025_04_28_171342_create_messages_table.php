<?php

use App\Enums\MessageStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('email');
            $table->text('message');
            $table->enum('status', array_map(fn($status) => $status->value, MessageStatusEnum::cases()))->default(MessageStatusEnum::Pending->value);
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
