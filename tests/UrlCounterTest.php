<?php

use Threecolts\Phptest\UrlCounter;
use PHPUnit\Framework\TestCase;

class UrlCounterTest extends TestCase
{
    private $urlCounter;

    protected function setUp(): void
    {
        // Create an instance of UrlCounter for each test
        $this->urlCounter = new UrlCounter();
    }

    public function testCountUniqueUrls()
    {
        // 6 Urls containing 2 unique entries according to our counter
        $urls = [
            "https://example.com/path/",
            "http://example.com/path",
            "https://example.com/path",
            "http://example.com/path/",
            "https://example.com/path/subpath",
            "http://example.com/path/subpath/",
        ];
        $result = $this->urlCounter->countUniqueUrls($urls);
        $this->assertEquals(2, $result);

        // these 2 URLs are the same
        $urls = [
            "https://example.com/",
            "https://example.com"
        ];
        $result = $this->urlCounter->countUniqueUrls($urls);
        $this->assertEquals(1, $result);

        //  These 2 are not the same
        $urls = [
            "https://example.com",
            "http://example.com"
        ];
        $result = $this->urlCounter->countUniqueUrls($urls);
        $this->assertEquals(2, $result);

        // these 2 URLs are the same
        $urls = [
            "https://example.com",
            "https://example.com?"
        ];
        $result = $this->urlCounter->countUniqueUrls($urls);
        $this->assertEquals(1, $result);

        // these 2 URLs are the same
        $urls = [
            "https://example.com?a=1&b=2",
            "https://example.com?b=2&a=1"
        ];
        $result = $this->urlCounter->countUniqueUrls($urls);
        $this->assertEquals(1, $result);
    }

    public function testCountUniqueUrlsPerTopLevelDomain(): void
    {
        // 6 Urls containing 1 unique TLD entries according to our counter
        $urls = [
            "https://example.com/path/",
            "http://example.com/path",
            "https://example.com/path",
            "http://example.com/path/",
            "https://example.com/path/subpath",
            "http://about.example.com/path/subpath/",
        ];
        $result = $this->urlCounter->countUniqueUrlsPerTopLevelDomain($urls);
        $this->assertEquals(1, $result);

        // 6 Urls containing 2 unique TLD entries according to our counter
        $urls = [
            "https://example.com/path/",
            "http://x-ample.com/path",
            "https://example.com/path",
            "http://example.com/path/",
            "https://ample-of-the-ex.com/path/subpath",
            "http://about.example.com/path/subpath/",
        ];
        $result = $this->urlCounter->countUniqueUrlsPerTopLevelDomain($urls);
        $this->assertEquals(3, $result);
    }
}
