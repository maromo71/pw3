<?php
//Lógica de acesso a dados de especialidades
require_once 'Database.php';
require_once 'Especialidade.php';

class EspecialidadeModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllEspecialidades()
    {
        $query = "SELECT id, nome FROM especialidades";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $especialidades = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $especialidades[] = new Especialidade($row['id'], $row['nome']);
        }
        return $especialidades;
    }
    public function createEspecialidade($nome)
    {
        $query = "INSERT INTO especialidades (nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        return $stmt->execute(); // Retorna true/false indicando sucesso/falha
    }


    public function getEspecialidadeById($id)
    {
        $query = "SELECT id, nome FROM especialidades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Especialidade($row['id'], $row['nome']);
        } else {
            return null; // Especialidade não encontrada
        }
    }
    public function updateEspecialidade($id, $nome)
    {
        $query = "UPDATE especialidades SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); //true ou false
    }


    public function deleteEspecialidade($id)
    {
        $query = "DELETE FROM especialidades WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); //true ou false
    }
}
