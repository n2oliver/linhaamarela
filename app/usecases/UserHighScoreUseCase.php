<?php
namespace App\UseCases;
use App\Repository\UsuarioRepository;

class UserHighScoreUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function execute($userId, $userPoints) {
        if(count($this->repository->getCurrentHighScore($userId)) == 0 || count($this->repository->getPreviousHighScore($userId, $userPoints)) < 1) {
            return $this->repository->setHighScore($userId, $userPoints);
        }
        return json_encode([]);
    }

}