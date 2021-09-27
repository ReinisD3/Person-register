<?php

namespace App\StorageConnections;

use App\PersonData;

interface Connection
{
    public function save(PersonData $person):void;
    public function getByPersonalCode(string $personalCode): ?PersonData;
    public function delete(PersonData $person) : void;

}