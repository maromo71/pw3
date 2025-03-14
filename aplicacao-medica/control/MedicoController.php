<?php
require_once 'model/MedicoModel.php';
require_once 'model/EspecialidadeModel.php';


class MedicoController {

    private $medicoModel;
    private $especialidadeModel;


    public function __construct() {
        $this->medicoModel = new MedicoModel();
        $this->especialidadeModel = new EspecialidadeModel(); //Para buscar as especialidades no cadastro
    }

    public function listarMedicos() {
        $medicos = $this->medicoModel->getAllMedicos();
        include 'view/lista_medicos.php';
    }

    public function cadastrarMedico() {
        $especialidades = $this->especialidadeModel->getAllEspecialidades();
        include 'view/cadastro.php';
    }


     public function salvarMedico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $crm = $_POST['crm'];
            $especialidadesIds = isset($_POST['especialidades']) ? $_POST['especialidades'] : [];

            if ($this->medicoModel->createMedico($nome, $crm, $especialidadesIds)) {
                header("Location: ?action=listarMedicos"); // Redireciona após sucesso
                exit;
            } else {
                // Tratar erro (ex: exibir mensagem)
                 $especialidades = $this->especialidadeModel->getAllEspecialidades(); //Para recarregar o form
                include 'view/cadastro.php';
            }
        }
    }


    public function editarMedico(){
        if(isset($_GET['id'])){
            $medicoId = $_GET['id'];
            $medico = $this->medicoModel->getMedicoById($medicoId);
            $especialidades = $this->especialidadeModel->getAllEspecialidades();
            include 'view/cadastro.php'; //Reúsa a view de cadastro
        } else {
            header("Location: ?action=listarMedicos"); //Redireciona se não tiver ID
            exit;
        }
    }

    public function atualizarMedico(){
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];  //ID vem do campo hidden do form
            $nome = $_POST['nome'];
            $crm = $_POST['crm'];
            $especialidadesIds = isset($_POST['especialidades']) ? $_POST['especialidades'] : [];


            if ($this->medicoModel->updateMedico($id, $nome, $crm, $especialidadesIds)) {
                header("Location: ?action=listarMedicos");
                exit;
            } else {
                 $especialidades = $this->especialidadeModel->getAllEspecialidades();
                 $medicoId = $id; //Para manter o ID no form
                  include 'view/cadastro.php';// Tratar erro (ex: exibir mensagem)
            }
        }
    }

     public function excluirMedico() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->medicoModel->deleteMedico($id)) {
                header("Location: ?action=listarMedicos");
                exit;
            } else {
                // Tratar erro
                echo "Erro ao excluir.";
            }
        }
    }
}
?>