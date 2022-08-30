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

namespace SimplePie\Tests\Unit\Cache;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheException;
use Psr\SimpleCache\CacheInterface;
use SimplePie\Cache\Psr16;
use SimplePie\Tests\Fixtures\Exception\Psr16CacheException;

class Psr16Test extends TestCase
{
    public function testImplementationIsGloballyStored()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You must set an implementation of `Psr\SimpleCache\CacheInterface` via `SimplePie\SimplePie::set_psr16_cache()` first.');

        new Psr16('location', 'name', 'type');
    }

    public function testSaveReturnsTrue()
    {
        $data = [];
        $psr16 = $this->createMock(CacheInterface::class);
        $psr16->expects($this->exactly(2))->method('set')->withConsecutive(
            [
                '18bb0a0a94b49eda35e8944672d60a1474ff2895524f0e56c3752c1e0f7853e7',
                $data,
                3600,
            ],
            [
                '18bb0a0a94b49eda35e8944672d60a1474ff2895524f0e56c3752c1e0f7853e7_mtime'
            ]
        );

        Psr16::store_psr16_cache($psr16);
        $cache = new Psr16('location', 'name', 'type');

        $this->assertTrue($cache->save($data));
    }

    public function testSaveReturnsFalse()
    {
        $e = $this->createMock(CacheException::class);

        if (version_compare(PHP_VERSION, '7.0', '<')) {
            $e = new Psr16CacheException();
        } else if (version_compare(PHP_VERSION, '8.0', '<')) {
            $e = new class extends \Exception implements CacheException {};
        }

        $data = [];
        $psr16 = $this->createMock(CacheInterface::class);
        $psr16->expects($this->once())->method('set')->willThrowException($e);

        Psr16::store_psr16_cache($psr16);
        $cache = new Psr16('location', 'name', 'type');

        $this->assertFalse($cache->save($data));
    }

    public function testLoadReturnsData()
    {
        $data = [];
        $psr16 = $this->createMock(CacheInterface::class);
        $psr16->expects($this->once())->method('get')->willReturn($data);

        Psr16::store_psr16_cache($psr16);
        $cache = new Psr16('location', 'name', 'type');

        $this->assertSame($data, $cache->load());
    }

    public function testLoadReturnsFalse()
    {
        $psr16 = $this->createMock(CacheInterface::class);
        $psr16->expects($this->once())->method('get')->willReturnCallback(function($a, $b) {
            return $b;
        });

        Psr16::store_psr16_cache($psr16);
        $cache = new Psr16('location', 'name', 'type');

        $this->assertSame(false, $cache->load());
    }
}
