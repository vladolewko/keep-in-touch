<?php

use App\Enums\NotificationTopicEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sent_to_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('topic', NotificationTopicEnum::values())->default(NotificationTopicEnum::WARNING->value);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
