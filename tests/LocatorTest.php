<?php

// SPDX-FileCopyrightText: 2004-2023 Ryan Parman, Sam Sneddon, Ryan McCue
// SPDX-License-Identifier: BSD-3-Clause

declare(strict_types=1);

use SimplePie\File;
use SimplePie\Tests\Fixtures\FileMock;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

/**
 * Tests for autodiscovery
 */
class LocatorTest extends PHPUnit\Framework\TestCase
{
    use ExpectPHPException;

    public static function feedmimetypes()
    {
        return [
            ['application/rss+xml'],
            ['application/rdf+xml'],
            ['text/rdf'],
            ['application/atom+xml'],
            ['text/xml'],
            ['application/xml'],
        ];
    }
    /**
     * @dataProvider feedmimetypes
     */
    public function testAutodiscoverOnFeed($mime)
    {
        $data = new FileMock('http://example.com/feed.xml');
        $data->headers['content-type'] = $mime;

        $locator = new SimplePie_Locator($data, 0, null, false);

        $registry = new SimplePie_Registry();
        $registry->register(File::class, FileMock::class);
        $locator->set_registry($registry);

        $feed = $locator->find(SIMPLEPIE_LOCATOR_ALL, $all);
        $this->assertSame($data, $feed);
    }

    public function testInvalidMIMEType()
    {
        $data = new FileMock('http://example.com/feed.xml');
        $data->headers['content-type'] = 'application/pdf';

        $locator = new SimplePie_Locator($data, 0, null, false);

        $registry = new SimplePie_Registry();
        $registry->register(File::class, FileMock::class);
        $locator->set_registry($registry);

        $feed = $locator->find(SIMPLEPIE_LOCATOR_ALL, $all);
        $this->assertSame(null, $feed);
    }

    public function testDirectNoDOM()
    {
        $data = new FileMock('http://example.com/feed.xml');

        $registry = new SimplePie_Registry();
        $locator = new SimplePie_Locator($data, 0, null, false);
        $locator->dom = null;
        $locator->set_registry($registry);

        $this->assertTrue($locator->is_feed($data));
        $this->assertSame($data, $locator->find(SIMPLEPIE_LOCATOR_ALL, $found));
    }

    public function testFailDiscoveryNoDOM()
    {
        $this->expectException('SimplePie_Exception');

        $data = new FileMock('http://example.com/feed.xml');
        $data->headers['content-type'] = 'text/html';
        $data->body = '<!DOCTYPE html><html><body>Hi!</body></html>';

        $registry = new SimplePie_Registry();
        $locator = new SimplePie_Locator($data, 0, null, false);
        $locator->dom = null;
        $locator->set_registry($registry);

        $this->assertFalse($locator->is_feed($data));
        $this->assertFalse($locator->find(SIMPLEPIE_LOCATOR_ALL, $found));
    }

    /**
     * Tests from Firefox
     *
     * Tests are used under the LGPL license, see file for license
     * information
     */
    public static function firefoxtests()
    {
        $data = [
            [new SimplePie_File(dirname(__FILE__) . '/data/fftests.html')]
        ];
        foreach ($data as &$row) {
            $row[0]->headers = ['content-type' => 'text/html'];
            $row[0]->method = SIMPLEPIE_FILE_SOURCE_REMOTE;
            $row[0]->url = 'http://example.com/';
        }

        return $data;
    }

    /**
     * @dataProvider firefoxtests
     */
    public function test_from_file($data)
    {
        $locator = new SimplePie_Locator($data, 0, null, false);

        $registry = new SimplePie_Registry();
        $registry->register(File::class, FileMock::class);
        $locator->set_registry($registry);

        $expected = [];
        $document = new DOMDocument();
        $document->loadHTML($data->body);
        $xpath = new DOMXPath($document);
        foreach ($xpath->query('//link') as $element) {
            $expected[] = 'http://example.com' . $element->getAttribute('href');
        }
        //$expected = SimplePie_Misc::get_element('link', $data->body);

        $feed = $locator->find(SIMPLEPIE_LOCATOR_ALL, $all);
        $this->assertFalse($locator->is_feed($data), 'HTML document not be a feed itself');
        $this->assertInstanceOf(FileMock::class, $feed);
        $success = array_filter($expected, [get_class(), 'filter_success']);

        $found = array_map([get_class(), 'map_url_file'], $all);
        $this->assertSame($success, $found);
    }

    protected static function filter_success($url)
    {
        return (stripos($url, 'bogus') === false);
    }

    protected static function map_url_file($file)
    {
        return $file->url;
    }
}
