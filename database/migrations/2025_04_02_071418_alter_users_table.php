<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable()->after('name');
            $table->string('nickname')->unique()->after('id');
            $table->string('phone')->unique()->nullable()->after('email');
            $table->text('bio')->nullable()->after('phone');
            $table->text('address')->nullable()->after('bio');
            $table->boolean('is_private')->default(false)->after('address');
            $table->string('role')->default('user')->after('is_private');
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'nickname', 'phone', 'bio', 'address', 'is_private', 'role']);
            $table->dropSoftDeletes();
        });
    }
};
