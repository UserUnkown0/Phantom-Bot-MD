<?php
session_start();
$qrImage = "public/qr.png"; // Ruta de la imagen generada por el bot
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phantom Bot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #efeae2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 40px;
            box-shadow: 10px 4px 15px rgba(0, 0, 0, 0.1);
            width: 800px;
            max-width: 90%;
            border: 3px solid black;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .instructions {
            text-align: left;
            font-size: 16px;
            width: 55%;
        }
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        img {
            width: 300px;
            height: auto;
            border: 2px solid black;
            border-radius: 10px;
        }
        .checkbox {
            display: flex;
            align-items: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .checkbox input {
            margin-right: 8px;
        }
        .btn {
            display: inline-block;
            background-color: #0b81ff;
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 10px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #0969d9;
        }
        .footer {
            font-size: 12px;
            color: gray;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="instructions">
            <h1>Inicia sesión con Phantom Bot</h1>
            <p>1. Abre WhatsApp en tu teléfono.</p>
            <p>2. Toca Menú en Android o Ajustes en iPhone.</p>
            <p>3. Toca <strong>Dispositivos vinculados</strong> y, luego, <strong>Vincular un dispositivo</strong>.</p>
            <p>4. Apunta tu teléfono hacia esta pantalla para escanear el código QR.</p>

            <a href="#" class="btn">Iniciar sesión con número de teléfono</a>
        </div>

        <div class="qr-section">
            <img id="qr-image" src="<?= htmlspecialchars($qrImage) ?>" alt="Código QR">
            <div class="checkbox">
                <input type="checkbox" checked> <span>Mantener la sesión iniciada en este navegador</span>
            </div>
        </div>
    </div>

    <div class="footer">
        Tus mensajes personales están cifrados de extremo a extremo
    </div>

    <script>
        function refreshQR() {
            document.getElementById('qr-image').src = '<?= htmlspecialchars($qrImage) ?>?t=' + new Date().getTime();
        }
        setInterval(refreshQR, 5000); // Actualiza la imagen cada 5 segundos

        function checkBotStatus() {
            fetch('check_status.php') // Verifica si el bot está conectado
                .then(response => response.json())
                .then(data => {
                    if (data.status === "connected") {
                        window.location.href = "loading.php"; // Redirige a la página de carga
                    }
                })
                .catch(error => console.error("Error verificando el estado:", error));
        }
        setInterval(checkBotStatus, 3000); // Verifica el estado cada 3 segundos
    </script>
</body>
</html>
