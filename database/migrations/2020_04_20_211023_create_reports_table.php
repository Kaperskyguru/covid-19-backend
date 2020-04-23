<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('website')->nullable();
            $table->string('phone_number_please_include_country_code')->nullable();
            $table->string('location_country')->nullable();
            $table->string('what_category_do_you_fall_into')->nullable();
            $table->string('stage_of_innovation')->nullable();
            $table->string('category_of_innovation')->nullable();
            $table->text('brief_description_of_innovation')->nullable();
            $table->string('url_link')->nullable();
            $table->text('open_source_url')->nullable();
            $table->string('is_the_innovation_specific_to_a_particular_country')->nullable();
            $table->string('if_yes_enter_country')->nullable();
            $table->text('next_steps_support_needed_if_any')->nullable();
            $table->text('general_comments')->nullable();
            $table->string('kindly_select_a_category')->nullable();
            $table->text('what_problem_were_you_looking_to_solve')->nullable();
            $table->string('what_existing_platform_did_you_leverage_on_and_how')->nullable();
            $table->string('what_did_it_cost_you')->nullable();
            $table->string('url_link_to_the_platform')->nullable();
            $table->text('are_there_anymore_bottle_necks_within_your_organisationprocess')->nullable();
            $table->string('is_your_organisationprocess_specific_to_a_particular_country')->nullable();
            $table->string('date_of_entry')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
