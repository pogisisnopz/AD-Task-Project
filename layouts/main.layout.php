<?php
require_once 'utils/auth.util.php'; // Needed for isAuthenticated()

function renderLayout(string $pageTitle, string $content): string {
    // Dynamically build the nav links
    $navLinks = "<a href='index.php'>Home</a>";
    if (isAuthenticated()) {
        $navLinks .= " <a href='logout.php'>Logout</a>";
    } else {
        $navLinks .= " <a href='login.php'>Login</a>";
    }

    // Return the full HTML
    return "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>{$pageTitle}</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <header>
            <h1>{$pageTitle}</h1>
            <nav>
                {$navLinks}
            </nav>
        </header>
        <main>
            {$content}
        </main>
        <footer>
            <small>&copy; " . date("Y") . " Your Project</small>
        </footer>
    </body>
    </html>
    ";
}
