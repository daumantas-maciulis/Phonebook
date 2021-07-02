<?php


namespace App\Service;


use App\Client\AccuWeather\Client;
use App\Model\CityWeatherModel;

class CityWeatherService
{
    public function __construct(
        private Client $accuWeatherClient,
        private CityWeatherModel $cityCodeModel
    ){}

    public function addCityCodeIfNotExist(string $city): void
    {
        $cityKey = $this->accuWeatherClient->getCityCode($city);
        $this->cityCodeModel->addNewCityCode($city, $cityKey);
    }

    public function getTodaysWeather(string $cityCode)
    {
        return $this->accuWeatherClient->getCityWeather('231459');
    }



}