<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTodoNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_notifications', function (Blueprint $table) {
            $table->id();

            $table->string('notificationable_type')->index();
            $table->unsignedBigInteger('notificationable_id')->index();
            $table->longText('message')->nullable();
            $table->timestamp('email_sent_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('todo_notifications');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
