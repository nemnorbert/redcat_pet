<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $petDB["name"].", REDCAT Pet" ?? "?" ?></title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Styles -->
    <style>
        :root {
            --mainColor: <?= $petDB["color"] ?? "#ccff66" ?>;
        }
    </style>
</head>
<body>

<?= isset($petDB["bio"]["lost"]) ? lostAlert($petDB) : null; ?>

<main>
    <div id="cover">
        <div class="top">
            <a class="brand" target="_blank" href="#">
                <img class="logo" src="https://center.red-cat.hu/img/logo/logo1.svg" alt="Logo of creator">
                <div>Pet</div>
            </a>
            <div id="language"><?= $petDB["lang"] ?></div>
        </div>
        <div class="bottom">
            <h1><?= isset($petDB["name"]) ? buildName($petDB) : "?" ?></h1>
            <div></div>
        </div>

        <div id="media">
            <img src="img/dog2.webp" alt="">
        </div>
    </div>
    <div id="details">
        <div class="top">
            <div class="petBtn"><?= $petDB["translate"]["pet"] ?? "" ?></div>
            <div class="ownerBtn"><?= $petDB["translate"]["owner"] ?? "" ?></div>
        </div>
        <div id="petBox">
            <div class="buttons"><?= bioWidgets($petDB, $icons, $langJSON); ?></div>
        </div>
    </div>
</main>

<footer>
    <a class="creator" target="_blank" href="https://red-cat.hu" class="logo">
        <b>Powered by</b> <img class="logo" src="https://center.red-cat.hu/img/logo/logo1.svg" alt="Logo of creator">
    </a>
    <div title="<?= $petDB["version"]["description"] ?? "" ?>" id="version">v<?= $petDB["version"]["date"] ?? "" ?></div>
</footer>
</body>
</html>