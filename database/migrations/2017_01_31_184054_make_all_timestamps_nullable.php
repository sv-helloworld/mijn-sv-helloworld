<?php

use App\Activity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAllTimestampsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Activities
        Schema::table('activities', function (Blueprint $table) {
            $table->timestamp('starts_at_new')->nullable();
            $table->timestamp('ends_at_new')->nullable();
        });

        Activity::all()->each(function ($activity) {
            $activity->starts_at_new = $activity->starts_at;
            $activity->ends_at_new = $activity->ends_at;
            $activity->save();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');

            $table->renameColumn('starts_at_new', 'starts_at');
            $table->renameColumn('ends_at_new', 'ends_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
