<?php


namespace App\Client\AccuWeather;

use App\Exception\BadCityException;
use \GuzzleHttp\Client as Guzzle;

class Client
{
    private const BASE_URI = 'http://dataservice.accuweather.com';
    private const API_KEY = 'KRqs7yh6kx2yWZXLJ75kL3tjnwO0UDCG';
    private const CITY_CODE_QUERY_URI = '/locations/v1/cities/search';
    private const WEATHER_QUERY_URI = '/forecasts/v1/daily/1day';

    public function getCityCode(string $city): string
    {
        $client = new Guzzle([
            'base_uri' => self::BASE_URI
        ]);

        $query = sprintf('%s?q=%s&apikey=%s', self::CITY_CODE_QUERY_URI, $city, self::API_KEY);

        $responseFromClient = $client->request('GET', $query);
        $response = json_decode($responseFromClient->getBody()->getContents(), true);
        $slug = $response[0];
        $cityKey = $slug['Key'];

        return $cityKey;
    }

    public function getCityWeather(string $cityCode): array
    {
        $client = new Guzzle([
           'base_uri' => self::BASE_URI
        ]);

        $query = sprintf('%s/%s?apikey=%s&metric=true', self::WEATHER_QUERY_URI, $cityCode, self::API_KEY);

        $responseFromClient = $client->request('GET', $query);
        $response = json_decode($responseFromClient->getBody()->getContents(), true);
        $temperature = $response['DailyForecasts']['0']['Temperature'];

        $todaysMinimum = $temperature['Minimum']['Value'];

        $todaysMaximum = $temperature['Maximum']['Value'];

        $todaysWeather = [
            'Minimum' => $todaysMinimum,
            'Maximum' => $todaysMaximum
        ];

        return $todaysWeather;
    }
}