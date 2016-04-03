<?php
error_reporting(E_ALL);
if (!array_key_exists("function", $_POST)) die();
$func = $_POST["function"];
$data = array_key_exists("data", $_POST) ? $_POST["data"] : null;
$response = [];
require_once "Config.php";

switch ($func) {
    case "train":
        $trainer = new MailTrainer();
        var_dump(new Mail(["subject" => $data["subject"], "content" => $data["content"]]));
        $trainer->train([
            new Mail(["subject" => $data["subject"], "content" => $data["content"]], $data["type"])
        ]);
        die(json_encode("OK."));
        break;

    case "getUntrainedMails":
        $directory = "/Users/smddzcy/Downloads/Datasets/maildir/";
        $count = max($_POST["data"]["count"], 1);
        $i = 0;
        foreach (array_diff(scandir($directory), array('..', '.')) as $dir) {
            foreach (array_diff(scandir($directory . $dir . "/"), array('..', '.')) as $dir2) {
                foreach (array_diff(scandir($directory . $dir . "/" . $dir2 . "/"), array('..', '.')) as $file) {
                    $file = $directory . $dir . "/" . $dir2 . "/" . $file;
                    $content = file_get_contents($file);
                    @unlink($file);
                    preg_match("#Subject[^:]*?:(.*)#i", $content, $subject);
                    $subject = trim($subject[1]);
                    preg_match('#.*?([\n]{2}+.*)#si', $content, $msg);
                    if (!array_key_exists(1, $msg)) continue;
                    $msg = trim($msg[1]);
                    $response[] = ["subject" => $subject, "content" => $msg];
                    if ($i == $count) die(json_encode($response));
                    $i++;
                }
            }
        }
        break;

    case "getCounts":
        $dbHandler = new DBHandler();
        $allMails = $dbHandler->getMail();
        $mailTypes = [];
        foreach (Config::MAIL_TYPES as $type) $mailTypes[strtolower($type)] = 0;
        foreach ($allMails as $mail) {
            if (array_key_exists(strtolower($mail["type"]), $mailTypes)) $mailTypes[strtolower($mail["type"])]++;
        }
        die(json_encode($mailTypes));
        break;

    case "classify":
        $classifier = new MailClassifier();
        $dbHandler = new DBHandler();

        $type = $classifier->classifySingle(
            new Mail([
                "subject" => $data["subject"],
                "content" => $data["content"],
                "from" => !empty($data["from"]) ? $data["from"] : null,
                "date" => !empty($data["date"]) ? date('r', strtotime($data["date"])) : null
            ])
        );
        $mailID = $dbHandler->addMail($data["subject"], $data["content"], $type);
        die(json_encode(["id" => $mailID, "type" => $type]));
        break;

}