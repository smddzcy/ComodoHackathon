<?php

require_once "Config.php";

$trainer = new MailTrainer();
$trainingData = [
    new Mail(["content" => "Go until jurong point, crazy.. Available only in bugis n great world la e buffet... Cine there got amore wat...",], "FRIENDS/FAMILY"),
    new Mail(["content" => 'Fine if that\'s the way u feel. That\'s the way its gota b'], "FRIENDS/FAMILY"),
    new Mail(["content" => "England v Macedonia - dont miss the goals/team news. Txt ur national team to 87077 eg ENGLAND to 87077 Try:WALES, SCOTLAND 4txt/ú1.20 POBOXox36504W45WQ 16+"], "SPAM")
];
$trainer->train($trainingData);
$classifier = new MailClassifier();

$mails = $classifier->classifyMulti([
    new Mail(["content" => 'I\'ve been searching for the right words to thank you for this breather. I promise i wont take your help for granted and will fulfil my promise. You have been wonderful and a blessing at all times.']),
    new Mail(["content" => 'I HAVE A DATE ON SUNDAY WITH WILL!!']),
    new Mail(["content" => 'XXXMobileMovieClub: To use your credit, click the WAP link in the next txt message or click here>> http://wap. xxxmobilemovieclub.com?n=QJKGIGHJJGCBL']),
    new Mail(["content" => "Go until jurong point, crazy.. Available only in bugis n great world la e buffet... Cine there got amore wat...",]),
]);

var_dump($mails);
// Yay %50 success rate !!!!