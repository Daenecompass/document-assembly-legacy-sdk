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

namespace Chance\DocumentAssembly\LegacySdk\Model;

/**
 * Class AbstractLegacyExport
 * @package Chance\DocumentAssembly\LegacySdk\Model
 *
 * for use with DraftOnce/JustFillOut API v1
 */
abstract class AbstractLegacyExport implements DocumentAssemblyExporterInterface
{
    private $instanceDomain;

    private $uri;

    private $instanceApiKey;

    private $userApiKey;

    /**
     * @var InterviewSessionDataInterface
     */
    private $data;

    /**
     * @return mixed
     */
    public function getInstanceDomain()
    {
        return $this->instanceDomain;
    }

    /**
     * @param mixed $instanceDomain
     */
    public function setInstanceDomain($instanceDomain)
    {
        $this->instanceDomain = $instanceDomain;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param InterviewSessionDataInterface $data
     */
    public function setData(InterviewSessionDataInterface $data)
    {
        $this->data = $data;
    }

    abstract public function export();
}