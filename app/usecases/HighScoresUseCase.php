<?php
namespace App\UseCases;
use App\Repository\UsuarioRepository;

class HighScoresUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function execute($userId) {
        return $this->repository->getHighScores($userId);
    }

}