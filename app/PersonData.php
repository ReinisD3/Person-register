<?php

namespace App;

class PersonData
{
    private $name;
    private $surname;
    private $personalCode;
    private $text;

    public function __construct(string $name, string $surname, string $personalCode, string $text = '')
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->personalCode = $personalCode;
        $this->text = $text;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getPersonalCode(): ?string
    {
        return $this->personalCode;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}