<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FABRICA DE REGALOS</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --neon-pink: #ff00ff;
            --neon-cyan: #00ffff;
            --neon-green: #0aff00;
            --neon-yellow: #ffee00;
            --bg-color: #050011;
        }

        body {
            background-color: var(--bg-color);
            color: #fff;
            font-family: 'Press Start 2P', cursive;
            min-height: 100vh;
            overflow-x: hidden;
            text-transform: uppercase;
            position: relative;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- FONDO GRID 80s --- */
        body::after {
            content: "";
            position: absolute;
            bottom: 0; left: 0; right: 0; height: 35vh;
            background: 
                linear-gradient(rgba(188, 19, 254, 0.4) 1px, transparent 1px),
                linear-gradient(90deg, rgba(188, 19, 254, 0.4) 1px, transparent 1px);
            background-size: 40px 40px;
            transform: perspective(300px) rotateX(60deg) scale(2);
            z-index: -1;
            animation: gridMove 10s linear infinite;
            pointer-events: none;
        }

        @keyframes gridMove {
            0% { background-position: center 0; }
            100% { background-position: center 400px; }
        }

        /* --- SCANLINES CRT --- */
        .crt-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), 
                        linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            background-size: 100% 2px, 3px 100%;
            pointer-events: none;
            z-index: 999;
        }

        /* --- TÍTULO --- */
        h1.main-title {
            margin-top: 40px;
            font-size: 3rem;
            text-align: center;
            color: #fff;
            text-shadow: 
                0 0 5px #fff, 0 0 20px var(--neon-pink), 0 0 40px var(--neon-pink);
            animation: flicker 3s infinite;
        }

        @keyframes flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; }
            20%, 24%, 55% { opacity: 0.5; }
        }

        /* --- CAJAS GENÉRICAS --- */
        .arcade-box {
            background: rgba(0, 0, 0, 0.85);
            border: 3px solid #fff;
            padding: 20px;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.9);
            position: relative;
        }

        .box-title {
            font-size: 0.8rem;
            margin-bottom: 15px;
            border-bottom: 2px solid;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ESTILO: LOGIN (Cyan) */
        .style-login {
            border-color: var(--neon-cyan);
            box-shadow: 0 0 15px var(--neon-cyan), inset 0 0 30px rgba(0, 255, 255, 0.2);
        }
        .style-login .box-title { color: var(--neon-cyan); border-color: var(--neon-cyan); text-shadow: 0 0 5px var(--neon-cyan); }

        /* ESTILO: REGISTER (Pink) */
        .style-register {
            border-color: var(--neon-pink);
            box-shadow: 0 0 15px var(--neon-pink), inset 0 0 30px rgba(255, 0, 255, 0.2);
        }
        .style-register .box-title { color: var(--neon-pink); border-color: var(--neon-pink); text-shadow: 0 0 5px var(--neon-pink); }

        /* ESTILO: LEADERBOARD (Gold/Yellow) */
        .style-leaderboard {
            border-color: var(--neon-yellow);
            box-shadow: 0 0 15px var(--neon-yellow), inset 0 0 30px rgba(255, 238, 0, 0.2);
            height: 100%; /* Para que ocupe toda la altura */
            display: flex;
            flex-direction: column;
        }
        .style-leaderboard .box-title { color: var(--neon-yellow); border-color: var(--neon-yellow); text-shadow: 0 0 5px var(--neon-yellow); justify-content: center; }

        /* --- INPUTS --- */
        label { font-size: 0.5rem; color: #aaa; margin-bottom: 5px; display: block; }
        input[type="text"] {
            width: 100%;
            background: #111;
            border: 1px solid #555;
            color: #fff;
            padding: 10px;
            font-family: 'VT323', monospace;
            font-size: 1.5rem;
            outline: none;
            box-sizing: border-box;
        }
        input[type="text"]:focus { background: #000; border-color: #fff; }

        /* --- BOTONES --- */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: transparent;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            cursor: pointer;
            transition: 0.2s;
            border: 2px solid;
            text-transform: uppercase;
        }
        
        .btn-cyan { border-color: var(--neon-cyan); color: var(--neon-cyan); }
        .btn-cyan:hover { background: var(--neon-cyan); color: #000; box-shadow: 0 0 15px var(--neon-cyan); }

        .btn-pink { border-color: var(--neon-pink); color: var(--neon-pink); }
        .btn-pink:hover { background: var(--neon-pink); color: #000; box-shadow: 0 0 15px var(--neon-pink); }

        /* --- LISTA DE PUNTUACIONES --- */
        .scores-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto; /* Scroll si hay muchos */
            font-family: 'VT323', monospace;
            font-size: 1.5rem;
        }
        .scores-list li {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #333;
            color: #ccc;
        }
        .scores-list li:first-child { color: var(--neon-yellow); text-shadow: 0 0 5px var(--neon-yellow); font-size: 1.8rem; }
        .scores-list li:nth-child(2) { color: #fff; }
        .scores-list li:nth-child(3) { color: #fff; }
        
        /* Layout Grid */
        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Dos columnas iguales por defecto */
            gap: 20px;
            width: 100%;
            max-width: 900px;
            margin-top: 40px;
            padding: 20px;
        }

        /* Columna Izquierda (Forms) */
        .col-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .layout-grid { grid-template-columns: 1fr; }
        }

    </style>
</head>
<body>

    <div class="crt-overlay"></div>

    <h1 class="main-title">FABRICA DE REGALOS</h1>

    <div class="layout-grid">
        
        <div class="col-left">
            
            <div class="arcade-box style-login">
                <div class="box-title"><i class="fas fa-coins"></i> INSERT COIN (LOGIN)</div>
                <form method="POST" action="{{ route('player.login') }}">
                    @csrf
                    <div>
                        <label>PLAYER INITIALS</label>
                        <input type="text" name="nickname" required placeholder="AAA">
                        @error('nickname') <span style="color:red; font-size:0.5rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-cyan">START GAME</button>
                </form>
            </div>

            <div class="arcade-box style-register">
                <div class="box-title"><i class="fas fa-user-plus"></i> NEW CHALLENGER</div>
                <form method="POST" action="{{ route('player.register') }}">
                    @csrf
                    <div>
                        <label>ENTER NAME</label>
                        <input type="text" name="nickname" required value="{{ old('nickname') }}" placeholder="...">
                        @error('nickname') <span style="color:red; font-size:0.5rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-pink">REGISTER</button>
                </form>
            </div>

        </div>

        <div class="col-right">
            <div class="arcade-box style-leaderboard">
                <div class="box-title"><i class="fas fa-trophy"></i> HIGH SCORES</div>
                
                @if($highScores->isEmpty())
                    <div style="text-align:center; margin-top:50px; color:#555;">
                        <i class="fas fa-ghost" style="font-size:40px; margin-bottom:10px;"></i><br>
                        NO SCORES
                    </div>
                @else
                    <ul class="scores-list">
                        <li style="font-size: 1rem; color: var(--neon-cyan); border-bottom: 2px solid var(--neon-cyan); margin-bottom: 10px;">
                            <span>RANK NAME</span>
                            <span>PTS</span>
                        </li>

                        @foreach($highScores as $index => $score)
                        <li>
                            <span>
                                {{ $index + 1 }}. 
                                {{ strtoupper(optional($score->player)->nickname ?? 'UNK') }}
                            </span>
                            <span @if($index == 0) style="animation: flicker 0.5s infinite" @endif>
                                {{ number_format($score->points, 0, ',', '.') }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @endif
                
                <div style="text-align:center; font-size:0.5rem; color:#555; margin-top:20px;">
                    ONLY THE BEST SURVIVE
                </div>
            </div>
        </div>

    </div>

</body>
</html>