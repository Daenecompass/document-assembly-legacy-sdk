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

use Chance\DocumentAssembly\LegacySdk\Model\AbstractSdkAnswer;
use Chance\DocumentAssembly\LegacySdk\Model\SdkAnswerInterface;
use PHPUnit\Framework\TestCase;

class SdkAnswerTest extends TestCase
{
    public function testField()
    {
        $answerMockBuilder = $this->getMockBuilder(AbstractSdkAnswer::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|SdkAnswerInterface $answerMock
         */
        $answerMock = $answerMockBuilder->getMockForAbstractClass();

        // first test non-integer
        $answerMock->setField(1.21);

        $this->assertEquals(
            null,
            $answerMock->getField()
            );

        $answerMock->setField(1);

        $this->assertEquals(
            1,
            $answerMock->getField()
        );
    }

    public function testValue()
    {
        $answerMockBuilder = $this->getMockBuilder(AbstractSdkAnswer::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|SdkAnswerInterface $answerMock
         */
        $answerMock = $answerMockBuilder->getMockForAbstractClass();

        $answerMock->setValue('foo');

        $this->assertEquals(
            'foo',
            $answerMock->getValue()
        );

        // todo setter ignores objects (accept only string castable values)
    }

    public function testName()
    {
        $answerMockBuilder = $this->getMockBuilder(AbstractSdkAnswer::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|AbstractSdkAnswer $answerMock
         */
        $answerMock = $answerMockBuilder->getMockForAbstractClass();

        $answerMock->setName('example');

        $this->assertEquals(
            'example',
            $answerMock->getName()
        );

        // todo setter ignores objects (accept only string castable values)
    }
}