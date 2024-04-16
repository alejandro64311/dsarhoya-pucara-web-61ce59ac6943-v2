<?php

namespace AppBundle\Command;

use AppBundle\Services\MineService;
use AppBundle\Services\WeatherService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    private $weatherService;
    private $mineService;

    public function __construct(WeatherService $weatherService, MineService $mineService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
        $this->mineService = $mineService;
    }

    protected function configure()
    {
        $this
            ->setName('app:test')
            // ->setDescription('...')
            // ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $argument = $input->getArgument('argument');

        // if ($input->getOption('option')) {
        //     // ...
        // }

        $mine = $this->mineService->getMineBySubdomain('pucara_caserones');
        $weather = $this->weatherService->getWeatherInfo($mine, 'planta_piloto', false);
        dump($weather);

        $output->writeln('Command result.');
    }
}
