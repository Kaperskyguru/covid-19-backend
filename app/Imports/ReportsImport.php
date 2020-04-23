<?php
namespace App\Imports;

use App\User;
use App\Report;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;

class ReportsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithCustomChunkSize
{
    public function collection(Collection $rows)
    {
        $reports = [];
        foreach ($rows as $row) {
            $report = Report::create([
                'email' => $row['email'],
                'name' => $row['name'],
                'website' => $row['website'],
                'phone_number_please_include_country_code' => $row['phone_number_please_include_country_code'],
                'location_country' => $row['location_country'],
                'what_category_do_you_fall_into'  => $row['what_category_do_you_fall_into'],
                'stage_of_innovation' => $row['stage_of_innovation'],
                'category_of_innovation' => $row['category_of_innovation'],
                'brief_description_of_innovation' => $row['brief_description_of_innovation'],
                'url_link'=> $row['url_link'],
                'open_source_url'=> $row['open_source_url_if_the_project_is_an_open_source_project_you_will_need_the_link_to_the_source_code_eg_httpsgithubcomcovid_projectionscovid_data_model'],
                'is_the_innovation_specific_to_a_particular_country'=> $row['is_the_innovation_specific_to_a_particular_country'],
                'if_yes_enter_country'=> $row['if_yes_enter_country'],
                'next_steps_support_needed_if_any'=> $row['next_steps_support_needed_if_any'],
                'general_comments'=> $row['general_comments'],
                'kindly_select_a_category'=> $row['kindly_select_a_category'],
                'what_problem_were_you_looking_to_solve'=> $row['what_problem_were_you_looking_to_solve'],
                'what_existing_platform_did_you_leverage_on_and_how'=> $row['what_existing_platform_did_you_leverage_on_and_how'],
                'what_did_it_cost_you'=> $row['what_did_it_cost_you'],
                'url_link_to_the_platform'=> $row['url_link_to_the_platform'],
                'are_there_anymore_bottle_necks_within_your_organisationprocess'=> $row['are_there_anymore_bottle_necks_within_your_organisationprocess'],
                'is_your_organisationprocess_specific_to_a_particular_country'=> $row['is_your_organisationprocess_specific_to_a_particular_country'],
                'date_of_entry' => $this->formatDateExcel($row['timestamp'])
            ]);

            array_push($reports, $report);
        }
        session()->put('import_count', count($reports));
        return $reports;
    }

    protected function formatDateExcel($date)
    {
        if (gettype($date) === 'double') {
            $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
            return $excelDate->format('n/j/Y');
        }
        return $date;
    }

    public function batchSize(): int
    {
        return 500;
    }

    /**
     * {@inheritdoc}
     */
    public function chunkSize(): int
    {
        return 500;
    }
}
