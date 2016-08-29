<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Soft deletes
            $table->softDeletes();

            // Activation and verification
            $table->boolean('activated')->default(true);
            $table->boolean('verified')->default(false);
            $table->string('verification_token')->nullable();

            // Account type
            $table->string('account_type')->default('user');

            // User category
            $table->string('user_category')->nullable();
            $table->foreign('user_category')->references('alias')->on('user_categories');

            // Mollie customer id
            $table->string('mollie_customer_id')->unique()->nullable();

            // Name
            $table->dropColumn('name');

            $table->string('first_name');
            $table->string('name_prefix')->nullable();
            $table->string('last_name');

            // Address
            $table->string('address');
            $table->string('zip_code');
            $table->string('city');

            // Phone number
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Soft deletes
            $table->dropSoftDeletes();

            // Activation and verification
            $table->dropColumn('activated');
            $table->dropColumn('verified');
            $table->dropColumn('verification_token');

            // Account type
            $table->dropColumn('account_type');

            // User category
            $table->dropForeign(['user_category']);
            $table->dropColumn('user_category');

            // Mollie customer id
            $table->dropColumn('mollie_customer_id');

            // Name
            $table->string('name');

            $table->dropColumn('first_name');
            $table->dropColumn('name_prefix');
            $table->dropColumn('last_name');

            // Address
            $table->dropColumn('address');
            $table->dropColumn('zip_code');
            $table->dropColumn('city');

            // Phone number
            $table->dropColumn('phone_number');
        });
    }
}
