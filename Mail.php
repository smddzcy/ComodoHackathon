<?php

class Mail
{
    private $data;
    private $type;                // Only for training

    public function __construct($data, $type = null)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return array_key_exists("subject", $this->data) ? $this->data["subject"] : null;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->data["subject"] = $subject;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return array_key_exists("content", $this->data) ? $this->data["content"] : null;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->data["content"] = $content;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return array_key_exists("date", $this->data) ? $this->data["date"] : null;
    }

    /**
     * @param string $content
     */
    public function setDate($content)
    {
        $this->data["date"] = $content;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return array_key_exists("from", $this->data) ? $this->data["from"] : null;
    }

    /**
     * @param string $content
     */
    public function setFrom($content)
    {
        $this->data["from"] = $content;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return array_key_exists("to", $this->data) ? $this->data["to"] : null;
    }

    /**
     * @param string $content
     */
    public function setTo($content)
    {
        $this->data["to"] = $content;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}