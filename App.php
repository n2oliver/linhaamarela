<?php
namespace App;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Middleware;
use App\Routes;

class App {
    private $app;
    public function run() {
        $this->app = AppFactory::create();

        $container = $this->app->getContainer();
        $capsule = new Manager;
        require __DIR__ . '/config/database.php';
        //$this->app->add(new Middleware());

        $routes = new Routes;
        $this->app = $routes->run($this->app);
        $this->app->run();
    }
}