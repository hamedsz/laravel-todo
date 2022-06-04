<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTodoLabelTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_label_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('label_id')->index();
            $table->unsignedBigInteger('task_id')->index();
            $table->timestamps();

            $table->foreign('label_id')->references('id')->on('todo_labels');
            $table->foreign('task_id')->references('id')->on('todo_tasks');
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
        Schema::dropIfExists('todo_label_task');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
