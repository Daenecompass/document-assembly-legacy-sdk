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
        $data = $this->generateInterviewSessionData();

        $answer = $this->generateAnswer('normal');

        $data->addAnswer($answer);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        $jsonObj->Answers = [
            json_decode($this->convertMockAnswerToJsonAnswer($answer)),
        ];

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMultipleInterviewSessionAnswers()
    {
        $data = $this->generateInterviewSessionData();

        $answers = $this->generateAnswers('normal', mt_rand(3,5));

        $this->assertTrue(count($answers) > 1);

        $jsonAnswers = [];
        foreach ($answers as $answer) {
            $data->addAnswer($answer);
            $jsonAnswers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        $jsonObj->Answers = $jsonAnswers;

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonSingleRepeatableTableRowAnswer()
    {
        $data = $this->generateInterviewSessionData();

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|AnswerInterface $answer
         */
        $answer = $this->generateAnswer('repeatable');

        $data->addAnswer($answer);

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        $jsonObj->Answers = [
            json_decode($this->convertMockAnswerToJsonAnswer($answer)),
        ];

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMultipleRepeatableTableRowAnswers()
    {
        $data = $this->generateInterviewSessionData();

        $answers = $this->generateAnswers('repeatable', mt_rand(3,5));

        $this->assertTrue(count($answers) > 1);

        $jsonAnswers = [];
        foreach ($answers as $answer) {
            $data->addAnswer($answer);
            $jsonAnswers[] = json_decode($this->convertMockAnswerToJsonAnswer($answer));
        }

        $jsonObj = $this->generateJsonObjInterviewSessionData($data->getInterview(), $data->getNote(), $data->getInterviewSession());

        $jsonObj->Answers = $jsonAnswers;

        $this->assertEquals(json_encode($jsonObj), $data->json());
    }

    public function testJsonMixedAnswers()
    {
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