<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SummaryService;
use App\DTO\SummaryDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class SummarizerController extends Controller
{
    public function __construct(
        private readonly SummaryService $summaryService,
    ) {
    }

    /**
     * Summarize the content of a given URL and persist it.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function summarize(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url|unique:summaries,url',
        ], [
            'url.unique' => 'This URL already exists in the database.',
        ]);

        $url = $request->input('url');

        $dto = new SummaryDto(
            $url,
            ''
        );

        try {
            $summary = $this->summaryService->createSummary($dto);

            return response()->json(['summary' => $summary->summary]);
        } catch (\Exception $e) {
            Log::error('SummarizerController error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $summaries = $this->summaryService->getSummaries();

            return response()->json($summaries);
        } catch (\Exception $e) {
            Log::error('Failed to fetch summaries', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Failed to load summaries'], 500);
        }
    }
}
