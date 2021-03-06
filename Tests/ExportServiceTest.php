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

use Chance\DocumentAssembly\LegacySdk\Exception\LegacyExportException;
use Chance\DocumentAssembly\LegacySdk\Model\DocumentAssemblyLegacyExportServiceInterface;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionData;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionDataInterface;
use Chance\DocumentAssembly\LegacySdk\Service\AbstractLegacyExportService;

class ExportServiceTest extends AbstractInterviewSessionDataTestCase
{
    public function testProtocol()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $this->assertEquals(
            'https',
            $exportMock->getProtocol(),
            'default https value not found'
        );

        $exportMock->setProtocol('http');
        $this->assertEquals(
            'http',
            $exportMock->getProtocol()
        );

    }

    public function testDomain()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->setDomain('example.invalid');

        $this->assertEquals(
            'example.invalid',
            $exportMock->getDomain()
        );
    }

    public function testInstanceName()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->setInstanceName('example');

        $this->assertEquals(
            'example',
            $exportMock->getInstanceName()
        );
    }

    public function testInstanceApiKey()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $instanceApiKey = uniqid('chance_', true);
        $exportMock->setInstanceApiKey($instanceApiKey);

        $this->assertEquals(
            $instanceApiKey,
            $exportMock->getInstanceApiKey()
        );
    }

    public function testUserApiKey()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $userApiKey = uniqid('chance_', true);
        $exportMock->setUserApiKey($userApiKey);

        $this->assertEquals(
            $userApiKey,
            $exportMock->getUserApiKey()
        );
    }

    public function testGetFqdnThrowsExceptionForUnsetDomain()
    {
        $this->expectException(LegacyExportException::class);
        $this->expectExceptionCode(LegacyExportException::DOMAIN_NOT_FOUND);

        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->getFqdn();
    }

    /**
     * @depends testGetFqdnThrowsExceptionForUnsetDomain
     */
    public function testGetFqdnThrowsExceptionForUnsetInstanceName()
    {
        $this->expectException(LegacyExportException::class);
        $this->expectExceptionCode(LegacyExportException::INSTANCE_NAME_NOT_FOUND);

        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->setDomain('example.invalid');

        $exportMock->getFqdn();

    }

    /**
     * @depends testGetFqdnThrowsExceptionForUnsetInstanceName
     */
    public function testGetFqdn()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->setDomain('example.invalid');
        $exportMock->setInstanceName('foo');

        $this->assertEquals(
            $exportMock->getProtocol() . "://foo.example.invalid",
            $exportMock->getFqdn()
        );
    }

    /**
     * @depends testGetFqdn
     */
    public function testGetUri()
    {
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();

        $exportMock->setDomain('example.invalid');
        $exportMock->setInstanceName('foo');

        $this->assertEquals(
            $exportMock->getProtocol() . "://foo.example.invalid" . DocumentAssemblyLegacyExportServiceInterface::LEGACY_ENDPOINT,
            $exportMock->getUri()
        );
    }

    public function testGetExportTransportMethod()
    {
        $dataMockBuilder = $this->getMockBuilder(InterviewSessionData::class);
        $exportMockBuilder = $this->getMockBuilder(AbstractLegacyExportService::class);

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|InterviewSessionDataInterface $dataMock
         */
        $dataMock = $dataMockBuilder->getMock();

        // test post the put return expectations
        $dataMock->method('getInterviewSession')->will($this->onConsecutiveCalls(null, 1));

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|DocumentAssemblyLegacyExportServiceInterface $exportMock
         */
        $exportMock = $exportMockBuilder->getMockForAbstractClass();
        $exportMock->setInterviewSessionData($dataMock);

        $this->assertEquals('POST', $exportMock->getExportTransportMethod());

        // since we set the data mock for consecutive call returns, we don't need to set it again
        // $exportMock->setInterviewSessionData($dataMock);

        $this->assertEquals('PUT', $exportMock->getExportTransportMethod());
    }
}