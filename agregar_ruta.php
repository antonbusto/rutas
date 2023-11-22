<?php
class DatabaseConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class Ruta {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertRuta($lugarInicio, $distanciaTotal, $lugarTermino, $lugaresDestacados) {
        $sqlInsertRuta = "INSERT INTO rutas (lugar_inicio, distancia_total, lugar_termino) VALUES ('$lugarInicio', '$distanciaTotal', '$lugarTermino')";

        if ($this->conn->query($sqlInsertRuta) === TRUE) {
            $rutaId = $this->conn->insert_id;

            foreach ($lugaresDestacados as $lugar) {
                $nombreLugar = $this->conn->real_escape_string($lugar['nombre']);
                $distanciaDesdeInicio = $lugar['distancia'];

                $sqlInsertLugar = "INSERT INTO lugares_destacados (nombre, distancia_desde_inicio, ruta_id) VALUES ('$nombreLugar', '$distanciaDesdeInicio', '$rutaId')";

                $this->conn->query($sqlInsertLugar);
            }

            return $rutaId;
        } else {
            return false;
        }
    }

    public function getRutaById($rutaId) {
        $sql = "SELECT * FROM rutas WHERE id = '$rutaId'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

$dbConnection = new DatabaseConnection();
$conn = $dbConnection->getConnection();

$ruta = new Ruta($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lugarInicio = $_POST['lugarInicio'];
    $distanciaTotal = $_POST['distanciaTotal'];
    $lugarTermino = $_POST['lugarTermino'];
    $lugaresDestacados = json_decode($_POST['lugaresDestacados'], true);

    $rutaId = $ruta->insertRuta($lugarInicio, $distanciaTotal, $lugarTermino, $lugaresDestacados);

    if ($rutaId !== false) {
        $rutaData = $ruta->getRutaById($rutaId);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruta Agregada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Ruta Agregada</h1>
    
    <?php if (isset($rutaData)): ?>
        <div class="alert alert-success" role="alert">
            Ruta agregada con éxito. Aquí están los detalles de la ruta:
            <ul>
                <li>Lugar de Inicio: <?php echo $rutaData['lugar_inicio']; ?></li>
                <li>Distancia Total: <?php echo $rutaData['distancia_total']; ?> km</li>
                <li>Lugar de Término: <?php echo $rutaData['lugar_termino']; ?></li>
            </ul>
        </div>
    
        <?php if (!empty($lugaresDestacados)): ?>
            <div class="alert alert-info" role="alert">
                Lugares Destacados:
                <ul>
                    <?php foreach ($lugaresDestacados as $lugar): ?>
                        <li><?php echo $lugar['nombre']; ?> - Distancia: <?php echo $lugar['distancia']; ?> km</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <a href="rutas.php" class="btn btn-primary">Volver a la página de gestión de rutas</a>
</div>

</body>
</html>
