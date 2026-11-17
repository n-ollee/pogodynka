<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Get weather for location',
)]
class WeatherLocationCommand
{
    public function __construct(
        private WeatherUtil $weatherUtil,
        private LocationRepository $locationRepository,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        $location = $this->locationRepository->find($id);

        if ($location === null) {
            $io->error(sprintf('Location with ID %d not found.', $id));

            return Command::FAILURE;
        }

        $measurements = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s', $location->getCity()));

        $io->table(
            ['Date', 'Temperature'],
            array_map(fn($m) => [
                $m->getDate()->format('Y-m-d'),
                $m->getCelsius(),
            ], $measurements)
        );

        return Command::SUCCESS;
    }
}
