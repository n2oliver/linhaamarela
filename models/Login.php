<?php
    class Login {
        private $usuario;
        function __construct(Usuario $usuario) {
            $this->usuario = $usuario;
        }
        public function credenciaisValidas($email, $senha) {
            return $this->usuario->usuarioExiste($email) && 
                    $this->usuario->senhaExiste($senha);
        }
    }