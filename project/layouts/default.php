<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <link rel="icon" type="image/png" href="/favicon.png"/>

    <link rel="stylesheet" href="/project/webroot/assets/build/css/style.min.css">
</head>
<body>
    <div class="container">
        <h1 class="layout-title fs-4 fw-bold my-4 text-uppercase"><?= $title ?></h1>
    </div>
    <?= $content ?>

    <script src="/project/webroot/assets/build/js/main.min.js"></script>
</body>
</html>
