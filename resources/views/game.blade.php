<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CURSED ARCADE</title> <!-- Cambia aquí el nombre que más te guste -->
   
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
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Press Start 2P', cursive;
            text-transform: uppercase;
            color: white;
        }

        body {
            background: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* GIF DE FONDO — CAMBIA "bg.gif" POR EL NOMBRE QUE QUIERAS */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('/img/bg.gif') center center / cover no-repeat;
            z-index: -2;
        }

        body::after {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 20, 0.75);
            z-index: -1;
        }

        h1.main-title {
            margin-top: 50px;
            font-size: 3.2rem;
            text-align: center;
            color: #fff;
            text-shadow: 
                0 0 10px #fff,
                0 0 30px var(--neon-pink),
                0 0 60px var(--neon-pink);
            animation: flicker 2.5s infinite;
            z-index: 10;
        }

        @keyframes flicker {
            0%,19%,21%,23%,25%,54%,56%,100% { opacity:1; }
            20%,24%,55% { opacity:0.4; }
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            max-width: 950px;
            width: 100%;
            margin-top: 40px;
            padding: 20px;
            z-index: 10;
        }

        .arcade-box {
            background: rgba(0,0,0,0.88);
            border: 3px solid #fff;
            padding: 22px;
            box-shadow: inset 0 0 25px rgba(0,0,0,0.9);
            backdrop-filter: blur(2px);
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

        .style-login    { border-color: var(--neon-cyan);   box-shadow: 0 0 20px var(--neon-cyan), inset 0 0 30px rgba(0,255,255,0.2); }
        .style-login .box-title    { color: var(--neon-cyan); border-color: var(--neon-cyan); text-shadow: 0 0 8px var(--neon-cyan); }

        .style-register { border-color: var(--neon-pink);   box-shadow: 0 0 20px var(--neon-pink), inset 0 0 30px rgba(255,0,255,0.2); }
        .style-register .box-title { color: var(--neon-pink); border-color: var(--neon-pink); text-shadow: 0 0 8px var(--neon-pink); }

        .style-leaderboard { border-color: var(--neon-yellow); box-shadow: 0 0 20px var(--neon-yellow), inset 0 0 30px rgba(255,238,0,0.2); display:flex; flex-direction:column; }
        .style-leaderboard .box-title { color: var(--neon-yellow); border-color: var(--neon-yellow); text-shadow: 0 0 8px var(--neon-yellow); justify-content:center; }

        label { font-size:0.5rem; color:#aaa; margin-bottom:5px; display:block; }
        input[type="text"] { width:100%; background:#111; border:1px solid #555; color:#fff; padding:12px; font-family:'VT323',monospace; font-size:1.5rem; outline:none; box-sizing:border-box; }
        input[type="text"]:focus { background:#000; border-color:#fff; }

        button { width:100%; padding:14px; margin-top:15px; background:transparent; font-family:'Press Start 2P',cursive; font-size:0.75rem; cursor:pointer; border:2px solid; transition:0.3s; }
        .btn-cyan   { border-color:var(--neon-cyan); color:var(--neon-cyan); }
        .btn-cyan:hover   { background:var(--neon-cyan); color:#000; box-shadow:0 0 20px var(--neon-cyan); }
        .btn-pink   { border-color:var(--neon-pink); color:var(--neon-pink); }
        .btn-pink:hover   { background:var(--neon-pink); color:#000; box-shadow:0 0 20px var(--neon-pink); }

        .scores-list { list-style:none; padding:0; margin:0; flex-grow:1; overflow-y:auto; font-family:'VT323',monospace; font-size:1.5rem; }
        .scores-list li { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px dashed #333; color:#ccc; }
        .scores-list li:first-child { color:var(--neon-yellow); text-shadow:0 0 8px var(--neon-yellow); font-size:1.9rem; }
    </style>
</head>
<body>

    <h1 class="main-title">TWO-FUSION</h1>

    <div class="layout-grid">
        <div class="col-left">
            <div class="arcade-box style-login">
                <div class="box-title">INSERT COIN (LOGIN)</div>
                <form method="POST" action="{{ route('player.login') }}">
                    @csrf
                    <label>PLAYER INITIALS</label>
                    <input type="text" name="nickname" required placeholder="AAA" maxlength="3">
                    @error('nickname') <span style="color:red;font-size:0.5rem;display:block;">{{ $message }}</span> @enderror
                    <button type="submit" class="btn-cyan">START GAME</button>
                </form>
            </div>

            <div class="arcade-box style-register">
                <div class="box-title">NEW CHALLENGER</div>
                <form method="POST" action="{{ route('player.register') }}">
                    @csrf
                    <label>ENTER NAME</label>
                    <input type="text" name="nickname" required value="{{ old('nickname') }}" placeholder="...">
                    @error('nickname') <span style="color:red;font-size:0.5rem;display:block;">{{ $message }}</span> @enderror
                    <button type="submit" class="btn-pink">REGISTER</button>
                </form>
            </div>
        </div>

        <div class="col-right">
            <div class="arcade-box style-leaderboard">
                <div class="box-title">HIGH SCORES</div>
                @if($highScores->isEmpty())
                    <div style="text-align:center;margin-top:60px;color:#555;">
                        <i class="fas fa-ghost" style="font-size:50px;"></i><br>NO SOULS YET
                    </div>
                @else
                    <ul class="scores-list">
                        <li style="font-size:1rem;color:var(--neon-cyan);border-bottom:2px solid var(--neon-cyan);margin-bottom:12px;">
                            <span>RANK NAME</span><span>PTS</span>
                        </li>
                        @foreach($highScores as $index => $score)
                        <li>
                            <span>{{ $index + 1 }}. {{ strtoupper(optional($score->player)->nickname ?? 'UNK') }}</span>
                            <span @if($index == 0) style="animation:flicker 0.6s infinite"@endif>
                                {{ number_format($score->points, 0, ',', '.') }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @endif
                <div style="text-align:center;font-size:0.5rem;color:#555;margin-top:25px;">
                    ONLY THE DAMNED SURVIVE
                </div>
            </div>
        </div>
    </div>
</body>
</html>
