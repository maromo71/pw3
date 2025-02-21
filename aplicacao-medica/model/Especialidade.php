<?php
    // Classe para representar uma especialidade
    class especialidade{
        public $id;
        public $nome;

        public function __construct($id = null, $nome = null){
            $this->id = $id;
            $this->nome = $nome;
        }
    }
?>