<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title', 'Bolalar uchun onlayn kutubxona') - rustili-ai.uz</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Comfortaa:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Asosiy ranglar */
            --color-primary: #6CD669;      /* Yashil */
            --color-primary-dark: #4CAF50;
            --color-secondary: #FFB74D;    /* Sariq-apelsin */
            --color-accent: #FF80AB;       /* Pushti */
            --color-accent-light: #FFD6E8;

            /* Fon ranglari */
            --color-bg: #FFFDF7;
            --color-bg-card: #FFFFFF;
            --color-bg-section: #FFF9C4;

            /* Matn ranglari */
            --color-text: #2D3748;
            --color-text-light: #718096;
            --color-text-white: #FFFFFF;

            /* Soyalar */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);

            /* Border radius */
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 24px;
            --radius-full: 9999px;

            /* Spacing */
            --space-xs: 0.5rem;
            --space-sm: 1rem;
            --space-md: 1.5rem;
            --space-lg: 2rem;
            --space-xl: 3rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Emoji support */
        .emoji {
            font-family: 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji', sans-serif;
            font-style: normal;
            font-weight: normal;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            padding: var(--space-sm) var(--space-lg);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-md);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: 'Comfortaa', cursive;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-text-white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            line-height: 1.2;
        }

        .logo-icon {
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
            gap: var(--space-md);
            list-style: none;
        }

        .nav-link {
            color: var(--color-text-white);
            text-decoration: none;
            font-weight: 600;
            padding: var(--space-xs) var(--space-sm);
            border-radius: var(--radius-full);
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .locale-switcher {
            display: flex;
            gap: var(--space-xs);
            align-items: center;
        }

        .locale-btn {
            padding: var(--space-xs) var(--space-sm);
            border: 2px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
            color: var(--color-text-white);
            text-decoration: none;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .locale-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.8);
        }

        .locale-btn.active {
            background: var(--color-text-white);
            color: var(--color-primary);
            border-color: var(--color-text-white);
        }

        /* Main content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-lg);
        }

        /* Hero section */
        .hero {
            text-align: center;
            padding: var(--space-xl) 0;
            background: linear-gradient(180deg, transparent 0%, var(--color-bg-section) 100%);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-xl);
        }

        .hero-title {
            font-family: 'Comfortaa', cursive;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: var(--space-sm);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--color-text-light);
        }

        /* Cards grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: var(--space-lg);
        }

        /* Card styles */
        .card {
            background: var(--color-bg-card);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .card-image {
            width: 100%;
            /* height: 180px; */
            object-fit: cover;
            background: linear-gradient(135deg, var(--color-bg-section) 0%, var(--color-accent-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .card-icon {
            font-size: 4rem;
        }

        .card-body {
            padding: var(--space-md);
        }

        .card-title {
            font-family: 'Comfortaa', cursive;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: var(--space-xs);
            color: var(--color-text);
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: var(--color-text-light);
            margin-bottom: var(--space-sm);
        }

        .card-description {
            font-size: 0.9rem;
            color: var(--color-text-light);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-top: var(--space-sm);
            padding-top: var(--space-sm);
            border-top: 1px solid #eee;
        }

        .card-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            background: var(--color-bg-section);
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Section header */
        .section-header {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-lg);
        }

        .section-title {
            font-family: 'Comfortaa', cursive;
            font-size: 1.75rem;
            font-weight: 700;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            margin-bottom: var(--space-lg);
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--color-primary-dark);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: var(--color-text-light);
        }

        /* Banner */
        .banner {
            position: relative;
            height: 200px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: var(--space-lg);
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: var(--space-lg);
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
        }

        .banner-title {
            font-family: 'Comfortaa', cursive;
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-text-white);
        }

        .banner-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        /* Button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-xs);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-full);
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            min-height: 44px;
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-text-white);
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--color-secondary);
            color: var(--color-text);
        }

        .btn-secondary:hover {
            background: #FFA726;
            transform: translateY(-2px);
        }

        .btn-accent {
            background: var(--color-accent);
            color: var(--color-text-white);
        }

        .btn-accent:hover {
            background: #FF4081;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
        }

        .btn-outline:hover {
            background: var(--color-primary);
            color: var(--color-text-white);
        }

        /* Filter panel */
        .filter-panel {
            background: var(--color-bg-card);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-lg);
            box-shadow: var(--shadow-sm);
        }

        .filter-title {
            font-weight: 700;
            margin-bottom: var(--space-sm);
        }

        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-xs);
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid #eee;
            background: var(--color-bg-card);
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: var(--color-primary);
            background: var(--color-primary);
            color: var(--color-text-white);
        }

        /* Content detail */
        .content-detail {
            background: var(--color-bg-card);
            border-radius: var(--radius-lg);
            padding: var(--space-xl);
            box-shadow: var(--shadow-md);
        }

        .content-header {
            margin-bottom: var(--space-lg);
            padding-bottom: var(--space-lg);
            border-bottom: 2px solid var(--color-bg-section);
        }

        .content-title {
            font-family: 'Comfortaa', cursive;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: var(--space-xs);
        }

        .content-meta {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-sm);
        }

        .content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            font-family: 'Nunito', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji', sans-serif;
        }

        .content-body p {
            margin-bottom: var(--space-md);
        }

        .content-body h1,
        .content-body h2,
        .content-body h3 {
            font-family: 'Comfortaa', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji', cursive;
            margin: var(--space-lg) 0 var(--space-sm);
        }

        .content-body h1 {
            font-size: 1.75rem;
        }

        .content-body h2 {
            font-size: 1.5rem;
        }

        .content-body h3 {
            font-size: 1.25rem;
        }

        .content-body ul,
        .content-body ol {
            margin: var(--space-md) 0;
            padding-left: var(--space-lg);
        }

        .content-body li {
            margin-bottom: var(--space-xs);
        }

        .content-body blockquote {
            border-left: 4px solid var(--color-primary);
            padding-left: var(--space-md);
            margin: var(--space-md) 0;
            font-style: italic;
            color: var(--color-text-light);
        }

        .content-body code {
            background: var(--color-bg);
            padding: 0.2rem 0.4rem;
            border-radius: var(--radius-sm);
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .content-body pre {
            background: var(--color-bg);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            overflow-x: auto;
            margin: var(--space-md) 0;
        }

        .content-body a {
            color: var(--color-primary);
            text-decoration: underline;
        }

        .content-body a:hover {
            color: var(--color-primary-dark);
        }

        /* Responsive images in content */
        .content-body img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: var(--space-md) auto;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
        }

        .content-body figure {
            margin: var(--space-md) 0;
            text-align: center;
        }

        .content-body figure img {
            max-width: 100%;
            height: auto;
        }

        .content-body figure figcaption {
            margin-top: var(--space-xs);
            font-size: 0.9rem;
            color: var(--color-text-light);
            font-style: italic;
        }

        /* Emoji support in content */
        .content-body * {
            font-family: inherit;
        }

        /* Video and iframe responsive */
        .content-body iframe,
        .video-player iframe {
            max-width: 100%;
            width: 100%;
            height: auto;
            aspect-ratio: 16 / 9;
            border-radius: var(--radius-md);
        }

        .video-player {
            margin: var(--space-lg) 0;
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }

        .video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: var(--space-sm);
            }

            .content-body {
                font-size: 1rem;
            }

            .content-body h1 {
                font-size: 1.5rem;
            }

            .content-body h2 {
                font-size: 1.25rem;
            }

            .content-body h3 {
                font-size: 1.1rem;
            }

            .content-body img {
                margin: var(--space-sm) 0;
            }

            .nav-buttons {
                flex-direction: column;
                gap: var(--space-sm);
            }

            .nav-buttons .btn {
                width: 100%;
                text-align: center;
            }

            .video-player {
                padding-bottom: 56.25%;
            }

            .audio-player {
                padding: var(--space-md);
            }

            .content-detail {
                padding: var(--space-md);
            }
        }

        /* Audio player */
        .audio-player {
            background: linear-gradient(135deg, var(--color-bg-section) 0%, var(--color-accent-light) 100%);
            padding: var(--space-lg);
            border-radius: var(--radius-md);
            margin: var(--space-lg) 0;
        }

        .audio-player audio {
            width: 100%;
        }

        /* Video player */
        .video-player {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: var(--radius-md);
            margin: var(--space-lg) 0;
        }

        .video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Navigation buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: var(--space-xl);
            padding-top: var(--space-lg);
            border-top: 2px solid var(--color-bg-section);
        }

        /* Riddles (Topishmoqlar) */
        .riddles-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-lg);
        }

        .riddle-card {
            background: var(--color-bg-card);
            border-radius: var(--radius-md);
            padding: var(--space-lg);
            box-shadow: var(--shadow-sm);
            border: 2px solid var(--color-bg-section);
            transition: box-shadow 0.3s;
        }

        .riddle-card:hover {
            box-shadow: var(--shadow-md);
        }

        .riddle-question {
            margin-bottom: var(--space-md);
        }

        .riddle-title {
            font-family: 'Comfortaa', cursive;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: var(--space-md);
            color: var(--color-text);
        }

        .riddle-body {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: var(--space-md);
            color: var(--color-text);
        }

        .riddle-toggle-btn {
            margin-top: var(--space-sm);
        }

        .riddle-answer {
            margin-top: var(--space-lg);
            padding-top: var(--space-lg);
            border-top: 2px dashed var(--color-bg-section);
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .riddle-answer-content {
            background: var(--color-bg-section);
            padding: var(--space-md);
            border-radius: var(--radius-sm);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: var(--color-text-white);
            padding: var(--space-xl) var(--space-lg);
            margin-top: var(--space-xl);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-text {
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: var(--space-sm);
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: var(--space-md);
            }

            .content-detail {
                padding: var(--space-md);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Header --}}
    <header class="header">
        <div class="header-content">
            <a href="{{ locale_url('home') }}" class="logo">
                rustili-ai.uz
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="{{ locale_url('home') }}" class="nav-link">🏠 {{ current_locale() === 'uz' ? 'Bosh sahifa' : 'Главная' }}</a></li>
                    <li><a href="{{ locale_url('page.author') }}" class="nav-link"><span class="emoji">👤</span> {{ current_locale() === 'uz' ? 'Muallif haqida' : 'Об авторе' }}</a></li>
                    <li>
                        <div class="locale-switcher">
                            <a href="{{ switch_locale_url('uz') }}"
                               class="locale-btn {{ current_locale() === 'uz' ? 'active' : '' }}"
                               title="O'zbek tili">
                                <span class="emoji">🇺🇿</span> UZ
                            </a>
                            <a href="{{ switch_locale_url('ru') }}"
                               class="locale-btn {{ current_locale() === 'ru' ? 'active' : '' }}"
                               title="Русский язык">
                                <span class="emoji">🇷🇺</span> RU
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- Main content --}}
    <main class="main-content">
            @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">
                © {{ date('Y') }} rustili-ai.uz - Bolalar uchun onlayn kutubxona<br>
                Детский образовательный портал
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
