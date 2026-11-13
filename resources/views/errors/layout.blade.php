@php
    $code = $code ?? 404;
    $title = $title ?? 'Halaman tidak ditemukan';
    $message = $message ?? 'Halaman yang Anda cari tidak tersedia atau sudah dipindahkan.';
@endphp

<!-- Halaman error memakai token warna dan tipografi yang sama dengan aplikasi. -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code }} — {{ $title }}</title>
    <style>
        :root {
            --ink: hsl(215 48% 11%);
            --coral: hsl(7 75% 60%);
            --paper: hsl(40 39% 96%);
            --muted: hsl(215 12% 42%);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            padding: 2rem;
        }

        main {
            max-width: 32rem;
            text-align: center;
        }

        p.code {
            margin: 0;
            font-size: 0.875rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--coral);
            font-weight: 600;
        }

        h1 {
            margin: 0.75rem 0 0.5rem;
            font-size: 1.875rem;
            line-height: 1.2;
        }

        p.message {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        a.action {
            display: inline-block;
            margin-top: 1.75rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            background: var(--ink);
            color: var(--paper);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <main>
        <p class="code">{{ $code }}</p>
        <h1>{{ $title }}</h1>
        <p class="message">{{ $message }}</p>
        <a class="action" href="/">Kembali ke beranda</a>
    </main>
</body>
</html>
