<?php

namespace toubeelib_rdv\core\services\auth;

use toubeelib_rdv\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib_rdv\core\dto\AuthDTO;
use InvalidArgumentException;
use toubeelib_rdv\core\domain\entities\patient\Patient;

class AuthService
{
    private PatientRepositoryInterface $userRepository;

    public function __construct(PatientRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyCredentials(string $email, string $password): AuthDTO
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new InvalidArgumentException('Invalid credentials');
        }

        return new AuthDTO(
            $user->getId(),
            $user->getEmail(),
            $user->getRole(),
            '',
            ''  
        );
    }
}
