<?php
    //Controller de login e sessão
    session_start();
    require_once 'model/Database.php';  //Não precisa do autoload, pois as classes do model não são usadas diretamente aqui
    
    
    class LoginController {
    
        private $conn;
    
        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    
    
            public function login() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $usuario = $_POST['usuario'];
                    $senha = $_POST['senha'];
        
                    $query = "SELECT id, usuario, senha FROM usuarios WHERE usuario = :usuario";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':usuario', $usuario);
                    $stmt->execute();
        
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if ($user && password_verify($senha, $user['senha'])) {
                        // Login bem-sucedido
                        $_SESSION['usuario'] = $user['usuario'];
                        $_SESSION['user_id'] = $user['id'];  //Armazena o ID do usuário na sessão
                        header("Location: index.php"); // Redireciona para a página principal (logada)
                        exit;
                    } else {
                    // Credenciais inválidas
                    $erro = "Usuário ou senha inválidos.";
                    include 'view/login.php'; // Exibe o formulário de login novamente com a mensagem de erro
                }
            } else {
                // Exibe o formulário de login
                include 'view/login.php';
            }
        }
    
        public function logout() {
            session_destroy();
            header("Location: index.php");
            exit;
        }
    
    
         public function checkLogin() {
            if (!isset($_SESSION['usuario'])) {
                header("Location: ?action=login");
                exit;
            }
        }
    }
    ?>   