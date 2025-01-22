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
            return $this->client->get('praticiens/' . $id);
        }
        catch (ClientException $e) {
            throw new \Exception('Erreur lors de la récupération du praticien');
        }
        catch (ConnectException $e) {
            throw new \Exception('Erreur lors de la connexion au serveur');
        }
        catch (ServerException $e) {
            throw new \Exception('Erreur serveur');
        }
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            return $this->client->get('specialites/' . $id);
        }
        catch (ClientException $e) {
            throw new \Exception('Erreur lors de la récupération de la spécialité');
        }
        catch (ConnectException $e) {
            throw new \Exception('Erreur lors de la connexion au serveur');
        }
        catch (ServerException $e) {
            throw new \Exception('Erreur serveur');
        }
    }
}