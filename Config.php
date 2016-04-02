<?php

require_once('vendor/autoload.php');

use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Documents\TrainingSet;
use NlpTools\Documents\TokensDocument;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Classifiers\MultinomialNBClassifier;

final class Config
{
    const MAIL_TYPES = [
        "SPAM", "PROMOTION", "SOCIAL", "FRIENDS/FAMILY"
    ];

    const DB_TYPE = "mysql";
    const DB_HOST = "localhost";
    const DB_PORT = 3306;
    const DB_CHARSET = "utf8";

    const DB_USER = "root";
    const DB_PASS = "1233211";
    const DB_NAME = "comodo";
    const DB_MAILSTABLENAME = "mails";

    public static function load($className)
    {
        include_once "./{$className}.php";
    }


}

spl_autoload_register("Config::load");