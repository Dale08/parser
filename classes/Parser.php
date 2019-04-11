<?php

class Parser
{

    public $host;

    public $checkingLink;

    public $writeData = [];

    public $urlsToCheck = [];

    public $checkedUrls = [];

    public $toParse = [
        'ImageParser',
    ];

    /**
     * Parser constructor.
     */
    public function __construct($checkingLink)
    {
        $this->checkingLink = $checkingLink;
        $this->host = parse_url($checkingLink, PHP_URL_HOST);

    }

    public function parseSite($url)
    {
        if (!in_array($url, $this->checkedUrls)) {
            $page = CURL::getPage($url);
            if(!empty($this->toParse)){
                foreach ($this->toParse as $class){
                    $this->writeData[$url][] = $class::parse($page);
                }
            }
            $urlsToCheck = InternalLinksParser::parse($page, $this->host);
            // For checking more links push it to $urlsToCheck
            array_push($this->checkedUrls, $url);
            foreach ($urlsToCheck as $urlToCheck) {
                    if (!preg_match('/^(http|https):\/\/[^ "]+$/', $urlToCheck)) {
                        $urlToCheck = 'http://'.$this->host.'/'.$urlToCheck;
                    }
                    $this->parseSite($urlToCheck);
            }
        }
    }

    public function run(){
        $this->parseSite($this->checkingLink);
    }
}

?>