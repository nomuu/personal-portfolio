<?php
require_once 'webscraper.php';

$elements = [];
$error = "";
$show_table = false;

if (isset($scraper)) {
    $elements = $scraper->getElements();
    $error = $scraper->error;
    $show_table = $scraper->shouldShowTable();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Scrapify - Web Scraper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="content/css/index.css">
</head>
<body>
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold display-5">
            <i class="bi bi-search-heart scrapify-brand"></i> Scrapify
        </h1>
        <p class="lead">Extract website data effortlessly — headings, links, images, and more.</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="post" id="scrapeForm" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Website URL</label>
                    <input type="url" name="url" class="form-control" placeholder="https://example.com" required value="<?= isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '' ?>" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">Output Format</label>
                    <select name="format" class="form-select" required>
                        <option value="html" <?= ($_POST['format'] ?? '') === 'html' ? 'selected' : '' ?>>Show on Page</option>
                        <option value="csv" <?= ($_POST['format'] ?? '') === 'csv' ? 'selected' : '' ?>>Download CSV</option>
                        <option value="word" <?= ($_POST['format'] ?? '') === 'word' ? 'selected' : '' ?>>Download Word</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner"></span>
                        <i class="bi bi-cloud-download"></i> Scrape
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($show_table): ?>
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold">Scraped Content</h5>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#scrapedResults">
                    <i class="bi bi-arrows-collapse"></i> Toggle Results
                </button>
            </div>
            <div class="collapse show" id="scrapedResults">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Tag</th>
                                <th>Content</th>
                                <th>Link/Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($elements as $el): ?>
                                <tr>
                                    <td><?= htmlspecialchars($el['type']) ?></td>
                                    <td><?= htmlspecialchars($el['tag']) ?></td>
                                    <td><?= htmlspecialchars($el['content']) ?></td>
                                    <td>
                                        <?php
                                            $link = $el['href'] ?: $el['src'] ?? '';
                                            echo $link ? '<a href="' . htmlspecialchars($link) . '" target="_blank">' . htmlspecialchars($link) . '</a>' : '';
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const form = document.getElementById('scrapeForm');
    const spinner = document.getElementById('loadingSpinner');
    form.addEventListener('submit', function () {
        spinner.classList.remove('d-none');
    });
</script>
</body>
</html>
