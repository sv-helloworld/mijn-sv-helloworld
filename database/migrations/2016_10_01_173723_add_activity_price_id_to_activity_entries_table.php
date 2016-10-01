<?php

use App\ActivityEntry;
use App\ActivityPrice;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityPriceIdToActivityEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_entries', function (Blueprint $table) {
            $table->integer('activity_price_id')->unsigned();
        });

        ActivityEntry::all()->each(function ($activity_entry) {
            $activity_price = ActivityPrice::where([
                'activity_id' => $activity_entry->activity_id,
                'amount' => $activity_entry->amount,
            ])->first();

            if ($activity_price) {
                $activity_entry->activity_price_id = $activity_price->id;
                $activity_entry->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_entries', function (Blueprint $table) {
            $table->dropColumn('activity_price_id');
        });
    }
}
