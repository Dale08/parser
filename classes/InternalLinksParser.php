<?php


class InternalLinksParser
{
    public static function parse($page, $domain)
    {
        preg_match_all('/<a(.*?)href=\"(http:\/\/'.$domain.'\/|\/)(.*?)\"/is', $page, $links);

        return end($links);
    }
}