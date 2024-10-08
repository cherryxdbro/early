<!DOCTYPE html>
<html data-bs-theme="dark" lang="ru">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title><?= $data["title"] ?? "early"; ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#2b5797">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#2b5797">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="text-break">
    <header class="sticky-block sticky-top">
        <nav class="bg-body-tertiary navbar navbar-expand-lg">
            <div class="container-fluid gap-3 justify-content-center py-3">
                <a class="navbar-brand" href="/">early</a>
                <button aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="toggle navigation"
                    class="navbar-toggler" data-bs-target="#navbarNavDropdown" data-bs-toggle="collapse" type="button">
                    <span class="bi navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="gap-3 navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/early/home/organizations">организации</a>
                        </li>
                        <li>
                            <button class="btn btn-primary image-button" id="themeButton" title="switch theme" type="button">
                                <svg class="bi" id="themeIcon" role="img">
                                    <use xlink:href="/assets/images/svg/themes.svg#moon-stars-fill"></use>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="pt-3">
        <?php if (isset($content)) {
            echo $content;
        } ?>
    </main>
    <footer class="border-top my-3 py-3">
        <p class="text-center text-muted">&copy; 2024 landiunload</p>
    </footer>
    <script src="/assets/js/script.js"></script>
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>