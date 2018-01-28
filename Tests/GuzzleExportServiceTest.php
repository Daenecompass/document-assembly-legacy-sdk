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

use Chance\DocumentAssembly\LegacySdk\Service\GuzzleExportService;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionData;
use GuzzleHttp\Client;

class GuzzleExportServiceTest extends AbstractInterviewSessionDataTestCase
{
    public function testExport()
    {
        $interviewSessionDataMockBuilder = $this->getMockBuilder(InterviewSessionData::class);
        $interviewSessionDataMockBuilder->setMethods(['json', 'getInterviewSession']);

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|InterviewSessionData $interviewSessionDataMock
         */
        $interviewSessionDataMock = $interviewSessionDataMockBuilder->getMock();
        // make sure json method is called for exporting data
        $interviewSessionDataMock->expects($this->once())->method('json');
        $interviewSessionDataMock->method('getInterviewSession')->willReturn(null);

        $clientMockBuilder = $this->getMockBuilder(Client::class);
        $clientMockBuilder->setMethods(['request']);

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|Client $clientMock
         */
        $clientMock = $clientMockBuilder->getMock();
        // make sure that client request is called when exporting
        $clientMock->expects($this->once())->method('request');

        $guzzleExport = new GuzzleExportService();
        $guzzleExport->setClient($clientMock);
        $guzzleExport->setInterviewSessionData($interviewSessionDataMock);

        // since we can't mock the returns for instance name and domain we set them
        $guzzleExport->setInstanceName('foo');
        $guzzleExport->setDomain('example.invalid');

        $guzzleExport->export();
    }
}