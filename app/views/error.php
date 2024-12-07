<?php include __DIR__ . '/header.php'; ?>
    <h1>Error</h1>
    <p><?= htmlspecialchars($data['message'] ?? 'An unexpected error occurred.'); ?></p>
    <a href="/" class="btn btn-primary">Return to Home</a>

<?php include __DIR__ . '/footer.php'; ?>