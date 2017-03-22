<?php

/**
 * Weather Class
 * This class is written to speed up the fetching data from the weather API
 */


class Weather extends Api
{
    private $key;
    private $location;
    private $condition;
    private $temperatureC;
    private $temperatureF;


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
     * @return string
     */
    public function getMainCondition()
    {
        $endpoint = 'api.openweathermap.org/data/2.5/weather?q='.$this->location.'&APPID='.$this->key.'&mode=json';
        $weatherData = $this->curlRequest($endpoint);

        $condition = $weatherData->weather[0]->main;
        $this->condition = $condition;

        return $this->condition;
    }


    /**
     * Get the temperature in degrees celsius
     * @return float
     */
    public function getTemperatureC()
    {
        $endpoint = 'api.openweathermap.org/data/2.5/weather?q='.$this->location.'&APPID='.$this->key.'&mode=json';
        $temperatureData = $this->curlRequest($endpoint);

        $temperatureK = $temperatureData->main->temp;
        $temperatureC = $temperatureK - 272.15;

        $this->temperatureC = $temperatureC;

        return $this->temperatureC;
    }

    /**
     * Get the temperature in degrees fahrenheit
     * @return float
     */
    public function getTemperatureF()
    {
        $endpoint = 'api.openweathermap.org/data/2.5/weather?q='.$this->location.'&APPID='.$this->key.'&mode=json';
        $temperatureData = $this->curlRequest($endpoint);

        $temperatureK = $temperatureData->main->temp;
        $temperatureF = ($temperatureK * ( 9 / 5 )) - 459.67;

        $this->temperatureF = $temperatureF;

        return $this->temperatureF;
    }


}