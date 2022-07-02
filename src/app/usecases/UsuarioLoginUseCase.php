<?php
namespace App\UseCases;
use App\Repository\LoginRepository;

class UsuarioLoginUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new LoginRepository();
    }

    public function execute($attributes) {
        return $this->repository->insert($attributes);
    }
}