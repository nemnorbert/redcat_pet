<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $petDB["name"] ?? "?" ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<main>
    <div id="cover">
        <div id="lost"><?= isset($petDB["lost"]) ? lostAlert($petDB["lost"]) : "" ?></div>
        <img src="img/dog.webp" alt="">
    </div>
    <div id="bio">
        <h1><?= $petDB["name"] ?? "?" ?></h1>
        <div id="details"><?= petInfo($petDB, $icons, $langJSON); ?></div>
    </div>
</main>

<footer>
    <div class="creator">powered by REDCAT</div>
    <div title="<?= $petDB["version"]["description"] ?? "" ?>" id="version">v<?= $petDB["version"]["date"] ?? "" ?></div>
</footer>
</body>
</html>