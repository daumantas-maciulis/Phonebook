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
        $cityFromDb = $this->cityWeatherRepository->findOneBy(['city' => $city]);
        dump($cityFromDb);
        if (!$cityFromDb) {
            $newCityCode = new CityWeather();

            $newCityCode->setCity($city);
            $newCityCode->setCityCode($cityCode);

            $this->saveData($newCityCode);
        }

        $cityFromDb->setCity($city);
        $cityFromDb->setCityCode($cityCode);

        $this->saveData($cityFromDb);
    }

    public function addNewCity(string $city): void
    {
        $cityFromDb = $this->cityWeatherRepository->findOneBy(['city' => $city]);
        if (!$cityFromDb) {
            $newCity = new CityWeather();
            /** @var string $city */
            $newCity->setCity($city);
        $this->saveData($newCity);
        }
    }

    public function setTodaysTemp(array $cityWeather, CityWeather $city)
    {
        $city->setMinimumTemperature($cityWeather['Minimum']);
        $city->setMaximumTemperature($cityWeather['Maximum']);

        $this->saveData($city);
    }


}