<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'email'                                                          => (string) $this->email,
            'name'                                                           => (string) $this->name,
            'website'                                                        => (string) $this->website,
            'phone_number_please_include_country_code'                       => (string) $this->phone_number_please_include_country_code,
            'location_country'                                               => (string) $this->location_country,
            'what_category_do_you_fall_into'                                 => (string) $this->what_category_do_you_fall_into,
            'stage_of_innovation'                                            => (string) $this->stage_of_innovation,
            'category_of_innovation'                                         => (string) $this->category_of_innovation,
            'brief_description_of_innovation'                                => (string) $this->brief_description_of_innovation,
            'url_link'                                                       => (string) $this->url_link,
            'open_source_url'                                                => (string) $this->open_source_url,
            'is_the_innovation_specific_to_a_particular_country'             => (string) $this->is_the_innovation_specific_to_a_particular_country,
            'if_yes_enter_country'                                           => (string) $this->if_yes_enter_country,
            'next_steps_support_needed_if_any'                               => (string) $this->next_steps_support_needed_if_any,
            'general_comments'                                               => (string) $this->general_comments,
            'kindly_select_a_category'                                       => (string) $this->kindly_select_a_category,
            'what_problem_were_you_looking_to_solve'                         => (string) $this->what_problem_were_you_looking_to_solve,
            'what_existing_platform_did_you_leverage_on_and_how'             => (string) $this->what_existing_platform_did_you_leverage_on_and_how,
            'what_did_it_cost_you'                                           => (string) $this->what_did_it_cost_you,
            'url_link_to_the_platform'                                       => (string) $this->url_link_to_the_platform,
            'are_there_anymore_bottle_necks_within_your_organisationprocess' => (string) $this->are_there_anymore_bottle_necks_within_your_organisationprocess,
            'is_your_organisationprocess_specific_to_a_particular_country'   => (string) $this->is_your_organisationprocess_specific_to_a_particular_country,
            'date_of_entry'                                                  => (string) $this->date_of_entry,
            'date_created' => (string) $this->created_at
        ];
    }
}