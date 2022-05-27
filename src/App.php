<?php
namespace App;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Routes;

class App {
    private $app;
    public function run() {
        $this->app = AppFactory::create();

        $container = $this->app->getContainer();
        $capsule = new Manager;
        require __DIR__ . '/../config/database.php';
        
        $routes = new Routes;
        $this->app = $routes->run($this->app);
        $this->app->run();
    }
}