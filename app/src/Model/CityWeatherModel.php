<?php


namespace App\Model;


use App\Entity\CityWeather;
use App\Repository\CityWeatherRepository;
use Doctrine\ORM\EntityManagerInterface;

class CityWeatherModel
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CityWeatherRepository $cityWeatherRepository
    )
    {
    }

    private function saveData(CityWeather $newCityWeather): void
    {
        $this->entityManager->persist($newCityWeather);
        $this->entityManager->flush();
    }

    public function addNewCityCode(string $city, string $cityCode): void
    {
        $newCityCode = new CityWeather();

        $newCityCode->setCity($city);
        $newCityCode->setCityCode($cityCode);

        $this->saveData($newCityCode);
    }

    public function addNewCity(string $city): void
    {
        $cityFromDb = $this->cityWeatherRepository->findOneBy(['city' => $city]);
        if(!$cityFromDb) {
            $newCity = new CityWeather();
            /** @var string $city */
            $newCity->setCity($city);
        }
        $this->saveData($newCity);
    }


}