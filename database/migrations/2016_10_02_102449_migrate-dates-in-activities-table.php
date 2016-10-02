<?php

use App\Activity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateDatesInActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            Activity::all()->each(function ($activity) {
                $activity->available_from = $activity->apply_after;
                $activity->available_to = $activity->apply_before;
                $activity->save();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            Activity::all()->each(function ($activity) {
                $activity->apply_after = $activity->available_from;
                $activity->apply_before = $activity->available_to;
                $activity->save();
            });
        });
    }
}
