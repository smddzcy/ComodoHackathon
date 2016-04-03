<?php

require_once('vendor/autoload.php');

final class Config
{
    /**
     * Mail types for clustering in Bayesian algorithm
     */
    const MAIL_TYPES = [
        "SPAM", "PROMOTION", "SOCIAL", "PERSONAL"
    ];

    /**
     * Whitelisted social domains for simple hard-coded clustering
     */
    const SOCIAL_DOMAINS = [
        "FACEBOOK", "TWITTER", "INSTAGRAM", "YOUTUBE", "PINTEREST", "MAIL.LINKEDIN", "LINKEDIN",
        "FOURSQUARE", "PLUS.GOOGLE", "XING", "DISQUS", "SNAPCHAT", "TUMBLR", "TWOO", "VINE", "MEETUP",
        "VK", "MYSPACE", "BEBO", "FRIENDSTER", "HABBO", "HI5", "BADOO", "ORKUT", "FLICKR", "TAGGED", "ASK",
        "MEETME", "CLASSMATES"
    ];

    const DB_TYPE = "mysql";
    const DB_HOST = "localhost";
    const DB_PORT = 3306;
    const DB_CHARSET = "utf8";

    const DB_USER = "root";
    const DB_PASS = "1233211";
    const DB_NAME = "comodo";
    const DB_MAILS_TABLENAME = "mails";
    const DB_TRAININGDATA_TABLENAME = "training_data";

    const DAY = 60 * 60 * 24;

    public static function load($className)
    {
        include_once "./{$className}.php";
    }


}

spl_autoload_register("Config::load");