<?php
// Este código PHP NÃO faz parte do seu sistema principal.  É apenas um
// pequeno script para gerar o hash da senha que você irá colocar
// manualmente no seu `database.sql`.  Execute-o *uma vez*, copie
// o hash gerado, e coloque no seu arquivo SQL.

$senha = 'admin123'; // A senha que você quer usar (mude para uma senha forte!)
$hash = password_hash($senha, PASSWORD_DEFAULT); // Usa o algoritmo padrão (atualmente bcrypt)

echo "Hash da senha '$senha':\n";
echo $hash . "\n";
echo "Copie este hash e coloque no seu arquivo database.sql no comando INSERT.\n";

// Saída de exemplo (o hash real será diferente):
// Hash da senha 'admin123':
// $2y$10$8sL84u19Y.9/R5H.2i/oG.h.zJ/s9uK8s1L.t4o.a5b2s7c9d3f8e
// Copie este hash e coloque no seu arquivo database.sql no comando INSERT.

?>