<?php

namespace Threecolts\Phptest;

class UrlCounter
{
    /**
     * This function counts how many unique normalized valid URLs were passed to the function
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ['https://example.com']
     * output: 1
     *
     * Notes:
     *  - assume none of the URLs have authentication information (username, password).
     *
     * Normalized URL:
     *  - process in which a URL is modified and standardized: https://en.wikipedia.org/wiki/URL_normalization
     *
     *    For example.
     *    These 2 urls are the same:
     *    input: ["https://example.com", "https://example.com/"]
     *    output: 1
     *
     *    These 2 are not the same:
     *    input: ["https://example.com", "http://example.com"]
     *    output 2
     *
     *    These 2 are the same:
     *    input: ["https://example.com?", "https://example.com"]
     *    output: 1
     *
     *    These 2 are the same:
     *    input: ["https://example.com?a=1&b=2", "https://example.com?b=2&a=1"]
     *    output: 1
     */

    /* @var $urls : string[] */
    public function countUniqueUrls($urls): int
    {
        if (!$urls) {
            throw new \Exception("No urls provided");
        }

        $normalizedUrls = [];

        foreach ($urls as $url) {
            $normalizedUrls[] = $this->normaliseUrl($url);
        }

        // Get unique URLs
        $uniqueUrls = array_unique($normalizedUrls);
        return count($uniqueUrls);
    }

    /**
     * This function counts how many unique normalized valid URLs were passed to the function per top level domain
     *
     * A top level domain is a domain in the form of example.com. Assume all top level domains end in .com
     * subdomain.example.com is not a top level domain.
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ["https://example.com"]
     * output: ["example.com" => 1]
     *
     * input: ["https://example.com", "https://subdomain.example.com"]
     * output: ["example.com" => 2]
     *
     */
    /* @var $urls : string[] */
    public function countUniqueUrlsPerTopLevelDomain($urls)
    {
        $topLevelDomains = [];

        foreach ($urls as $url) {
            $parsedUrl = parse_url($url);
            if ($parsedUrl && isset($parsedUrl['host'])) {
                $hostParts = explode('.', $parsedUrl['host']);
                if (count($hostParts) > 1) {
                    // Extract the Top Level Domain
                    $topLevelDomain = implode('.', array_slice($hostParts, -2));
                    $topLevelDomains[$topLevelDomain] = true;
                }
            }
        }

        return count($topLevelDomains);
    }

    /**
     * Remove any leading slashes or get params from URL
     * @var $url string
     */
    private function normaliseUrl($url): string
    {
        $parsedUrl = parse_url($url);

        $httpScheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : 'http';

        $host = $parsedUrl['host'] ?? '';
        $path = isset($parsedUrl['path']) ? rtrim($parsedUrl['path'], '/') : '';
        return $httpScheme . '://' . $host;
    }
}