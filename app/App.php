<?php
namespace App;

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Middleware;
use Web\Routes;
use Dotenv\Dotenv;

class App {
    private $app;
    public function run() {
        $this->app = AppFactory::create();

        $container = $this->app->getContainer();
        try {
        $capsule = new Manager;
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
            die;
        }
        
        $dotenv = Dotenv::createImmutable(__DIR__.'/../.');
        $dotenv->load();
        
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

        require __DIR__ . '/config/database.php';

        $routes = new Routes;
        $this->app = $routes->run($this->app);
        $this->app->run();
    }
}