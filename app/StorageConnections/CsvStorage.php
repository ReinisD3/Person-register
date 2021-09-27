<?php

namespace App\StorageConnections;

use App\PersonData;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvStorage implements Connection
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function save(PersonData $person): void
    {
        $writer = Writer::createFromPath($this->filename, 'a+');
        $writer->setDelimiter(';');
        $writer->insertOne($person->toArray($person));
    }

    public function getByPersonalCode(string $personalCode): ?PersonData
    {
        $reader = Reader::createFromPath($this->filename, 'r');
        $reader->setDelimiter(';');

        $stmt = (new Statement())
            ->where(function (array $person) use ($personalCode) {
                if ($person[2] === $personalCode) return $person;
            })
            ->limit(1);

        $personData = $stmt->process($reader)->fetchOne();

        return empty($personData) ? null : new PersonData(
            $personData[0],
            $personData[1],
            $personData[2],
            $personData[3],
        );

    }

    public function delete(PersonData $person): void
    {
        $reader = Reader::createFromPath($this->filename, 'r');
        $reader->setDelimiter(';');

        $stmt = (new Statement())
            ->where(function (array $persons) use ($person) {
                if ($persons[2] !== $person->getPersonalCode())
                    return $person;
            });


        $personsData = $stmt->process($reader);

        $copy = json_decode(json_encode($personsData), true);

        $writer = Writer::createFromPath($this->filename, 'w+');
        $writer->setDelimiter(';');
        $writer->insertall($copy);

    }
}