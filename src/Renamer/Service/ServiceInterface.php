<?php
namespace Renamer\Service;

use Symfony\Component\Console\Style\StyleInterface;

interface ServiceInterface
{
    public function __construct(object $config, StyleInterface $io);

    public function run();
}
