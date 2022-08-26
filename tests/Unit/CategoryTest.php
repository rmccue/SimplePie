<?php
/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2022, Ryan Parman, Sam Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @copyright 2004-2022 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace SimplePie\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SimplePie\Category;
use SimplePie\Item;
use SimplePie\SimplePie;

class CategoryTest extends TestCase
{
    public function testNamespacedClassExists()
    {
        $this->assertTrue(class_exists('SimplePie\Category'));
    }

    public function testClassExists()
    {
        $this->assertTrue(class_exists('SimplePie_Category'));
    }

    public function getFeedCategoryLableDataProvider()
    {
        return [
            'Test Atom 0.3 DC 1.0 Subject' => [
<<<EOT
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<dc:subject>Feed Category</dc:subject>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test Atom 0.3 DC 1.1 Subject' => [
<<<EOT
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<dc:subject>Feed Category</dc:subject>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test Atom 1.0 DC 1.0 Subject' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<dc:subject>Feed Category</dc:subject>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test Atom 1.0 DC 1.1 Subject' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<dc:subject>Feed Category</dc:subject>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test Atom 1.0 Category Label' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<category label="Feed Category"/>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test Atom 1.0 Category Term' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<category term="Feed Category"/>
</feed>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.90 Atom 1.0 Category Label' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.90 Atom 1.0 Category Term' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.90 DC 1.0 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.90 DC 1.1 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Netscape Atom 1.0 Category Label' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Netscape Atom 1.0 Category Term' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Netscape DC 1.0 Subject' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Netscape DC 1.1 Subject' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Userland Atom 1.0 Category Label' => [
<<<EOT
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Userland Atom 1.0 Category Term' => [
<<<EOT
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Userland DC 1.0 Subject' => [
<<<EOT
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.91-Userland DC 1.1 Subject' => [
<<<EOT
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.92 Atom 1.0 Category Label' => [
<<<EOT
<rss version="0.92" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.92 Atom 1.0 Category Term' => [
<<<EOT
<rss version="0.92" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.92 DC 1.0 Subject' => [
<<<EOT
<rss version="0.92" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 0.92 DC 1.1 Subject' => [
<<<EOT
<rss version="0.92" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 1.0 Atom 1.0 Category Label' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 1.0 Atom 1.0 Category Term' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 1.0 DC 1.0 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 1.0 DC 1.1 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rdf:RDF>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 2.0 Atom 1.0 Category Label' => [
<<<EOT
<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category label="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 2.0 Atom 1.0 Category Term' => [
<<<EOT
<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:category term="Feed Category"/>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 2.0 DC 1.0 Subject' => [
<<<EOT
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 2.0 DC 1.1 Subject' => [
<<<EOT
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:subject>Feed Category</dc:subject>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            'Test RSS 2.0 Category' => [
<<<EOT
<rss version="2.0">
	<channel>
		<category>Feed Category</category>
	</channel>
</rss>
EOT
                ,
                'Feed Category',
            ],
            // Test Bugs
            'Test Bug 21 Test 0' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<category term="Example category"/>
</feed>
EOT
                ,
                'Example category',
            ],
        ];
    }

    /**
     * @dataProvider getFeedCategoryLableDataProvider
     */
    public function test_get_label_from_feed_category($data, $expected)
    {
        $feed = new SimplePie();
        $feed->set_raw_data($data);
        $feed->enable_cache(false);
        $feed->init();

        $category = $feed->get_category();
        $this->assertInstanceOf(Category::class, $category);

        $this->assertSame($expected, $category->get_label());
    }

    public function getItemCategoryLableDataProvider()
    {
        return [
            'Test Atom 0.3 DC 1.0 Subject' => [
<<<EOT
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<entry>
		<dc:subject>Item Category</dc:subject>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Atom 0.3 DC 1.1 Subject' => [
<<<EOT
<feed version="0.3" xmlns="http://purl.org/atom/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<entry>
		<dc:subject>Item Category</dc:subject>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Atom 1.0 DC 1.0 Subject' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<entry>
		<dc:subject>Item Category</dc:subject>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Atom 1.0 DC 1.1 Subject' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<entry>
		<dc:subject>Item Category</dc:subject>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Atom 1.0 Category Label' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<entry>
		<category label="Item Category"/>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Atom 1.0 Category Term' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<entry>
		<category term="Item Category"/>
	</entry>
</feed>
EOT
                ,
                'Item Category',
            ],
            'Test Bug 21 Test 0' => [
<<<EOT
<feed xmlns="http://www.w3.org/2005/Atom">
	<entry>
		<category term="Example category"/>
	</entry>
</feed>
EOT
                ,
                'Example category',
            ],
            'Test RSS 0.90 Atom 1.0 Category Label' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:a="http://www.w3.org/2005/Atom">
	<item>
		<a:category label="Item Category"/>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.90 Atom 1.0 Category Term' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:a="http://www.w3.org/2005/Atom">
	<item>
		<a:category term="Item Category"/>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.90 DC 1.0 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<item>
		<dc:subject>Item Category</dc:subject>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.90 DC 1.1 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<item>
		<dc:subject>Item Category</dc:subject>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Netscape Atom 1.0 Category Label' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category label="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Netscape Atom 1.0 Category Term' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category term="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Netscape DC 1.0 Subject' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Netscape DC 1.1 Subject' => [
<<<EOT
<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Userland Atom 1.0 Category Label' => [
<<<EOT
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category label="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Userland Atom 1.0 Category Term' => [
<<<EOT
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category term="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Userland DC 1.0 Subject' => [
<<<EOT
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.91-Userland DC 1.1 Subject' => [
<<<EOT
<rss version="0.91" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.92 Atom 1.0 Category Label' => [
<<<EOT
<rss version="0.92" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category label="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.92 Atom 1.0 Category Term' => [
<<<EOT
<rss version="0.92" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category term="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.92 Category' => [
<<<EOT
<rss version="0.92">
	<channel>
		<item>
			<category>Item Category</category>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.92 DC 1.0 Subject' => [
<<<EOT
<rss version="0.92" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 0.92 DC 1.1 Subject' => [
<<<EOT
<rss version="0.92" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 1.0 Atom 1.0 Category Label' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:a="http://www.w3.org/2005/Atom">
	<item>
		<a:category label="Item Category"/>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 1.0 Atom 1.0 Category Term' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:a="http://www.w3.org/2005/Atom">
	<item>
		<a:category term="Item Category"/>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 1.0 DC 1.0 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<item>
		<dc:subject>Item Category</dc:subject>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 1.0 DC 1.1 Subject' => [
<<<EOT
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<item>
		<dc:subject>Item Category</dc:subject>
	</item>
</rdf:RDF>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 2.0 Atom 1.0 Category Label' => [
<<<EOT
<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category label="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 2.0 Atom 1.0 Category Term' => [
<<<EOT
<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<item>
			<a:category term="Item Category"/>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 2.0 Category' => [
<<<EOT
<rss version="2.0">
	<channel>
		<item>
			<category>Item Category</category>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 2.0 DC 1.0 Subject' => [
<<<EOT
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
            'Test RSS 2.0 DC 1.1 Subject' => [
<<<EOT
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<item>
			<dc:subject>Item Category</dc:subject>
		</item>
	</channel>
</rss>
EOT
                ,
                'Item Category',
            ],
        ];
    }

    /**
     * @dataProvider getItemCategoryLableDataProvider
     */
    public function test_get_label_from_item_category($data, $expected)
    {
        $feed = new SimplePie();
        $feed->set_raw_data($data);
        $feed->enable_cache(false);
        $feed->init();

        $item = $feed->get_item(0);
        $this->assertInstanceOf(Item::class, $item);

        $category = $item->get_category();
        $this->assertInstanceOf(Category::class, $category);

        $this->assertSame($expected, $category->get_label());
    }
}
