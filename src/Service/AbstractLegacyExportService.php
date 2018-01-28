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

namespace Chance\DocumentAssembly\LegacySdk\Service;

use Chance\DocumentAssembly\LegacySdk\Exception\LegacyExportException;
use Chance\DocumentAssembly\LegacySdk\Model\DocumentAssemblyLegacyExportServiceInterface;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionDataInterface;

/**
 * Class AbstractLegacyExport
 * @package Chance\DocumentAssembly\LegacySdk\Model
 *
 * for use with DraftOnce/JustFillOut API v1
 */
abstract class AbstractLegacyExportService implements DocumentAssemblyLegacyExportServiceInterface
{
    const EDIT_TRANSPORT_METHOD = 'PUT';
    const ADD_TRANSPORT_METHOD = 'POST';

    private $instanceName;

    private $protocol = 'https';

    protected $domain;

    private $instanceApiKey;

    private $userApiKey;

    /**
     * @var InterviewSessionDataInterface
     */
    private $interviewSessionData;

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol)
    {
        if (is_string($protocol)) {
            $this->protocol = $protocol;
        }
    }

    /**
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        if (is_string($domain)) {
            $this->domain = $domain;
        }
    }

    /**
     * @return string|null
     */
    public function getInstanceName()
    {
        return $this->instanceName;
    }

    /**
     * @param string $instanceName
     */
    public function setInstanceName($instanceName)
    {
        if (is_string($instanceName)) {
            $this->instanceName = $instanceName;
        }
    }

    /**
     * @return string
     */
    public function getFqdn()
    {
        if (!is_string($this->domain)) {
            throw new LegacyExportException('domain not found', LegacyExportException::DOMAIN_NOT_FOUND);
        }

        if (!is_string($this->instanceName)) {
            throw new LegacyExportException('instance name not found', LegacyExportException::INSTANCE_NAME_NOT_FOUND);
        }

        return $this->protocol . "://" . $this->instanceName . "." . $this->domain;
    }

    public function getUri()
    {
        return $this->getFqdn() . self::LEGACY_ENDPOINT;
    }

    /**
     * @return mixed
     */
    public function getInstanceApiKey()
    {
        return $this->instanceApiKey;
    }

    /**
     * @param mixed $instanceApiKey
     */
    public function setInstanceApiKey($instanceApiKey)
    {
        $this->instanceApiKey = $instanceApiKey;
    }

    /**
     * @return mixed
     */
    public function getUserApiKey()
    {
        return $this->userApiKey;
    }

    /**
     * @param mixed $userApiKey
     */
    public function setUserApiKey($userApiKey)
    {
        $this->userApiKey = $userApiKey;
    }

    /**
     * @return InterviewSessionDataInterface
     */
    public function getInterviewSessionData()
    {
        return $this->interviewSessionData;
    }

    /**
     * @param InterviewSessionDataInterface $interviewSessionData
     */
    public function setInterviewSessionData(InterviewSessionDataInterface $interviewSessionData)
    {
        $this->interviewSessionData = $interviewSessionData;
    }

    public function getExportTransportMethod()
    {
        $documentAssemblyData = $this->getInterviewSessionData();

        return $documentAssemblyData->getInterviewSession() ? static::EDIT_TRANSPORT_METHOD : static::ADD_TRANSPORT_METHOD;
    }

    abstract public function export();
}