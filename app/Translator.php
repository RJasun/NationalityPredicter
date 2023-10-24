<?php

namespace App;

use GuzzleHttp\Client;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Translator
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getNationalityData(string $name): object
    {
        $response = $this->client->get('https://api.nationalize.io?name=' . $name);
        return json_decode($response->getBody()->getContents());
    }

    public function getTranslatedMessage(string $name, string $surname): string
    {
        $nameData = $this->getNationalityData($name);
        $surnameData = $this->getNationalityData($surname);

        $countryOfName = $nameData->country[0]->country_id;
        $countryOfSurname = $surnameData->country[0]->country_id;

        $namePlace = new GoogleTranslate($countryOfName);
        $surnamePlace = new GoogleTranslate($countryOfSurname);

        if ($countryOfName !== $countryOfSurname) {
            return $namePlace->translate("Its a chance I speak this written language.") . ' ' .
                $surnamePlace->translate("And in this written language.");
        } else {
            return $namePlace->translate("Its a chance I speak this written language.");
        }
    }
}