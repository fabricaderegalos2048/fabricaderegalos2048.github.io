<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>2048 Feo</title>
    
    <style>
        /* --- ESTILO BÁSICO Y FEO --- */
        body {
            font-family: 'Times New Roman', serif; /* Fuente aburrida */
            background-color: white; /* Fondo blanco nuclear */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        h1 {
            color: black;
            font-size: 40px;
            text-decoration: underline; /* Subrayado anticuado */
        }
        
        .header {
            width: 400px;
            margin-bottom: 10px;
            border: 1px solid black;
            padding: 10px;
        }

        .score-box {
            font-weight: bold;
        }

        /* --- TABLERO TIPO EXCEL FEO --- */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, 1fr);
            /* Sin gap para que parezca una tabla vieja, o un gap negro feo */
            gap: 2px; 
            background-color: black; /* Las líneas de separación */
            border: 5px solid black;
            width: 400px;
            height: 400px;
        }
        
        .cell {
            background-color: white; /* Celdas blancas */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            font-weight: bold;
            color: black;
        }

        /* Quitamos los colores bonitos, ahora solo detectamos si está llena */
        /* Si tiene contenido, quizás le ponemos un fondo gris triste */
        .cell:not(:empty) {
            /* background-color: #ccc; Opcional si quieres gris */
        }

        /* --- CONTROLES --- */
        .controls { 
            margin-top: 20px; 
            padding: 10px;
            border: 1px dashed black;
        }
        
        /* Botones por defecto del navegador (feos) */
        button {
            font-size: 14px;
            cursor: pointer;
            /* Sin estilos CSS extra para que se vean como botones de Windows 95 */
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>JUEGO 2048</h1>
    </div>

    <div class="grid" id="grid-container">
        </div>

    
    <

    <script>
        // 1. Definimos el ARRAY
        let grid = Array(16).fill(0);

        // CORRECCIÓN: He llamado a la función initGame para que coincida con tu botón HTML
        function initGame() {
            grid = Array(16).fill(0);
            
            agregarNumeroAleatorio();
            agregarNumeroAleatorio();
            
            dibujarTablero();
        }

        function agregarNumeroAleatorio() {
            let vacios = [];
            for (let i = 0; i < grid.length; i++) {
                if (grid[i] === 0) vacios.push(i);
            }
            if (vacios.length === 0) return;
            let indiceAleatorio = vacios[Math.floor(Math.random() * vacios.length)];
            grid[indiceAleatorio] = Math.random() > 0.9 ? 4 : 2;
        }

        function dibujarTablero() {
            const contenedor = document.getElementById('grid-container');
            let htmlCompleto = '';

            for (let i = 0; i < grid.length; i++) {
                let valor = grid[i];
                let contenido = '';
                
                // Ya no usamos clases de colores, solo ponemos el número
                if (valor > 0) {
                    contenido = valor;
                }
                
                // Simple div blanco con borde negro
                htmlCompleto += `<div class="cell">${contenido}</div>`;
            }
            contenedor.innerHTML = htmlCompleto;
        }
        
        // Arrancar
        initGame();

        function saveGame() {
            alert("Guardar (aún no implementado)");
        }
    </script>
</body>
</html>