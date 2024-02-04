<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Db\Eloquent\Models\Usuario;
use Db\Eloquent\Models\Login;
use App\UseCases\UsuarioEncontrarUseCase;
use App\UseCases\UsuarioLoginUseCase;
use \Firebase\JWT\JWT;
use \Stripe\StripeClient;

class UsuarioLoginController {
    private $encontrarUsuario;
    private $logarUsuario;
    
    public function __construct() {
        $this->encontrarUsuario = new UsuarioEncontrarUseCase();
        $this->logarUsuario = new UsuarioLoginUseCase();
    }
    public function postLogin(Request $request, Response $response, $args) {
        date_default_timezone_set('America/Sao_Paulo');

        $formData = $request->getParsedBody();

        $expirationTimestamp = time() + 28800;
        $date = new \DateTime();
        $date->setTimestamp($expirationTimestamp);
        $formData['data_expiracao'] = $date->format('Y-m-d H:i:s');

        $usuario = $this->encontrarUsuario->execute($formData);
        
        if($usuario != null) {

            $hash = JWT::encode(array('id'=> $usuario->nomedeusuario, 'senha' => $usuario->senha, 'data_de_expiracao' => $expirationTimestamp), 'wyelow', 'HS256');
            $formData['usuario_id'] = $usuario->id;
            $formData['hash'] = $hash;

            try {
                $this->logarUsuario->execute($formData);
            } catch (\Exception $error) {
                echo $error;
                $response->getBody()->write($error);
                return $response
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(400);
                if(strpos($error->getMessage(), "Duplicate entry")) {
                    $response->getBody()->write("Login já realizado!");
                    return $response
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
                }
            }

            $stripe = new \Stripe\StripeClient('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');
            $possuiOJogo = false;
            $customer = $stripe->customers->search(['query' => 'email:"'. $usuario->email . '"']);
            if (!isset($customer->data[0])) {
                $response->getBody()->write("Você ainda não possui este jogo. Para obtê-lo visite https://meiodiagames.herokuapp.com");
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            $paymentIntent = $stripe->paymentIntents->search(['query' => 'customer:"'. $customer->data[0]->id . '"']);
            foreach ($paymentIntent->data as $intent) {
                $paymentIntentDetail = $stripe->checkout->sessions->all(['payment_intent' => $intent->id,'expand' => ['data.line_items']]);
                $charges = $stripe->charges->all(['customer' => $customer->data[0]->id, 'payment_intent' => $intent->id]);
                foreach($paymentIntentDetail->data[0]->line_items->data as $item) {
                    
                    if($item['description'] === 'Linha Amarela') {
                        $possuiOJogo = true;
                    }
                }
            }
            if(!$possuiOJogo) {
                $response->getBody()->write("Você ainda não possui este jogo. Para obtê-lo visite https://meiodiagames.herokuapp.com");
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            setcookie('session', $hash, $expirationTimestamp);
            $usuario->_token = $hash;
            $usuario->expiraEm = $expirationTimestamp;
            
            $payload = json_encode($usuario);
            $response->getBody()->write($payload);
            
            return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(201);
        }
        $response->getBody()->write("Verifique o nome de usuário ou senha!");
        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
    }
}