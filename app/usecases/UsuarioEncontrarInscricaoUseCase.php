<?php
namespace App\UseCases;
use App\Repository\UsuarioRepository;

class UsuarioEncontrarInscricaoUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function execute($attributes) {
        return $this->repository->findInscricao($attributes);
    }
}