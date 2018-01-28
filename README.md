# Document Assembly SDK
Export data to DraftOnce or JustFillOut API v1

## Installation
The suggested installation method is via [composer](https://getcomposer.org/):


    php composer.phar require "chancegarcia/document-assembly-legacy-sdk"


## Usage

    $exporter = new GuzzleExportService();
    $exporter->setInstanceName('yourInstance');
    $exporter->setInstanceApiKey('yourInstanceApiKey');
    $exporter->setUserApiKey('aUserApiKey');
    $exporter->setDomain('draftonce.com');

    $guzzle = new Client();
    $exporter->setClient($guzzle);

    $interviewSessionData = new InterviewSessionData();
    $interviewSessionData->setInterview(1);

    $a1 = new SdkInterviewSessionAnswer();
    $a1->setField(7);
    $a1->setName('first name');
    $a1->setValue(uniqid('chance_', true));
    $interviewSessionData->addAnswer($a1);

    $r0a = new SdkRepeatableRepreatableAnswer();
    $r0a->setValue(uniqid('rtr_edu_', true));
    $r0a->setName('education-university');
    $r0a->setField(12);
    $r0a->setRepeatableTableRow(1);
    $r0a->setRowCount(0);
    $interviewSessionData->addAnswer($r0a);

    $interviewSessionData->setInterviewSession(4);
    $interviewSessionData->setNote('rtr answer test');

    $exporter->setInterviewSessionData($interviewSessionData);


    $response = $exporter->export();
    $body = $response->getBody();
    $content = $body->getContents();
    $phpContent = json_decode($content);
