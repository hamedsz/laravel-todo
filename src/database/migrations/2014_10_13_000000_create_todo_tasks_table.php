<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTodoTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();

            $table->enum('status', [
                'open',
                'close',
            ]);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('todo_users');
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
        Schema::dropIfExists('todo_tasks');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
