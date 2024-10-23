<?php

namespace App\Jobs;

use App\Enums\JobStatusEnum;
use App\Models\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $jobId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($job = Job::find($this->jobId)) {
            $job->status = JobStatusEnum::PROCESSING->value;
            $job->save();
            $content = [];
            try {
                foreach ($job->urls as $url) {
                    $content[] = $this->getScrapedContent($url, $job->selectors);
                }
            } catch (\Exception $exception) {
                Log::error('Fail to scrape url', ['url' => $url, 'exception' => $exception->getMessage()]);
                $job->status = JobStatusEnum::FAILED->value;
                $job->save();
                return;
            }

            $job->content = $content;
            $job->status = JobStatusEnum::COMPLETED->value;
            $job->save();
        }
    }

    private function getScrapedContent(string $url, array $selectors = [])
    {
        //implement scraping here
        throw new \Exception('Fail to get scraped url');
    }
}
