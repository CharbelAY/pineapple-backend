<?php


namespace app\services;


class CsvService
{
    public function generateCSV($filename,$data){
        if($data){
            $file = fopen($filename,"w");
            fputcsv($file,array_keys($data[0]));
            foreach ($data as $d){
                fputcsv($file,$d);
            }
            fclose($file);
            return 1;
        }
        return 0;
    }
}