<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Resources\JobResource;
use App\Jobs\CrawlJob;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'index' => 'index'
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobRequest $request)
    {
        $job = new Job();
        $job->urls = $request->get('urls');
        $job->selectors = $request->get('selectors');
        $job->save();

        CrawlJob::dispatch($job->getPrimaryKey());

        return new JobResource($job);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$job = Job::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return new JobResource($job);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($job = Job::find($id)) {
            $job->delete();
        }
        return response()->json([], 204);
    }
}
