<?php

use App\ActivityEntry;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAmountFromActivityEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_entries', function (Blueprint $table) {
            $table->dropColumn('amount');
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
            $table->decimal('amount', 6, 2);
        });

        ActivityEntry::all()->each(function ($activity_entry) {
            if ($activity_entry->activity_price) {
                $activity_entry->amount = $activity_entry->activity_price->amount;
                $activity_entry->save();
            }
        });
    }
}
