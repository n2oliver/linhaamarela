<?php
namespace App;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Middleware;
use App\Routes;
use Dotenv\Dotenv;

class App {
    private $app;
    public function run() {
        $this->app = AppFactory::create();

        $container = $this->app->getContainer();
        $capsule = new Manager;
        
        $dotenv = Dotenv::createImmutable(__DIR__.'/../.');
        $dotenv->load();
        
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

        require __DIR__ . '/config/database.php';

        $routes = new Routes;
        $this->app = $routes->run($this->app);
        $this->app->run();
    }
}