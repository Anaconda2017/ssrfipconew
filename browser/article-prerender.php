<?php

header("Content-Type: text/html; charset=UTF-8");

// Get and encode the slug
$slug = $_GET['slug'] ?? '';
$slug = mb_convert_encoding($slug, 'UTF-8', 'auto');
$encoded_slug = urlencode($slug);

// Fetch blog details from the API
$api_url = "https://fpico.org/fipcoapi/api/getSingleBlogs/$encoded_slug";
$blog_data = json_decode(file_get_contents($api_url), true);

// Check if the API response is valid
if (!$blog_data || $blog_data['status'] !== 'success') {
    http_response_code(404);
    echo "Blog post not found.";
    exit;
}

$blog = $blog_data['blog'];

// Extract required data
$title = $blog['ar_meta_title'];
$description = strip_tags(substr($blog['ar_meta_text'], 0, 150));
$image = $blog['main_image'];
$url = "https://fpico.org/ar/blogs/$slug";

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">

    <meta property="og:title" content="<?= htmlspecialchars($title) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($description) ?>" />
<meta property="og:image" content="https://fpico.org/fipcoapi/blogs/<?= $image ?>" />
<meta property="og:url" content="<?= $url ?>" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="fpico" />

<!-- Twitter Specific -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= htmlspecialchars($title) ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($description) ?>" />
<meta name="twitter:image" content="https://fpico.org/fipcoapi/blogs/<?= $image ?>" />
<meta name="twitter:url" content="<?= $url ?>" />

    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= $url ?>">

    <!-- Article Metadata -->
</head>
<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <p><?= $blog['ar_meta_text'] ?></p>
</body>
</html>
