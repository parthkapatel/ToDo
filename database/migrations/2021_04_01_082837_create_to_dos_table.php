<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToDosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->date("start_date")->nullable();
            $table->date("due_date")->nullable();
            $table->text("notes")->nullable();
            $table->integer("mark_as_read")->default(0);
            $table->integer("mark_as_favorite")->default(0);
            $table->integer("task_order")->default(0);
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
        Schema::dropIfExists('todos');
    }
}
