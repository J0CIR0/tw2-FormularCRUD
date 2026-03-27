<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-main: #060f22;
            --bg-soft: #0b1b3b;
            --bg-card: rgba(10, 28, 63, 0.82);
            --bg-card-strong: rgba(15, 39, 84, 0.95);
            --line: rgba(110, 171, 255, 0.28);
            --text-main: #eaf2ff;
            --text-muted: #a9bfdd;
            --accent: #3a86ff;
            --accent-soft: #5ca0ff;
            --danger: #ff5a7a;
            --success: #14c38e;
            --shadow: 0 22px 48px rgba(2, 9, 24, 0.45);
        }

        body {
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 12% 18%, rgba(58, 134, 255, 0.25), transparent 32%),
                radial-gradient(circle at 85% 8%, rgba(27, 88, 206, 0.33), transparent 38%),
                radial-gradient(circle at 50% 90%, rgba(8, 43, 107, 0.48), transparent 42%),
                linear-gradient(145deg, #040b1a 0%, #08142d 46%, #051026 100%);
            background-attachment: fixed;
        }

        .main-nav {
            background: linear-gradient(120deg, #07152f 0%, #0c2e69 100%);
            border-bottom: 1px solid rgba(124, 180, 255, 0.24);
            box-shadow: 0 14px 34px rgba(1, 6, 18, 0.55);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.4px;
            color: #f4f8ff !important;
        }

        .page-shell {
            max-width: 1140px;
            margin: 18px auto 34px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: linear-gradient(160deg, rgba(8, 20, 46, 0.86) 0%, rgba(8, 26, 58, 0.7) 100%);
            backdrop-filter: blur(4px);
            box-shadow: var(--shadow);
            padding: 1.2rem;
        }

        .view-card {
            background: linear-gradient(165deg, var(--bg-card) 0%, var(--bg-card-strong) 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 14px 34px rgba(1, 8, 24, 0.36);
        }

        .page-title {
            font-weight: 800;
            margin: 0;
            color: #f3f8ff;
            text-shadow: 0 0 24px rgba(94, 166, 255, 0.24);
        }

        .subtitle {
            color: var(--text-muted);
        }

        .btn {
            border-radius: 10px;
            font-weight: 700;
            border: 1px solid transparent;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(2, 10, 31, 0.38);
        }

        .btn-primary {
            background: linear-gradient(120deg, #2f78ef 0%, #4c94ff 100%);
            border-color: rgba(138, 186, 255, 0.56);
        }

        .btn-success {
            background: linear-gradient(120deg, #0ebf86 0%, #23d59d 100%);
            border-color: rgba(126, 234, 202, 0.48);
            color: #042318;
        }

        .btn-danger {
            background: linear-gradient(120deg, #f54f73 0%, #ff6b8d 100%);
            border-color: rgba(255, 180, 197, 0.5);
        }

        .btn-warning {
            background: linear-gradient(120deg, #ffb951 0%, #ffd279 100%);
            border-color: rgba(255, 229, 178, 0.6);
            color: #2e2200;
        }

        .btn-secondary {
            background: linear-gradient(120deg, #21437a 0%, #2a5799 100%);
            border-color: rgba(136, 178, 236, 0.4);
        }

        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: rgba(20, 195, 142, 0.14);
            border-color: rgba(20, 195, 142, 0.48);
            color: #c9ffef;
        }

        .alert-danger {
            background: rgba(255, 90, 122, 0.15);
            border-color: rgba(255, 90, 122, 0.45);
            color: #ffe1e8;
        }

        .table-dark,
        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-main);
            --bs-table-border-color: rgba(126, 175, 244, 0.2);
        }

        .table thead th {
            background: linear-gradient(115deg, rgba(28, 74, 147, 0.85), rgba(34, 96, 188, 0.85));
            color: #f2f7ff;
            border-bottom: 1px solid rgba(141, 188, 253, 0.4);
        }

        .table tbody tr {
            background: rgba(7, 23, 53, 0.5);
        }

        .table tbody tr:hover {
            background: rgba(27, 63, 120, 0.62);
        }

        .form-label {
            font-weight: 700;
            color: #d8e8ff;
        }

        .form-control {
            border-radius: 10px;
            background: rgba(7, 23, 53, 0.82);
            border: 1px solid rgba(125, 176, 249, 0.34);
            color: #edf5ff;
        }

        .form-control:focus {
            background: rgba(9, 29, 66, 0.95);
            border-color: rgba(86, 158, 255, 0.78);
            color: #f3f8ff;
            box-shadow: 0 0 0 .2rem rgba(58, 134, 255, 0.25);
        }

        .data-empty {
            background: rgba(14, 36, 78, 0.55);
            color: var(--text-muted);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .page-shell {
                margin: 12px;
                padding: 0.9rem;
                border-radius: 14px;
            }

            .page-title {
                font-size: 1.35rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark main-nav mb-3">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Gestión de Usuarios</span>
        </div>
    </nav>
    <div class="container page-shell">