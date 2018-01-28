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

class InterviewSessionDataTest extends AbstractInterviewSessionDataTestCase
{
    public function testInterviewSession()
    {
        $data = $this->newInterviewSessionDataInstance();

        // first test non-integer
        $data->setInterviewSession(1.21);

        $this->assertEquals(
            null,
            $data->getInterviewSession()
        );

        $data->setInterviewSession(1);

        $this->assertEquals(
            1,
            $data->getInterviewSession()
        );
    }

    public function testInterview()
    {
        $data = $this->newInterviewSessionDataInstance();

        // first test non-integer
        $data->setInterview(1.21);

        $this->assertEquals(
            null,
            $data->getInterview()
        );

        $data->setInterview(1);

        $this->assertEquals(
            1,
            $data->getInterview()
        );
    }

    public function testInterviewSessionJson()
    {
        $data = $this->newInterviewSessionDataInstance();

        $data->setInterviewSession(1);

        $json = new \stdClass();
        $json->Interview_ID = null;
        $json->Note = null;
        $json->_kf_InterviewSession_ID = 1;
        $json->Answers = [];

        $this->assertEquals(
            json_encode($json),
            $data->json()
        );
    }

    public function testAddAnswer()
    {
        $data = $this->newInterviewSessionDataInstance();

        $this->assertCount(0, $data->getAnswers());

        $answer = $this->generateAnswer();

        $data->addAnswer($answer);

        $this->assertCount(1, $data->getAnswers());

        unset ($data);
    }

    public function testJsonEmptyNewDataClass()
    {
        $data = $this->newInterviewSessionDataInstance();

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());
        $jsonObj->Answers = [];

        $this->assertEquals(json_encode($jsonObj), $data->json());

        unset($data);
    }

    public function testJsonSingleInterviewSessionAnswer()
    {
        $data = $this->generateInterviewSessionDataWithNonMixedAnswers(null, null, null, 'normal', 1);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        foreach ($data->getAnswers() as $answer) {
            $jsonObj->Answers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMultipleInterviewSessionAnswers()
    {
        $data = $this->generateInterviewSessionDataWithNonMixedAnswers(null, null, null, 'normal', mt_rand(3,5));

        $answers = $data->getAnswers();

        $this->assertTrue(count($answers) > 1);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        foreach ($data->getAnswers() as $answer) {
            $jsonObj->Answers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonSingleRepeatableTableRowAnswer()
    {
        $data = $this->generateInterviewSessionDataWithNonMixedAnswers(null, null, null, 'repeatable', 1);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        foreach ($data->getAnswers() as $answer) {
            $jsonObj->Answers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMultipleRepeatableTableRowAnswers()
    {
        $data = $this->generateInterviewSessionDataWithNonMixedAnswers(null, null, null, 'repeatable', mt_rand(3,5));

        $answers = $data->getAnswers();

        $this->assertTrue(count($answers) > 1);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        foreach ($data->getAnswers() as $answer) {
            $jsonObj->Answers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMixedAnswers()
    {
        // don't use with answers generator to guarantee mixed answers
        $data = $this->generateInterviewSessionData();

        $jsonAnswers = [];

        $normalAnswers = $this->generateAnswers('normal', mt_rand(3,5));

        $this->assertTrue(count($normalAnswers) > 1);

        foreach ($normalAnswers as $answer) {
            $data->addAnswer($answer);
            $jsonAnswers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $repeatableAnswers = $this->generateAnswers('repeatable', mt_rand(3,5));

        $this->assertTrue(count($repeatableAnswers) > 1);

        foreach ($repeatableAnswers as $answer) {
            $data->addAnswer($answer);
            $jsonAnswers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        $jsonObj->Answers = $jsonAnswers;

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }
}