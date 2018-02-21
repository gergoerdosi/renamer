<?php
namespace Renamer\Service;

use Symfony\Component\Console\Style\StyleInterface;

/**
 * Service interface.
 */
interface ServiceInterface
{
    /**
     * Constructor.
     *
     * @param object $config The configuration object.
     * @param StyleInterface $io The SymfonyStyle helper object.
     */
    public function __construct(object $config, StyleInterface $io);

    /**
     * Executes the service.
     */
    public function run();
}
