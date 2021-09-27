<?php

namespace App;

class PersonData
{
    private string $name;
    private string $surname;
    private ?string $personalCode;
    private string $text;

    public function __construct(string $name, string $surname, string $personalCode, ?string $text = null)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->personalCode = $personalCode;
        $this->text = $text;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPersonalCode(): string
    {
        return $this->personalCode;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
    public function toArray(PersonData $person)
    {
        return [$person->getName(), $person->getSurname(), $person->getPersonalCode(), $person->getText()];
    }
}