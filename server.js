import express from 'express';
import { exec } from 'child_process';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const app = express();
const PORT = process.env.PORT || 3000;

// Ruta correcta de PHP en Replit
const phpPath = "/nix/store/mh30jsg3rmgi3177yhmfiadggwcknjr2-php-with-extensions-8.1.29/bin/php";

app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname)); // Servir archivos estáticos

// Ruta para servir index.php usando PHP
app.get('/', (req, res) => {
    exec(`${phpPath} -f "${path.join(__dirname, 'index.php')}"`, (error, stdout, stderr) => {
        if (error) {
            console.error(`❌ Error al ejecutar PHP: ${stderr || error.message}`);
            return res.status(500).send(`❌ Error al ejecutar PHP: ${stderr || error.message}`);
        }
        res.send(stdout);
    });
});

// Ruta para enviar mensajes con sendMessage.js
app.post('/send-message', (req, res) => {
    const message = req.body.message;
    if (message) {
        exec(`node sendMessage.js "${message.replace(/"/g, '\\"')}"`, (error, stdout, stderr) => {
            if (error) {
                console.error(`❌ Error al enviar mensaje: ${stderr}`);
                return res.status(500).send(`❌ Error al enviar mensaje: ${stderr}`);
            }
            res.send(`✅ Mensaje enviado: ${stdout}`);
        });
    } else {
        res.status(400).send('⚠️ Mensaje vacío.');
    }
});

app.listen(PORT, () => {
    console.log(`✅ Servidor web en ejecución en http://localhost:${PORT}`);
});
