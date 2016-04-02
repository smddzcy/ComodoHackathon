<?php

use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;

class MailClassifier
{
    private $classifier;
    private $model;
    private $ff;
    private static $dbHandler;  // Database handler

    public function __construct()
    {
        self::$dbHandler = new DBHandler();
        $trainingData = self::$dbHandler->getTrainingData();
        $this->model = $trainingData["model"];
        $this->ff = $trainingData["features"];
        $this->classifier = new MultinomialNBClassifier($this->ff, $this->model);
    }


    /**
     * Predicts a mail's type
     *
     * @param Mail $mail Mail to predict
     * @return string Predicted mail type
     */
    public function classifySingle(Mail $mail)
    {
        return $this->classifier->classify(
            Config::MAIL_TYPES,
            new TokensDocument(StringOperator::tokenize($mail->getSubject() . " " . $mail->getContent()))
        );

    }

    /**
     * Predicts an array of mails
     *
     * @param array $mails Array of Mail objects to predict types
     * @return array Mail objects with their type's setted
     */
    public function classifyMulti(array $mails)
    {
        foreach ($mails as $mail) {
            $mail->setType($this->classifySingle($mail));
        }
        return $mails;
    }

}