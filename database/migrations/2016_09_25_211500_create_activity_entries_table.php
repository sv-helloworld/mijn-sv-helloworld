<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_entries', function (Blueprint $table) {
            $table->increments('id');

            // General
            $table->integer('user_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->decimal('amount', 6, 2);
            $table->text('notes')->nullable();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('activity_id')->references('id')->on('activities');

            // Confirmed at
            $table->timestamp('confirmed_at')->nullable();

            // Properties
            $table->softDeletes();
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
        Schema::dropIfExists('activity_entries');
    }
}
