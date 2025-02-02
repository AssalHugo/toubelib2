<?php

namespace toubeelibRdv\infrastructure\adaptateur;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use toubeelibRdv\core\dto\PraticienDTO;
use toubeelibRdv\core\dto\SpecialiteDTO;
use toubeelibRdv\core\services\praticien\PraticienServiceInterface;

class PraticienServiceAdaptateur implements PraticienServiceInterface
{

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }


    public function getPraticienById(string $id): PraticienDTO
    {

        try {
            $praticienResponse = $this->client->get('praticiens/' . $id);

            $praticien = json_decode($praticienResponse->getBody()->getContents());

            return PraticienDTO::createFromStdClass($praticien);
        }
        catch (ClientException $e) {
            throw new \Exception('Erreur lors de la récupération du praticien');
        }
        catch (ConnectException $e) {
            throw new \Exception('Erreur lors de la connexion au serveur'. $e->getMessage());
        }
        catch (ServerException $e) {
            throw new \Exception('Erreur serveur');
        }
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialiteResponse = $this->client->get('specialites/' . $id);

            $specialite = json_decode($specialiteResponse->getBody()->getContents());

            return new SpecialiteDTO($specialite->specialite->ID, $specialite->specialite->label, $specialite->specialite->description);

        }
        catch (ClientException $e) {
            throw new \Exception('Erreur lors de la récupération de la spécialité' . $e->getMessage());
        }
        catch (ConnectException $e) {
            throw new \Exception('Erreur lors de la connexion au serveur');
        }
        catch (ServerException $e) {
            throw new \Exception('Erreur serveur' . $e->getMessage());
        }
    }
}