<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — Anmol Pushjai Goel</title>
    <style>
        :root {
            color-scheme: dark;
            --ink: #0b0b0c;
            --panel: #151517;
            --gold: #a98f5b;
            --paper: #f5f4f1;
            --muted: #99999f;
            --line: rgba(255, 255, 255, .14);
        }
        * { box-sizing: border-box; }
        body {
            min-height: 100svh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at 80% 10%, rgba(169, 143, 91, .16), transparent 35%),
                var(--ink);
            color: var(--paper);
            font-family: Inter, Arial, sans-serif;
        }
        .login {
            width: min(100%, 430px);
            padding: clamp(30px, 6vw, 52px);
            border: 1px solid var(--line);
            background: rgba(21, 21, 23, .92);
            box-shadow: 0 30px 80px rgba(0, 0, 0, .35);
        }
        .mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            margin-bottom: 32px;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-size: 14px;
        }
        .eyebrow {
            margin: 0 0 10px;
            color: var(--gold);
            font-size: 11px;
            letter-spacing: .26em;
            text-transform: uppercase;
        }
        h1 {
            margin: 0 0 12px;
            font-size: clamp(32px, 7vw, 48px);
            font-weight: 300;
            letter-spacing: -.03em;
        }
        .intro {
            margin: 0 0 34px;
            color: var(--muted);
            line-height: 1.6;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        input {
            width: 100%;
            margin-bottom: 20px;
            padding: 14px 15px;
            border: 1px solid var(--line);
            outline: 0;
            background: #0f0f10;
            color: #fff;
            font: inherit;
        }
        input:focus { border-color: var(--gold); }
        button {
            width: 100%;
            padding: 15px 18px;
            border: 1px solid var(--gold);
            background: var(--gold);
            color: #0b0b0c;
            cursor: pointer;
            font: 600 12px/1 Inter, Arial, sans-serif;
            letter-spacing: .18em;
            text-transform: uppercase;
        }
        .error {
            margin: -6px 0 20px;
            color: #ffb4ab;
            font-size: 13px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <main class="login">
        <div class="mark">A</div>
        <p class="eyebrow">Sanchalak</p>
        <h1>Admin login</h1>
        <p class="intro">Sign in to access the administration dashboard.</p>

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <label for="email">Email address</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
            >

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <button type="submit">Sign in</button>
        </form>
    </main>
</body>
</html>
