<?php

use NlpTools\Models\FeatureBasedNB;
use NlpTools\FeatureFactories\DataAsFeatures;

class DBHandler
{
    private static $db = null;
    private $mailsTableName;
    private $trainingDataTableName;

    public function __construct()
    {
        try {
            self::$db = new PDO(Config::DB_TYPE . ":host=" . Config::DB_HOST . ";port=" . Config::DB_PORT . ";dbname=" . Config::DB_NAME . ";charset=" . Config::DB_CHARSET, Config::DB_USER, Config::DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->mailsTableName = Config::DB_MAILS_TABLENAME;
            $this->trainingDataTableName = Config::DB_TRAININGDATA_TABLENAME;
        } catch (PDOException $e) {
            echo "Database connection error: " . $e->getMessage() . PHP_EOL;
            echo "Stack trace:" . $e->getTrace() . PHP_EOL;
        }
    }

    /**
     * Add mail into database
     *
     * @param string $subj Mail subject
     * @param string $content Mail content
     * @param string $type Mail type
     * @return array|bool Mail ID on success, false on failure
     */
    public function addMail($subj, $content, $type = null)
    {
        $query = self::$db->prepare("INSERT INTO {$this->mailsTableName} (subject,content,type) VALUES (:subj,:content,:type)");
        $query->execute([
            ":subj" => $subj,
            ":content" => $content,
            ":type" => $type
        ]);
        $query = self::$db->prepare("SELECT id FROM {$this->mailsTableName} WHERE content = :content");
        $query->execute([
            ":content" => $content
        ]);
        return $query->fetch()["id"];
    }

    /**
     * Get mails from database
     *
     * @param int $count -1 (or any negative number) => Get all mails from database
     * @return bool|array Mails on success, false on failure
     */
    public function getMail($count = -1)
    {
        $query = self::$db->prepare("SELECT * FROM {$this->mailsTableName}" . ($count > 0 ? " LIMIT 0,:count" : ""));
        $query->bindValue(":count", $count, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }


    /**
     * Get training data as an array from the database
     *
     * @return array Vector of [model=>MODEL OBJECT, features=>FEATURES OBJECT]
     */
    public function getTrainingData()
    {
        $modelData = file_exists("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/model") ? unserialize(preg_replace_callback('!s:(\d+):"(.*?)";!', function ($match) {
            return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        }, file_get_contents("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/model"))) : new FeatureBasedNB();
        $featuresData = file_exists("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/features") ? unserialize(preg_replace_callback('!s:(\d+):"(.*?)";!', function ($match) {
            return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        }, file_get_contents("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/features"))) : new DataAsFeatures();
        return [
            "model" => $modelData,
            "features" => $featuresData,
        ];

    }

    /**
     * Save training model into database
     *
     * @param FeatureBasedNB $model Trained model
     * @param DataAsFeatures $ff Feature class
     * @return bool True on success, false on failure
     */
    public function setTrainingData(FeatureBasedNB $model, DataAsFeatures $ff)
    {
        $model = serialize($model);
        $ff = serialize($ff);
        file_put_contents("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/model", $model);
        file_put_contents("/Users/smddzcy/Desktop/www/ComodoHackathon/training_db/features", $ff);
    }


}