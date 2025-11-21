<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2048 Feo</title>
    <style>
        /* --- ESTILO BÁSICO --- */
        body {
            font-family: 'Times New Roman', serif;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        h1 {
            color: black;
            font-size: 40px;
            text-decoration: underline;
        }

        .header {
            width: 400px;
            margin-bottom: 10px;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        /* --- TABLERO --- */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, 1fr);
            gap: 5px;
            /* Un poco más de hueco para que se vea la rejilla */
            background-color: black;
            border: 5px solid black;
            width: 400px;
            height: 400px;
        }

        .cell {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            font-weight: bold;
            color: black;
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>JUEGO 2048</h1>
    </div>

    <div class="grid" id="grid-container"></div>

    <!-- CORRECCIÓN 1: Etiqueta script limpia -->
    <script>
        // 1. Definimos el ARRAY
        let grid = Array(16).fill(0);

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

            // CORRECCIÓN 3: Código ordenado para evitar errores de comentarios
            for (let i = 0; i < grid.length; i++) {
                let valor = grid[i];
                let contenido = '';

                if (valor > 0) {
                    contenido = valor;
                }

                htmlCompleto += `<div class="cell">${contenido}</div>`;
            }
            contenedor.innerHTML = htmlCompleto;
        }

        // Arrancar el juego
        initGame();

    </script> <!-- CORRECCIÓN 2: Etiqueta de cierre añadida -->
</body>
</html>
