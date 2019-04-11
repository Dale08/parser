<?php


class CSV
{
    public static function showFile($filename)
    {
        $rows = array_map('str_getcsv', file($filename, FILE_IGNORE_NEW_LINES));
        foreach ($rows as $row){
            foreach ($row as $line) {
                $text = json_decode($line);
                if(NULL == $text) {
                    echo $line.PHP_EOL;
                } else {
                    foreach ($text as $t) {
                        echo "\t".$t.PHP_EOL;
                    }
                }
            }
        }
    }

    public static function write($filename, $rows)
    {
        $file = fopen($filename, 'w');
        foreach ($rows as $url => $data){
            $row = [$url];
            foreach ($data as $t => $val){
                if (!empty($val)) {
                    array_push($row, json_encode($val));
                }else{
                    continue;
//                    continue 2;
                }
            }
            fputcsv($file, $row);
        }
        return fclose($file);
    }
}