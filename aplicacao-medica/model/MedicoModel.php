<?php
// Lógica de acesso a dados de médicos
require_once 'Database.php';
require_once 'Medico.php';
require_once 'Especialidade.php';

class MedicoModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    // Demais funções copiem do github
    public function getAllMedicos()
    {
        $query = "SELECT m.id, m.nome, m.crm,
                             GROUP_CONCAT(e.id, ':', e.nome SEPARATOR ';') 
                             as especialidades
                      FROM medicos m
                      LEFT JOIN medico_especialidade me ON m.id = me.medico_id
                      LEFT JOIN especialidades e ON me.especialidade_id = e.id
                      GROUP BY m.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $medicos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $medico = new Medico($row['id'], $row['nome'], $row['crm']);

            // Processar as especialidades (se houver)
            if ($row['especialidades']) {
                $especialidadesData = explode(';', $row['especialidades']);
                foreach ($especialidadesData as $especialidadeData) {
                    list($espId, $espNome) = explode(':', $especialidadeData);
                    $medico->especialidades[] = new Especialidade($espId, $espNome);
                }
            }
            $medicos[] = $medico;
        }
        return $medicos;
    }

    public function getMedicoById($id)
    {
        $query = "SELECT m.id, m.nome, m.crm,
                         GROUP_CONCAT(e.id, ':', e.nome SEPARATOR ';') as especialidades
                  FROM medicos m
                  LEFT JOIN medico_especialidade me ON m.id = me.medico_id
                  LEFT JOIN especialidades e ON me.especialidade_id = e.id
                  WHERE m.id = :id
                  GROUP BY m.id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // Médico não encontrado
        }

        $medico = new Medico($row['id'], $row['nome'], $row['crm']);

        // Processar as especialidades (se houver)
        if ($row['especialidades']) {
            $especialidadesData = explode(';', $row['especialidades']);
            foreach ($especialidadesData as $especialidadeData) {
                list($espId, $espNome) = explode(':', $especialidadeData);
                $medico->especialidades[] = new Especialidade($espId, $espNome);
            }
        }

        return $medico;
    }

    public function createMedico($nome, $crm, $especialidadesIds)
    {
        $this->conn->beginTransaction();
        try {
            // Inserir o médico
            $query = "INSERT INTO medicos (nome, crm) VALUES (:nome, :crm)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":crm", $crm);
            $stmt->execute();
            $medicoId = $this->conn->lastInsertId();

            // Vincular especialidades
            if (!empty($especialidadesIds)) {
                $query = "INSERT INTO medico_especialidade (medico_id, especialidade_id) VALUES (:medico_id, :especialidade_id)";
                $stmt = $this->conn->prepare($query);

                foreach ($especialidadesIds as $especialidadeId) {
                    $stmt->bindParam(":medico_id", $medicoId);
                    $stmt->bindParam(":especialidade_id", $especialidadeId);
                    $stmt->execute();
                }
            }


            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Erro ao criar médico: " . $e->getMessage()); // Registrar erro em log
            return false;
        }
    }
    public function updateMedico($id, $nome, $crm, $especialidadesIds)
    {
        $this->conn->beginTransaction();
        try {
            // Atualizar dados do médico
            $query = "UPDATE medicos SET nome = :nome, crm = :crm WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":crm", $crm);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $query = "DELETE FROM medico_especialidade WHERE medico_id = :medico_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":medico_id", $id);
            $stmt->execute();
            if (!empty($especialidadesIds)) {
                $query = "INSERT INTO medico_especialidade (medico_id, especialidade_id) VALUES (:medico_id, :especialidade_id)";
                $stmt = $this->conn->prepare($query);

                foreach ($especialidadesIds as $especialidadeId) {
                    $stmt->bindParam(":medico_id", $id);
                    $stmt->bindParam(":especialidade_id", $especialidadeId);
                    $stmt->execute();
                }
            }
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Erro ao atualizar médico: " . $e->getMessage()); // Registrar erro em log
            return false;
        }
    }

    public function deleteMedico($id) {
        $this->conn->beginTransaction();
       try{
           $query = "DELETE FROM medicos WHERE id = :id";
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":id", $id);
           $stmt->execute();
           $this->conn->commit();
           return true;

       } catch (PDOException $e) {
           $this->conn->rollBack();
            error_log("Erro ao deletar médico: " . $e->getMessage()); // Registrar erro em log
           return false;
       }
   }
}

?>
