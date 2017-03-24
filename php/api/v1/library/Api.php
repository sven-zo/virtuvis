<?php

/**
 * Api Abstract Class
 * This class is written to give an Abstract construction of how library that wil work with API's should look like.
 */

abstract class Api
{
    /**
     * @param $url
     * @return mixed|null
     */
    protected function curlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($ch);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($returnCode == 200){
            return json_decode($data);
        } else {
            return NULL;
        }
    }
}