<?php

use NlpTools\Documents\TrainingSet;
use NlpTools\Documents\TokensDocument;

class MailTrainer
{
    private $trainingSet;       // Training set
    private $model;             // Bayesian training model
    private $ff;                // Features object
    private static $dbHandler;  // Database handler

    public function __construct()
    {
        self::$dbHandler = new DBHandler();
        $trainingData = self::$dbHandler->getTrainingData();
        $this->trainingSet = new TrainingSet();
        $this->model = $trainingData["model"];
        $this->ff = $trainingData["features"];
    }

    /**
     * Train the algorithm
     *
     * @param array $a Array of Mail objects
     * @throws Exception Throws an exception when a mail type does not exist
     */
    public function train(array $a)
    {
        foreach ($a as $el) {
            $type = strtoupper($el->getType());
            if (array_search($type, Config::MAIL_TYPES) === false) throw new Exception($type . " mail type doesn't exist.");
            $this->trainingSet->addDocument(
                $type,
                new TokensDocument(StringOperator::tokenize(StringOperator::clearText($el->getSubject() . " " . $el->getContent())))
            );
        }
        $this->model->train($this->ff, $this->trainingSet);
        self::$dbHandler->setTrainingData($this->model, $this->ff);
    }


}