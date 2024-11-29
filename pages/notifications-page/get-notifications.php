<?php
include("../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

// Inicializa a variável $data
$data = [];

// Recupera as notificações do banco de dados com informações do remetente
$sql = "
SELECT 
    tbcantadas.*, 
    tbusuarios.idUsuario AS remetenteId,
    tbusuarios.nomeUsuario AS remetenteNome, 
    tbusuarios.fotoPerfilUsuario AS remetenteFoto 
FROM 
    tbcantadas
INNER JOIN 
    tbusuarios 
ON 
    tbcantadas.idRemetente = tbusuarios.idUsuario
WHERE 
    tbcantadas.idDestinatario = $idUsuario
ORDER BY 
    tbcantadas.idCantada DESC
";
$result = mysqli_query($conection, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(["success" => true, "data" => $data]);
} else {
    // Caso não haja resultados, retorna um array vazio
    echo json_encode(["success" => true, "data" => $data]);
}
?>

