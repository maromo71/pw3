<?php
// Classe para representar um médico
class Medico
{
    public $id;
    public $nome;
    public $crm;
    public $especialidades = [];

    public function __construct($id = null, $nome = null, $crm = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->crm = $crm;
    }
}
?>