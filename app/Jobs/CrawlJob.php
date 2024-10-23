<?php

namespace App\Jobs;

use App\Enums\JobStatusEnum;
use App\Models\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class CrawlJob implements ShouldQueue
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
        if (!$job = Job::find($this->jobId)) {
            throw new \Exception('Cant load job', ['id' => $this->jobId]);
        }

        $job->status = JobStatusEnum::PROCESSING->value;
        $job->save();
        $content = [];
        try {
            foreach ($job->urls as $url) {
                Log::debug('Scrapping url', ['url' => $url]);
                $content = array_merge($content, $this->getScrapedContent($url, $job->selectors));
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

    private function getScrapedContent(string $url, string $selectors = ''): array
    {
        $html = '';
        try {
            $html = Http::timeout(5)->get($url)->body();
        } catch(\Illuminate\Http\Client\ConnectionException|\Exception $exception) {
            Log::error('Fail to get url', ['url' => $url, 'exception' => $exception->getMessage()]);
        }
        $crawler = new Crawler($html);

        if (!$html) {
            throw new \Exception('Fail to get scraped content.');
        }

        return $crawler->filter($selectors)->each(function ($node) {
            return $node->text();
        });
    }
}
