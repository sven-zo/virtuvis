<?php

/**
 * Weather Class
 * This class is written to speed up the fetching data from the weather API
 */

class Weather extends Api
{
    private $key;
    private $location;
    private $conditions;
    private $temprature;

    /**
     * Weather constructor.
     * @param $key
     * @param $location
     * @return Weather
     */
    public function __construct($key, $location)
    {
        $this->key = $key;
        $this->location = $location;

        return $this;
    }

    /**
     * @return array
     */
    public function getMainCondition()
    {
        $endpoint = 'api.openweathermap.org/data/2.5/weather?q='.$this->location.'&APPID='.$this->key.'&mode=json';
        $weatherData = $this->curlRequest($endpoint);

        $conditions = [];

        $conditions[] = $weatherData->weather[0]->main;

        return $this->conditions = $conditions;
    }




}