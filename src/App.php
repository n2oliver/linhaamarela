<?php
namespace App;
use Slim\Factory\AppFactory;
use \Illuminate\Database\Capsule\Manager;
use App\Routes;

class App {
    private $app;
    public function __construct () {
        $this->app = AppFactory::create();
    }
    private function build() {
        $container = $this->app->getContainer();
        $capsule = new Manager;
        require __DIR__ . '/../config/database.php';
        return $this->app;
    }
    public function run() {
        $this->app = $this->build();
        $routes = new Routes;
        $this->app = $routes->run($this->app);
        $this->app->run();
    }
}