<?php
/**
 * @package
 * @subpackage
 * @author      Chance Garcia <chance@garcia.codes>
 * @copyright   (C)Copyright 2013-2018 Chance Garcia, chancegarcia.com
 *
 *    The MIT License (MIT)
 *
 * Copyright (c) 2013-2018 Chance Garcia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

namespace Chance\DocumentAssembly\LegacySdk\Tests;

use Chance\DocumentAssembly\LegacySdk\Model\SdkRepeatableAnswer;
use Chance\DocumentAssembly\LegacySdk\Model\SdkRepreatableAnswerInterface;
use PHPUnit\Framework\TestCase;

class SdkRepeatableAnswerTest extends TestCase
{
    public function testRepeatableTableRow()
    {
        $answerMockBuilder = $this->getMockBuilder(SdkRepeatableAnswer::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|SdkRepreatableAnswerInterface $answerMock
         */
        $answerMock = $answerMockBuilder->getMockForAbstractClass();

        // first test non-integer
        $answerMock->setRepeatableTableRow(1.21);

        $this->assertEquals(
            null,
            $answerMock->getRepeatableTableRow()
        );

        $answerMock->setRepeatableTableRow(1);

        $this->assertEquals(
            1,
            $answerMock->getRepeatableTableRow()
        );

        // todo setter ignores objects (accept only string castable values)
    }

    public function testRowCount()
    {
        $answerMockBuilder = $this->getMockBuilder(SdkRepeatableAnswer::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|SdkRepreatableAnswerInterface $answerMock
         */
        $answerMock = $answerMockBuilder->getMockForAbstractClass();

        // first test non-integer
        $answerMock->setRowCount(1.21);

        $this->assertEquals(
            null,
            $answerMock->getRowCount()
        );

        $answerMock->setRowCount(1);

        $this->assertEquals(
            1,
            $answerMock->getRowCount()
        );
    }
}