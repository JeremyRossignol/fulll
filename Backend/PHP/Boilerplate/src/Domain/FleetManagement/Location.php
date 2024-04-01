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
    private string $gps_coordinates;

    /**
     * Constructs the Location
     *
     * @param  string $gps_coordinates The name of the Location
     */
    public function __construct(string $gps_coordinates)
    {
        $this->gps_coordinates = $gps_coordinates;
    }

    /**
     * Get the gps coordinates of the Location
     *
     * @return string the gps coordinates of the Location
     */
    public function getGpsCoordinates(): string
    {
        return $this->gps_coordinates;
    }
}
