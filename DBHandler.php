<?php

class DBHandler
{
    private static $db = null;
    private $mailsTableName;

    public function __construct()
    {
        try {
            self::$db = new PDO(Config::DB_TYPE . ":host=" . Config::DB_HOST . ";port=" . Config::DB_PORT . ";dbname=" . Config::DB_NAME . ";charset=" . Config::DB_CHARSET, Config::DB_USER, Config::DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->mailsTableName = Config::DB_MAILSTABLENAME;
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
     * @return bool True on success, false on failure
     */
    public function addMail($subj, $content)
    {
        $query = self::$db->prepare("INSERT INTO {$this->mailsTableName} (subject,content) VALUES (:subj,:content)");
        return $query->execute([
            ":subj" => $subj,
            ":content" => $content
        ]);
    }

    /**
     * Get mails from database
     *
     * @param int $count -1 (or any negative number) => Get all mails from database
     * @return bool True on success, false on failure
     */
    public function getMail($count = -1)
    {
        $query = self::$db->prepare("SELECT * FROM {$this->mailsTableName}" . ($count > 0 ? " LIMIT 0,:count" : ""));
        $query->bindValue(":count", $count, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    
}