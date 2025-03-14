<?php
// Página inicial, que redireciona para a página de login
require_once 'control/LoginController.php';
require_once 'control/MedicoController.php';
require_once 'control/EspecialidadeController.php';


$loginController = new LoginController();
$medicoController = new MedicoController();
$especialidadeController = new EspecialidadeController();


// Roteamento simples (muito básico)
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'login':
        $loginController->login();
        break;
    case 'logout':
        $loginController->logout();
        break;
    case 'listarMedicos':
        $loginController->checkLogin(); //Verifica se está logado
        $medicoController->listarMedicos();
        break;
    case 'cadastrarMedico':
        $loginController->checkLogin();
        $medicoController->cadastrarMedico();
        break;
    case 'salvarMedico':
        $loginController->checkLogin();
        $medicoController->salvarMedico();
        break;
    case 'editarMedico':
        $loginController->checkLogin();
        $medicoController->editarMedico();
        break;
    case 'atualizarMedico':
        $loginController->checkLogin();
        $medicoController->atualizarMedico();
        break;

    case 'excluirMedico':
        $loginController->checkLogin();
        $medicoController->excluirMedico();
        break;

        //Especialidades
    case 'listarEspecialidades':
        $loginController->checkLogin();
        $especialidadeController->listarEspecialidades();
        break;

    case 'cadastrarEspecialidade':
        $loginController->checkLogin();
        $especialidadeController->cadastrarEspecialidade();
        break;

    case 'salvarEspecialidade':
        $loginController->checkLogin();
        $especialidadeController->salvarEspecialidade();
        break;

    case 'editarEspecialidade':
        $loginController->checkLogin();
        $especialidadeController->editarEspecialidade();
        break;

    case 'atualizarEspecialidade':
        $loginController->checkLogin();
        $especialidadeController->atualizarEspecialidade();
        break;

    case 'excluirEspecialidade':
        $loginController->checkLogin();
        $especialidadeController->excluirEspecialidade();
        break;

    default:
        // Se estiver logado, mostra a página inicial, senão, o login
        if (isset($_SESSION['usuario'])) {
            include 'view/includes/header.php'; //Conteúdo da home
            echo "<h2>Bem-vindo, " . htmlspecialchars($_SESSION['usuario']) . "!</h2>";
            //Mostrar informações, links, etc.
            include 'view/includes/footer.php';
        } else {
            $loginController->login(); //Chama o form de login
        }
}
