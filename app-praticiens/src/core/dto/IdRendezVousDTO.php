<?php

namespace toubeelibPraticien\core\dto;

class IdRendezVousDTO extends DTO
{

    protected string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}