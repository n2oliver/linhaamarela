<?php
namespace App\UseCases;
use App\Repository\UsuarioRepository;

class UsuarioInscreverUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function execute($attributes) {
        $this->repository->insert($attributes);
    }
}