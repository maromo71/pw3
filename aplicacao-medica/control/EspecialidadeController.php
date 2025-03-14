<?php
require_once 'model/EspecialidadeModel.php';

class EspecialidadeController {

    private $especialidadeModel;

    public function __construct() {
        $this->especialidadeModel = new EspecialidadeModel();
    }

    public function listarEspecialidades() {
        $especialidades = $this->especialidadeModel->getAllEspecialidades();
        include 'view/lista_especialidades.php';
    }


     public function cadastrarEspecialidade() {
        include 'view/cadastro_especialidade.php'; //Crie este arquivo
    }

     public function salvarEspecialidade() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            if ($this->especialidadeModel->createEspecialidade($nome)) {
                // Redirecionar para a lista de especialidades com mensagem de sucesso
                $mensagem = "Especialidade '$nome' cadastrada com sucesso.";
                $especialidades = $this->especialidadeModel->getAllEspecialidades(); //Recarregar
                include 'view/lista_especialidades.php';
                exit;
            } else {
                // Tratar erro
                echo "Erro ao salvar.";
            }
        }
    }


    public function editarEspecialidade()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $especialidade = $this->especialidadeModel->getEspecialidadeById($id);

            if ($especialidade) {
                include 'view/cadastro_especialidade.php'; // Reutilize o formulário
            } else {
                // Tratar caso a especialidade não seja encontrada (redirecionar ou mensagem)
                echo "Especialidade não encontrada.";
            }
        } else {
            // Tratar ausência de ID (redirecionar)
             header("Location: ?action=listarEspecialidades");
             exit;
        }
    }


     public function atualizarEspecialidade()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nome = $_POST['nome'];

            if ($this->especialidadeModel->updateEspecialidade($id, $nome)) {
                $mensagem = "Especialidade atualizada com sucesso";
                $especialidades = $this->especialidadeModel->getAllEspecialidades(); //Recarregar
                include 'view/lista_especialidades.php';
                exit;

            } else {
                // Tratar erro
                echo "Erro ao atualizar.";
            }
        }
    }



     public function excluirEspecialidade()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->especialidadeModel->deleteEspecialidade($id)) {
                $mensagem = "Especialidade excluída com sucesso";
                $especialidades = $this->especialidadeModel->getAllEspecialidades(); //Recarregar
                include 'view/lista_especialidades.php'; //Redireciona e mostra mensagem
                exit;
            } else {
                // Tratar erro.  Idealmente, exibir uma mensagem amigável.
                echo "Erro ao excluir a especialidade.  Pode haver médicos vinculados a ela.";
            }
        }
    }

}