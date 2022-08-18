<?php
namespace App\UseCases;
use App\Repository\UsuarioRepository;

class HighScoresUseCase {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function execute($userId, $page = 0) {
        $total = $this->repository->getTotalHighScores()[0]->total;
        $limit = 10;
        $pages = ceil($total / $limit);
        $previous = $page - 1;
        $next = $page + 1;
        return [
            'rows' => $this->repository->getHighScores($userId, $page * 10, $limit),
            'pages' => $pages,
            'prev' => $previous,
            'next' => $next
        ];
    }

}