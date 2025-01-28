<?php

namespace toubeelibRdv\core\services\auth;

use toubeelibRdv\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelibRdv\core\dto\AuthDTO;
use InvalidArgumentException;
use toubeelibRdv\core\domain\entities\patient\Patient;

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
