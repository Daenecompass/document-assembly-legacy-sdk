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

class InterviewSessionData implements InterviewSessionDataInterface
{
    private $interviewSession;

    private $interview;

    private $note;

    /**
     * @var SdkAnswerInterface[]|array
     */
    protected $answers = [];

    /**
     * @return mixed
     */
    public function getInterviewSession()
    {
        return $this->interviewSession;
    }

    /**
     * @param mixed $interviewSession
     */
    public function setInterviewSession($interviewSession)
    {
        if (filter_var($interviewSession, FILTER_VALIDATE_INT)) {
            $this->interviewSession = $interviewSession;
        }
    }

    /**
     * @return mixed
     */
    public function getInterview()
    {
        return $this->interview;
    }

    /**
     * @param mixed $interview
     */
    public function setInterview($interview)
    {
        if (filter_var($interview, FILTER_VALIDATE_INT)) {
            $this->interview = $interview;
        }
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return SdkAnswerInterface[]|array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function addAnswer(SdkAnswerInterface $answer) {
        $this->answers[] = $answer;
    }

    /**
     * @return array
     */
    public function toJsonArray()
    {
        $json = [
            'Interview_ID' => $this->interview,
            'Note' => $this->note
        ];

        if ($this->interviewSession) {
            $json['_kf_InterviewSession_ID'] = $this->interviewSession;
        }

        $jsonAnswers = [];
        foreach ($this->answers as $answer) {
            $jsonAnswer = [
                'Field_ID' => $answer->getField(),
                'Value' => $answer->getValue(),
            ];

            if ($answer instanceof SdkRepreatableAnswerInterface) {
                $jsonAnswer['_kf_RepeatableTableRow_ID'] = $answer->getRepeatableTableRow();
                $jsonAnswer['RowCount'] = $answer->getRowCount();
            }

            $jsonAnswers[] = $jsonAnswer;
        }

        $json['Answers'] = $jsonAnswers;

        return $json;
    }

    /**
     * @return object
     */
    public function jsonObject()
    {
        return (object) $this->toJsonArray();
    }

    public function json()
    {
        return json_encode($this->jsonObject());
    }
}