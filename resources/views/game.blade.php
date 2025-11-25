<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2048 Arcade Edition</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* --- ESTILO ARCADE --- */
        :root {
            --neon-blue: #00f3ff;
            --neon-pink: #ff00ff;
            --neon-green: #0aff00;
            --neon-yellow: #ffee00;
            --bg-dark: #111;
            --bg-panel: #222;
        }

        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #050505;
            background-image: 
                linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), 
                linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            background-size: 100% 2px, 3px 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            color: white;
            text-transform: uppercase;
        }

        h1 {
            color: var(--neon-yellow);
            font-size: 35px;
            text-shadow: 4px 4px 0px #b84805;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        h3 {
            font-size: 12px;
            color: var(--neon-blue);
            margin: 0;
            padding-bottom: 10px;
        }

        /* Contenedores de información */
        .header-box {
            width: 420px;
            background-color: var(--bg-panel);
            border: 4px solid var(--neon-blue);
            box-shadow: 0 0 15px var(--neon-blue), inset 0 0 20px rgba(0, 243, 255, 0.2);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
        }

        .info-panel {
            font-size: 12px;
            color: white;
            text-align: center;
        }

        .info-panel span {
            display: block;
            font-size: 18px;
            color: var(--neon-green);
            margin-top: 5px;
            text-shadow: 0 0 5px var(--neon-green);
        }

        /* --- TABLERO (PANTALLA) --- */
        #game-wrapper {
            padding: 10px;
            background: #000;
            border-radius: 15px;
            /* IMPORTANTE: Borde base grueso para ver los colores */
            border: 10px solid #333; 
            box-shadow: 0 0 0 4px #555, 0 0 30px rgba(0,0,0,0.8);
            transition: border-color 0.1s, box-shadow 0.1s; 
        }

        /* CLASES PARA DESTELLOS DE BORDE */
        .flash-up { 
            border-top-color: #ffee00 !important; 
            box-shadow: 0 -20px 30px #ffee00, inset 0 10px 20px rgba(255, 238, 0, 0.2) !important; 
        }
        
        .flash-down { 
            border-bottom-color: #ff00ff !important; 
            box-shadow: 0 20px 30px #ff00ff, inset 0 -10px 20px rgba(255, 0, 255, 0.2) !important; 
        }

        .flash-left { 
            border-left-color: #00f3ff !important; 
            box-shadow: -20px 0 30px #00f3ff, inset 10px 0 20px rgba(0, 243, 255, 0.2) !important; 
        }

        .flash-right { 
            border-right-color: #0aff00 !important; 
            box-shadow: 20px 0 30px #0aff00, inset -10px 0 20px rgba(10, 255, 0, 0.2) !important; 
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, 1fr);
            gap: 10px;
            background-color: #0a0a0a;
            width: 400px;
            height: 400px;
            position: relative;
            border: 2px solid #333;
        }

        /* Celdas individuales (Con transición para fluidez) */
        .cell {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px; 
            font-weight: bold;
            color: #fff;
            border-radius: 4px;
            box-shadow: inset 2px 2px 0px rgba(255,255,255,0.4), inset -2px -2px 0px rgba(0,0,0,0.4);
            text-shadow: 2px 2px 0 #000;
            
            /* ESTO HACE LA MAGIA DEL MOVIMIENTO FLUIDO */
            transition: all 0.15s ease-in-out; 
            transform: scale(1);
        }

        /* --- COLORES NEÓN PARA LAS FICHAS --- */
        .val-2    { background-color: #ff0055; box-shadow: 0 0 10px #ff0055; }
        .val-4    { background-color: #ff5e00; box-shadow: 0 0 10px #ff5e00; }
        .val-8    { background-color: #ffcc00; color: #000; text-shadow: none; box-shadow: 0 0 10px #ffcc00; }
        .val-16   { background-color: #ccff00; color: #000; text-shadow: none; box-shadow: 0 0 10px #ccff00; }
        .val-32   { background-color: #00ff66; color: #000; text-shadow: none; box-shadow: 0 0 10px #00ff66; }
        .val-64   { background-color: #00ffff; color: #000; text-shadow: none; box-shadow: 0 0 10px #00ffff; }
        .val-128  { background-color: #0066ff; box-shadow: 0 0 15px #0066ff; }
        .val-256  { background-color: #9900ff; box-shadow: 0 0 15px #9900ff; }
        .val-512  { background-color: #ff00cc; box-shadow: 0 0 20px #ff00cc; }
        .val-1024 { background-color: #ffffff; color: #000; text-shadow: none; box-shadow: 0 0 25px #ffffff; }
        .val-2048 { background-color: #ffd700; color: #000; border: 2px solid white; animation: pulse 1s infinite; }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 10px gold; }
            50% { transform: scale(1.05); box-shadow: 0 0 30px gold; }
            100% { transform: scale(1); box-shadow: 0 0 10px gold; }
        }

        /* --- OVERLAY (GAME OVER) --- */
        #message-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            display: none;
            z-index: 10;
            color: var(--neon-pink);
            text-shadow: 0 0 10px var(--neon-pink);
            border: 2px solid var(--neon-pink);
        }

        #game-message {
            font-size: 30px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* --- BOTONES ARCADE --- */
        button {
            padding: 12px 20px;
            font-family: 'Press Start 2P', cursive;
            font-size: 12px;
            color: white;
            background-color: #d60000;
            border: none;
            border-bottom: 6px solid #800000;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.1s;
            text-transform: uppercase;
        }

        button:active {
            transform: translateY(4px);
            border-bottom: 2px solid #800000;
        }

        button:hover {
            background-color: #ff1a1a;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
        }

        /* --- TEMPORIZADOR BAJO --- */
        .timer-low span {
            color: red !important;
            text-shadow: 0 0 10px red;
            animation: blink 0.5s infinite;
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }

        p {
            font-size: 10px;
            color: #888;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header-box">
        <div>
            <h3>JUGADOR</h3>
            <span style="color: var(--neon-yellow); text-shadow: 0 0 5px gold;">{{ $currentPlayer->nickname }}</span>
        </div>
        <h1>2048</h1>
    </div>
 
    <div id="game-wrapper">
        <div class="grid" id="grid-container"></div>
 
        <div id="message-overlay">
            <h2 id="game-message"></h2>
            <button onclick="startGame()">
                REINTENTAR
            </button>

        </div>
    </div>

    <div class="header-box" style="margin-top: 20px; border-color: var(--neon-pink); box-shadow: 0 0 15px var(--neon-pink), inset 0 0 20px rgba(255, 0, 255, 0.2);">
        
        <div class="info-panel">
            PUNTOS
            <span id="score">0</span>
        </div>

        <button id="new-game-btn" onclick="startGame()">
            RESET
        </button>

        <div class="info-panel" id="timer-box">
            TIEMPO
            <span id="timer">--</span>
        </div>
    </div>
 
    <p>
        ↑ ↓ ← → PARA MOVER
    </p>

    <script>
        // Variables globales
        const SIZE = 4;
        const INITIAL_TIME_SECONDS = 60; 
 
        let grid = Array(SIZE * SIZE).fill(0); 
        let score = 0;
        let previousGrid = []; 
        let timerId = null; 
        let timeLeft = INITIAL_TIME_SECONDS; 
 
        // Referencias del DOM
        const gridContainer = document.getElementById('grid-container');
        const scoreElement = document.getElementById('score');
        const overlay = document.getElementById('message-overlay');
        const message = document.getElementById('game-message');
        const timerElement = document.getElementById('timer'); 
        const timerBoxElement = document.getElementById('timer-box'); 
 
        // --- LÓGICA DE INICIALIZACIÓN Y VISTA ---
        function initGame() {
            grid = Array(SIZE * SIZE).fill(0);
            score = 0;
            timeLeft = INITIAL_TIME_SECONDS; 
 
            clearInterval(timerId); 
 
            updateScore();
            updateTimerDisplay(); 
            overlay.style.display = 'none';
            agregarNumeroAleatorio();
            agregarNumeroAleatorio();
            dibujarTablero();
            startTimer(); 
        }
 
        function startTimer() {
            clearInterval(timerId); 
 
            timerId = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
 
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    if (overlay.style.display === 'none') {
                        endGame("¡TIEMPO AGOTADO!");
                    }
                }
            }, 1000);
        }
 
        function updateTimerDisplay() {
            timerElement.textContent = `${timeLeft}s`;
            if (timeLeft <= 10 && timeLeft > 0) {
                timerBoxElement.classList.add('timer-low');
            } else {
                timerBoxElement.classList.remove('timer-low');
            }
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
 
        // --- DIBUJAR TABLERO (VERSIÓN FLUIDA) ---
        function dibujarTablero() {
            // 1. Si no existen las celdas, las creamos (Solo la primera vez)
            if (gridContainer.children.length === 0) {
                for (let i = 0; i < SIZE * SIZE; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'cell'; // Clase base
                    gridContainer.appendChild(cell);
                }
            }

            // 2. Si ya existen, solo actualizamos su contenido y color
            const cells = gridContainer.children;
            for (let i = 0; i < grid.length; i++) {
                let valor = grid[i];
                const cell = cells[i];

                cell.className = `cell val-${valor}`;
                cell.textContent = valor > 0 ? valor : '';

                // Truco visual para que las vacías no tengan sombra
                if (valor === 0) {
                    cell.style.backgroundColor = 'transparent';
                    cell.style.boxShadow = 'none';
                } else {
                    cell.style.backgroundColor = ''; 
                    cell.style.boxShadow = '';
                }
            }
        }
 
        function updateScore() {
            scoreElement.textContent = score;
        }
 
        // --- LÓGICA DE MOVIMIENTO ---
        function operateLine(line) {
            let newLine = line.filter(val => val !== 0);
            for (let i = 0; i < newLine.length - 1; i++) {
                if (newLine[i] === newLine[i + 1]) {
                    newLine[i] *= 2;
                    score += newLine[i]; 
                    newLine[i + 1] = 0; 
                }
            }
            newLine = newLine.filter(val => val !== 0);
            while (newLine.length < SIZE) {
                newLine.push(0);
            }
            return newLine;
        }
 
        function move(direction) {
            if (overlay.style.display !== 'none' || timeLeft <= 0) return;
 
            let boardMoved = false;
            let newGrid = [...grid];
            const prevGridSnapshot = JSON.stringify(grid); 
 
            const lineIndices = []; 
            if (direction === 'left' || direction === 'right') {
                for (let r = 0; r < SIZE; r++) {
                    lineIndices.push([r * 4, r * 4 + 1, r * 4 + 2, r * 4 + 3]);
                }
            } else {
                for (let c = 0; c < SIZE; c++) {
                    lineIndices.push([c, c + 4, c + 8, c + 12]);
                }
            }
 
            for (const indices of lineIndices) {
                let line = indices.map(i => grid[i]);
                if (direction === 'right' || direction === 'down') line.reverse();
                const newLine = operateLine(line);
                if (direction === 'right' || direction === 'down') newLine.reverse();
                for (let k = 0; k < SIZE; k++) {
                    newGrid[indices[k]] = newLine[k];
                }
            }
 
            if (prevGridSnapshot !== JSON.stringify(newGrid)) {
                boardMoved = true;
            }
 
            if (boardMoved) {
                grid = newGrid;
                agregarNumeroAleatorio();
                updateScore();
                dibujarTablero(); 
                checkGameState();
            }
        }
 
        function checkGameState() {
            if (grid.includes(2048)) {
                endGame("¡GANASTE! 🎉");
                return;
            }
            if (!canMove()) {
                endGame("FIN DEL JUEGO 😔");
            }
        }
 
        function canMove() {
            if (grid.includes(0)) return true;
            for (let i = 0; i < grid.length; i++) {
                const current = grid[i];
                const row = Math.floor(i / 4);
                const col = i % 4;
                if (col < 3 && current === grid[i + 1]) return true;
                if (row < 3 && current === grid[i + 4]) return true;
            }
            return false;
        }
 
        // --- LUCES DE BORDE ---
        function iluminarBorde(direction) {
            const wrapper = document.getElementById('game-wrapper');
            // console.log("Iluminando borde:", direction); // Descomenta para depurar

            if (!wrapper) return;

            wrapper.classList.remove('flash-up', 'flash-down', 'flash-left', 'flash-right');
            void wrapper.offsetWidth; // Reset animation hack
            wrapper.classList.add(`flash-${direction}`);

            setTimeout(() => {
                wrapper.classList.remove(`flash-${direction}`);
            }, 200);
        }

        function enviarPuntaje(puntos) {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            fetch('/guardar-score', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ score: puntos })
            })
            .then(response => response.json())
            .then(data => {
                const msgElement = document.getElementById('game-message');
                msgElement.innerHTML += `<br><span style="font-size:20px; color:green">${data.message}</span>`;
            })
            .catch(error => console.error('Error:', error));
        }

        function endGame(msg) {
            clearInterval(timerId); 
            message.innerHTML = msg; 
            overlay.style.display = 'flex'; 

            if (score > 0) {
                enviarPuntaje(score);
            }
        }
 
        // --- MANEJADOR DE TECLADO UNIFICADO ---
        function handleKeyPress(event) {
            if (overlay.style.display === 'none' && timeLeft > 0) {
                let direction = null;
                switch (event.key) {
                    case 'ArrowLeft': case 'a': direction = 'left'; break;
                    case 'ArrowRight': case 'd': direction = 'right'; break;
                    case 'ArrowUp': case 'w': direction = 'up'; break;
                    case 'ArrowDown': case 's': direction = 'down'; break;
                }
 
                if (direction) {
                    event.preventDefault();
                    iluminarBorde(direction); // Efecto visual
                    move(direction); // Movimiento lógico
                }
            }
        }
 
        function startGame() {
            initGame();
        }
 
        document.addEventListener('keydown', handleKeyPress);
        startGame();
 
    </script>
</body>
</html>