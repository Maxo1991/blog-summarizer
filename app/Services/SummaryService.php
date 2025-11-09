<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Summary;
use App\Exceptions\FetchException;
use App\Exceptions\ExtractException;
use App\Exceptions\SummarizeException;
use App\Repositories\SummaryRepositoryInterface;
use App\DTO\SummaryDTO;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SummaryService
{
    public function __construct(
        private readonly WebPageFetcher $fetcher,
        private readonly HtmlExtractor $extractor,
        private readonly OpenAISummarizerService $summarizer,
        private readonly SummaryRepositoryInterface $repository,
    ) {}

     /**
     * Creates and stores a summary for a given URL.
     *
     * Fetches the HTML content, extracts the main text, generates
     * a summary using OpenAI, and stores it in the database.
     *
     * @param SummaryDTO $dto 
     * @return Summary
     * @throws \Exception
     */
    public function createSummary(SummaryDTO $dto): Summary
    {
        $url = $dto->url;

        Log::info('Starting summarization process', ['url' => $url]);

        try {
            $html = $this->fetcher->fetch($url);
        } catch (\Exception $e) {
            throw new FetchException("Failed to fetch URL: $url", 0, $e);
        }

        try {
            $text = $this->extractor->extractText($html);
        } catch (\Exception $e) {
            throw new ExtractException("Failed to extract text from URL: $url", 0, $e);
        }
        
        try {
            $summary = $this->summarizer->summarize($text);
        } catch (\Exception $e) {
            throw new SummarizeException("Failed to summarize text for URL: $url", 0, $e);
        }

        $summaryRecord = $this->repository->create([
            'url' => $url,
            'summary' => $summary,
        ]);

        Log::info('Summary successfully created', [
            'summary_id' => $summaryRecord->id,
            'url' => $url,
        ]);

        return $summaryRecord;
    }

    /**
     * Retrieves paginated list of summaries ordered by creation date (descending).
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getSummaries(int $perPage = 3): LengthAwarePaginator
    {
        return $this->repository->getPaginated($perPage);
    }
}
