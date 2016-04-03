<?php

require_once "Config.php";
/*
$trainer = new MailTrainer();
$directory = "/Users/smddzcy/Downloads/Datasets/2016/";
foreach (array_diff(scandir($directory), array('..', '.')) as $dir) {
    foreach (array_diff(scandir($directory . $dir . "/"), array('..', '.')) as $file) {
        $file = $directory . $dir . "/" . $file;
        $content = file_get_contents($file);
        @unlink($file);
        preg_match("#Content\-Type\:.*?text/plain(.*?)--[0-9]{3}#si", $content, $msg);
        if (!array_key_exists(1, $msg)) continue;
        $msg = trim($msg[1]);
        $trainingData = [new Mail(["content" => $msg], "SPAM")];
        $trainer->train($trainingData);
    }
}
*/

$data = ["Natural Hair Regrowth Tablets!
 
Thousands purchased around the world every day.
 
Available in almost all countries "];
$type = "SPAM";
if (count($data) > 0) {
    $trainer = new MailTrainer();
    $trainingData = [];
    foreach ($data as $d) {
        $trainingData[] = new Mail(["content" => $d], $type);
    }
    $trainer->train($trainingData);
}


$classifier = new MailClassifier();
$mails = $classifier->classifyMulti([
    new Mail(["content" => '
Natural Hair Regrowth Tablets!
 
Thousands purchased around the world every day.
 
Available in almost all countries '])
]);

var_dump($mails);

// Yay %100 success rate !!!!
