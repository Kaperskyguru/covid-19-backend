<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'email',
        'name',
        'website',
        'phone_number_please_include_country_code',
        'location_country',
        'what_category_do_you_fall_into',
        'stage_of_innovation',
        'category_of_innovation',
        'brief_description_of_innovation',
        'url_link',
        'open_source_url',
        'is_the_innovation_specific_to_a_particular_country',
        'if_yes_enter_country',
        'next_steps_support_needed_if_any',
        'general_comments',
        'kindly_select_a_category',
        'what_problem_were_you_looking_to_solve',
        'what_existing_platform_did_you_leverage_on_and_how',
        'what_did_it_cost_you',
        'url_link_to_the_platform',
        'are_there_anymore_bottle_necks_within_your_organisationprocess',
        'is_your_organisationprocess_specific_to_a_particular_country',
        'date_of_entry'
    ];
}