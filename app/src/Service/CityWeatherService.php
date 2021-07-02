<?php


namespace App\Service;


use App\Client\AccuWeather\Client;
use App\Model\CityWeatherModel;
use App\Repository\CityWeatherRepository;

class CityWeatherService
{
    public function __construct(
        private Client $accuWeatherClient,
        private CityWeatherModel $cityWeatherModel,
        private CityWeatherRepository $cityWeatherRepository
    ){}

    public function addTodaysWehater(): void
    {
        $this->addCityCodeIfNotExist();

        $cities = $this->cityWeatherRepository->findAll();
        foreach ($cities as $city){
            $cityWeather = $this->getTodaysWeather($city->getCityCode());
            $this->cityWeatherModel->setTodaysTemp($cityWeather, $city);
        }
    }

    private function addCityCodeIfNotExist(): void
    {
        $cities = $this->cityWeatherRepository->findAll();
        foreach ($cities as $city){
            if($city->getCityCode() === null){
                $cityKey = $this->accuWeatherClient->getCityCode($city->getCity());
                $this->cityWeatherModel->addNewCityCode($city->getCity(), $cityKey);
            }
        }
    }

    private function getTodaysWeather(string $cityCode)
    {
        return $this->accuWeatherClient->getCityWeather($cityCode);
    }
}
