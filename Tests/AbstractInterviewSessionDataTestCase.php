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

use Chance\DocumentAssembly\LegacySdk\Model\AnswerInterface;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionAnswerInterface;
use Chance\DocumentAssembly\LegacySdk\Model\InterviewSessionData;
use Chance\DocumentAssembly\LegacySdk\Model\RepreatableAnswerInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractInterviewSessionDataTestCase extends TestCase
{
    /**
     * @param string $type
     * @param int $num
     * @return array|\PHPUnit_Framework_MockObject_MockObject[]|AnswerInterface[]|RepreatableAnswerInterface[]
     */
    protected function generateAnswers($type = 'mixed', $num = 1)
    {
        $answers = [];

        while (count($answers) < $num) {
            $answers[] = $this->generateAnswer($type);
        }

        return $answers;
    }

    /**
     * @return InterviewSessionData
     */
    protected function newInterviewSessionDataInstance()
    {
        return new InterviewSessionData();
    }

    /**
     * @param string $type
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|AnswerInterface|RepreatableAnswerInterface
     */
    protected function generateAnswer($type = 'mixed')
    {
        switch (strtolower($type)) {
            case 'normal':
                $class = InterviewSessionAnswerInterface::class;
                break;
            case 'repeatable':
                $class = RepreatableAnswerInterface::class;
                break;
            case 'mixed':
                // no break
            default:
                $class = mt_rand(0, 1) ? InterviewSessionAnswerInterface::class : RepreatableAnswerInterface::class;
                break;
        }

        $builder = $this->getMockBuilder($class);

        $answer = $builder->getMock();

        $answer->method('getField')->willReturn(mt_rand());
        $answer->method('getValue')->willReturn(uniqid('chance_', false));

        if ($answer instanceof RepreatableAnswerInterface) {
            $answer->method('getRepeatableTableRow')->willReturn(mt_rand());
            $answer->method('getRowCount')->willReturn(mt_rand());
        }

        return $answer;

    }

    /**
     * @param AnswerInterface $mockAnswer
     * @return string
     */
    protected function convertMockAnswerToJsonAnswer(AnswerInterface $mockAnswer)
    {
        $jsonAnswer = new \stdClass();

        $jsonAnswer->Field_ID = $mockAnswer->getField();
        $jsonAnswer->Value = $mockAnswer->getValue();

        if ($mockAnswer instanceof RepreatableAnswerInterface) {
            $jsonAnswer->_kf_RepeatableTableRow_ID = $mockAnswer->getRepeatableTableRow();
            $jsonAnswer->RowCount = $mockAnswer->getRowCount();
        }

        return json_encode($jsonAnswer);
    }

    /**
     * @param array $mockAnswers
     * @return string
     */
    protected function convertMockAnswersToJsonAnswers(array $mockAnswers)
    {
        $jsonAnswers = [];

        foreach ($mockAnswers as $mockAnswer) {
            $jsonAnswers[] = $this->convertMockAnswerToJsonAnswer($mockAnswer);
        }

        return json_encode($jsonAnswers);
    }

    /**
     * @param null $interviewId
     * @param null $note
     * @param null $interviewSessionId
     * @return InterviewSessionData
     */
    protected function generateInterviewSessionData($interviewId = null, $note = null, $interviewSessionId = null)
    {
        if (empty($interviewId)) {
            $interviewId = mt_rand();
        }

        $data = $this->newInterviewSessionDataInstance();
        $data->setInterview($interviewId);
        $data->setNote($note);
        if (is_int($interviewSessionId)) {
            $data->setInterviewSession($interviewSessionId);
        }

        return $data;
    }

    /**
     * @param null $interviewId
     * @param null $note
     * @param null $interviewSessionId
     * @param string $answerType
     * @param null|int|array $numAnswers null will default to 1;
     * @return InterviewSessionData
     */
    protected function generateInterviewSessionDataWithNonMixedAnswers($interviewId = null, $note = null, $interviewSessionId = null, $answerType = 'normal', $numAnswers = null)
    {
        $data = $this->generateInterviewSessionData($interviewId, $note, $interviewSessionId);

        $answers = $this->generateAnswers($answerType, $numAnswers);

        foreach ($answers as $answer) {
            $data->addAnswer($answer);
        }

        return $data;
    }

    /**
     * @param $interviewId
     * @param $note
     * @param $interviewSessionId
     * @return \stdClass
     */
    protected function generateJsonObjInterviewSessionData($interviewId = null, $note = null, $interviewSessionId = null)
    {
        $obj = new \stdClass();
        $obj->Interview_ID = $interviewId;
        $obj->Note = $note;
        if (is_int($interviewSessionId)) {
            $obj->_kf_InterviewSession_ID = $interviewSessionId;
        }

        return $obj;
    }

    /**
     * @param null $interviewId
     * @param null $note
     * @param null $interviewSessionId
     * @return string
     */
    protected function generateJsonInterviewSessionData($interviewId = null, $note = null, $interviewSessionId = null)
    {
        $obj = $this->generateJsonObjInterviewSessionData($interviewId, $note, $interviewSessionId);

        return json_encode($obj);
    }
}