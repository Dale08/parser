<?php


class ImageParser
{
    public static function parse($page)
    {
        preg_match_all('/<img(.*?)src=\"(.*?)\"/is', $page, $imgs);

        return end($imgs);
    }
}