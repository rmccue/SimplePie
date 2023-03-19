<?php

// SPDX-FileCopyrightText: 2004-2023 Ryan Parman, Sam Sneddon, Ryan McCue
// SPDX-License-Identifier: BSD-3-Clause

declare(strict_types=1);

/**
 * Encoding tests for SimplePie_Misc::change_encoding() and SimplePie_Misc::encoding()
 */
class EncodingTest extends PHPUnit\Framework\TestCase
{
    /**#@+
     * UTF-8 methods
     */
    /**
     * Provider for the convert toUTF8* tests
     */
    public static function toUTF8()
    {
        return [
            ['A', 'A', 'ASCII'],
            ["\xa1\xdb", "\xe2\x88\x9e", 'Big5'],
            ["\xa1\xe7", "\xe2\x88\x9e", 'EUC-JP'],
            ["\xa1\xde", "\xe2\x88\x9e", 'GBK'],
            ["\x81\x87", "\xe2\x88\x9e", 'Shift_JIS'],
            ["\x2b\x49\x68\x34\x2d", "\xe2\x88\x9e", 'UTF-7'],
            ["\xfe\xff\x22\x1e", "\xe2\x88\x9e", 'UTF-16'],
            ["\xff\xfe\x1e\x22", "\xe2\x88\x9e", 'UTF-16'],
            ["\x22\x1e", "\xe2\x88\x9e", 'UTF-16BE'],
            ["\x1e\x22", "\xe2\x88\x9e", 'UTF-16LE'],
        ];
    }

    /**
     * Special cases with mbstring handling
     */
    public static function toUTF8_mbstring()
    {
        return [
            ["\xa1\xc4", "\xe2\x88\x9e", 'EUC-KR'],
        ];
    }

    /**
     * Special cases with iconv handling
     */
    public static function toUTF8_iconv()
    {
        return [
            ["\xfe\xff\x22\x1e", "\xe2\x88\x9e", 'UTF-16'],
        ];
    }

    /**
     * Special cases with uconverter handling
     */
    public static function toUTF8_uconverter()
    {
        return [
            ["\xfe\xff\x22\x1e", "\xe2\x88\x9e", 'UTF-16'],
        ];
    }

    /**
     * Convert * to UTF-8
     *
     * @dataProvider toUTF8
     */
    public function test_convert_UTF8($input, $expected, $encoding)
    {
        $encoding = SimplePie_Misc::encoding($encoding);
        $this->assertSameBin2Hex($expected, SimplePie_Misc::change_encoding($input, $encoding, 'UTF-8'));
    }

    /**
     * Convert * to UTF-8 using mbstring
     *
     * Special cases only
     * @dataProvider toUTF8_mbstring
     */
    public function test_convert_UTF8_mbstring($input, $expected, $encoding)
    {
        $encoding = SimplePie_Misc::encoding($encoding);
        if (extension_loaded('mbstring')) {
            $this->assertSameBin2Hex($expected, Mock_Misc::change_encoding_mbstring($input, $encoding, 'UTF-8'));
        }
    }

    /**
     * Convert * to UTF-8 using iconv
     *
     * Special cases only
     * @dataProvider toUTF8_iconv
     */
    public function test_convert_UTF8_iconv($input, $expected, $encoding)
    {
        $encoding = SimplePie_Misc::encoding($encoding);
        if (extension_loaded('iconv')) {
            $this->assertSameBin2Hex($expected, Mock_Misc::change_encoding_iconv($input, $encoding, 'UTF-8'));
        }
    }

    /**
     * Convert * to UTF-8 using UConverter
     *
     * Special cases only
     * @dataProvider toUTF8_uconverter
     */
    public function test_convert_UTF8_uconverter($input, $expected, $encoding)
    {
        $encoding = SimplePie_Misc::encoding($encoding);
        if (extension_loaded('intl')) {
            $this->assertSameBin2Hex($expected, Mock_Misc::change_encoding_uconverter($input, $encoding, 'UTF-8'));
        }
    }
    /**#@-*/

    /**#@+
     * UTF-16 methods
     */
    public static function toUTF16()
    {
        return [
            ["\x22\x1e", "\x22\x1e", 'UTF-16BE'],
            ["\x1e\x22", "\x22\x1e", 'UTF-16LE'],
        ];
    }

    /**
     * Convert * to UTF-16
     * @dataProvider toUTF16
     */
    public function test_convert_UTF16($input, $expected, $encoding)
    {
        $encoding = SimplePie_Misc::encoding($encoding);
        $this->assertSameBin2Hex($expected, SimplePie_Misc::change_encoding($input, $encoding, 'UTF-16'));
    }
    /**#@-*/

    public function test_nonexistant()
    {
        $this->assertFalse(SimplePie_Misc::change_encoding('', 'TESTENC', 'UTF-8'));
    }

    public static function assertSameBin2Hex($expected, $actual, $message = '')
    {
        if (is_string($expected)) {
            $expected = bin2hex($expected);
        }
        if (is_string($actual)) {
            $actual = bin2hex($actual);
        }
        static::assertSame($expected, $actual, $message);
    }
}

class Mock_Misc extends SimplePie_Misc
{
    public static function change_encoding_mbstring($data, $input, $output)
    {
        return parent::change_encoding_mbstring($data, $input, $output);
    }

    public static function change_encoding_iconv($data, $input, $output)
    {
        return parent::change_encoding_iconv($data, $input, $output);
    }

    public static function change_encoding_uconverter(string $data, string $input, string $output)
    {
        return parent::change_encoding_uconverter($data, $input, $output);
    }
}
