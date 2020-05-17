<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use App\Imports\ReportsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    private const DURATION = 60;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $size = $request->size ? $request->size : 10;

        Cache::flush();
        $cachedReports = Cache::remember('reports-page-' . $page, self::DURATION, function () use ($size) {
            return Report::latest()->paginate($size);
        });

        if ($cachedReports)
            return ReportResource::collection($cachedReports);

        return response()->json([
            'statusCode' => '404',
            'message' => 'Reports not found',
        ]);
    }

    public function reportsByCategory(Request $request, $category)
    {
        $page = $request->page ? $request->page : 1;
        $size = $request->size ? $request->size : 10;

        $cachedReports = Cache::remember('reports-category-' . $category . '-page-' . $page, self::DURATION, function () use ($size, $category) {
            return Report::where('what_category_do_you_fall_into', $category)->latest()->paginate($size);
        });

        if ($cachedReports)
            return ReportResource::collection($cachedReports);

        return response()->json([
            'statusCode' => '404',
            'message' => 'Reports not found',
        ]);
    }

    public function reportsByInnovationCategory(Request $request, $category)
    {
        $page = $request->page ? $request->page : 1;
        $size = $request->size ? $request->size : 10;

        $cachedReports = Cache::remember('reports-category-' . $category . '-page-' . $page, self::DURATION, function () use ($size, $category) {
            return Report::where('category_of_innovation', $category)->latest()->paginate($size);
        });

        if ($cachedReports)
            return ReportResource::collection($cachedReports);

        return response()->json([
            'statusCode' => '404',
            'message' => 'Reports not found',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'phone' => ['required'],
            'country_location' => ['required']
        ]);

        $data = $this->resolveRequest($request);
        $report = Report::create($data);
        Cache::put('report-id-' . $report->id, $report, self::DURATION);
        if ($report) {
            return response()->json([
                'statusCode' => 201,
                'nessage' => 'Report created successfully',
                'data' => new ReportResource($report)
            ]);
        }

        return response()->json([
            'statusCode' => '422',
            'message' => 'Report not created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cachedReport = Cache::remember('report-id-' . $id, self::DURATION, function () use ($id) {
            return Report::find($id);
        });

        if ($cachedReport)
            return response()->json([
                'statusCode' => 200,
                'nessage' => 'Report retrieved successfully',
                'data' => new ReportResource($cachedReport)
            ]);

        return response()->json([
            'statusCode' => '404',
            'message' => 'Report not found',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->resolveRequest($request);
        $report = Cache::remember('report-id-' . $id, self::DURATION, function () use ($id) {
            return Report::find($id);
        });
        if ($report) {
            $report->update($data);
            Cache::forget('report-id-' . $report->id);
            Cache::put('report-id-' . $report->id, $report, self::DURATION);
            return new ReportResource($report);
        }
        return response()->json([
            'statusCode' => '404',
            'message' => 'Report not found',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Cache::remember('report-id-' . $id, self::DURATION, function () use ($id) {
            return Report::find($id);
        });

        if ($report) {
            $report->delete();
            Cache::forget('report-id-' . $report->id);
            return response()->json([
                'statusCode' => '200',
                'message' => 'Report deleted successfully',
            ]);
        }
        return response()->json([
            'statusCode' => '404',
            'message' => 'Report not found',
        ]);
    }


    public function importExcel(Request $request)
    {
        $request->validate([
            'reports' => ['required']
        ]);

        Excel::import(new ReportsImport, $request->file('reports'));

        return response()->json([
            'message' => 'Excel imported successfully',
            'total_number' => session('import_count'),
        ], 201);
    }

    private function resolveRequest(Request $request)
    {
        $mappedColumns =  [
            'email' => 'email',
            'name' => 'name',
            'website' => 'website',
            'phone_number_please_include_country_code' => 'phone',
            'location_country' => 'country_location',
            'what_category_do_you_fall_into' => 'your_category',
            'stage_of_innovation' => 'innovation_stage',
            'category_of_innovation' => 'innovation_category',
            'brief_description_of_innovation' => 'description',
            'url_link' => 'url_link',
            'open_source_url' => 'open_source_url',
            'is_the_innovation_specific_to_a_particular_country' => 'is_innovation_specific',
            'if_yes_enter_country' => 'country',
            'next_steps_support_needed_if_any' => 'support_needed',
            'general_comments' => 'general_comments',
            'kindly_select_a_category' => 'problem_category',
            'what_problem_were_you_looking_to_solve' => 'problems',
            'what_existing_platform_did_you_leverage_on_and_how' => 'existing_platform',
            'what_did_it_cost_you' => 'cost',
            'url_link_to_the_platform' => 'platform_url',
            'are_there_anymore_bottle_necks_within_your_organisationprocess' => 'bottlenecks',
            'is_your_organisationprocess_specific_to_a_particular_country' => 'is_organization_process_specific',
            'date_of_entry' => 'date_of_entry'
        ];

        $results = [];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $mappedColumns)) {
                $results[array_search($key, $mappedColumns)] = $value;
            }
        }

        // dd($results);
        return $results;
    }
}
