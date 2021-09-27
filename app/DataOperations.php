<?php

namespace App;

use League\Csv\Reader;
use League\Csv\Writer;
use League\Csv\Statement;

class DataOperations
{
    public static function loadData(string $address): array
    {

        $csv = Reader::createFromPath($address, 'r');
        $csv->setDelimiter(',');
//        $csv->setHeaderOffset(0); //set the CSV header offset


        $records = Statement::create()->process($csv);
        $data = [];

        foreach ($records as $record) {
            $data[] = new PersonData($record[0], $record[1], $record[2], $record[3] ?? '');
        }
        return $data;
    }


    public static function savePeopleData(array $allRecords, string $address): void
    {
        $recordsToSave = [];
        /** @var PersonData $record */
        foreach ($allRecords as $record) {
            $recordsToSave[] = [$record->getName(), $record->getSurname(), $record->getPersonalCode(), $record->getText() ?? ''];
        }

        $writer = Writer::createFromPath($address, 'w+');
        $writer->insertAll($recordsToSave);
    }

    public static function searchByPersonCode(string $searchedPersonCode, array $records): ?PersonData
    {
        /** @var PersonData $record */
        foreach ($records as $record) {
            if ($record->getPersonalCode() === $searchedPersonCode) return $record;
        }
        return null;
    }

    public static function deleteRecord(PersonData $recordToDelete, array $allRecords): array
    {
        foreach ($allRecords as $key => $record) {
            if ($record->getPersonalCode() === $recordToDelete->getPersonalCode()) {
                unset($allRecords[$key]);
                return $allRecords;
            }

        }
        return $allRecords;
    }
}