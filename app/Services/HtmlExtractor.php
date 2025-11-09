<?php 

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class HtmlExtractor {

    /**
     * Extracts text content from HTML using a CSS selector.
     * By default, it extracts text from elements matching the selector '.__blog_article_body'.
     *
     * @param string $html
     * @param string $selector
     * @return string 
     */
    public function extractText(string $html, string $selector = '.__blog_article_body'): string
    {
        try {
            $crawler = new Crawler($html);
            $textArray = $crawler->filter($selector)->each(fn(Crawler $node) => $node->text());
            $cleanText = implode("\n", $textArray);

            Log::info('HtmlExtractor: extraction completed successfully', [
                'extracted_length' => strlen($cleanText),
            ]);

            return $cleanText;
        } catch (\Throwable $e) {
            Log::error('HtmlExtractor: extraction error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return '';
        }
    }
}
