<?php


namespace App\Command;


use App\Service\CityWeatherService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCityWeatherCommand extends Command
{
    protected static $defaultName = 'app:update-city-weather-temperatures';

    public function __construct(
        private CityWeatherService $cityWeatherService,
        string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Updates city weather temperatures');
        $this->setHelp('Loops through cityWeather table and adds city codes and today`s weather minimum and maximum temperatures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting to update weather temperatures');
        $this->cityWeatherService->addTodaysWehater();

        $output->writeln('Temperatures were updated');

        return Command::SUCCESS;
    }
}