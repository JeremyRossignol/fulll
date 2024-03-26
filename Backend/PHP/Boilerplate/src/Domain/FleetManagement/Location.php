<?php

declare(strict_types=1);

namespace Fulll\Domain\FleetManagement;

/**
 * A location
 *
 * @author Jérémy Rossignol [2024-03-25 12:15]
 */
class Location
{
    /**
     * Location name
     *
     * @var string
     */
    private string $name;

    /**
     * Constructs the Location
     *
     * @param  string $name The name of the Location
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of the Location
     *
     * @return string the name of the Location
     */
    public function getName(): string
    {
        return $this->name;
    }
}
