<!DOCTYPE html>
<html lang="<?= $siteINFO -> langSite; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $API["name"].", REDCAT Pet" ?? errorHandler("error_api", "Error with API"); ?></title>
    <link rel="stylesheet" href="<?= $siteINFO->redcatPath ?>style/brand.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Styles -->
    <style>
        :root {
            --colorPrimary: <?= $API["color"] ?? "#1e65cf" ?>;
            <?= isset($API["bio"]["lost"]) ? "--colorPrimary: #e00000;" : "" ?>
        }
    </style>
</head>
<body>
<div id="loading">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>
    <div>REDCAT PET</div>
</div>
<?= navBar($API); ?>

<main>
    <div id="cover" class="hide">
        <?= isset($API["bio"]["lost"]) ? ('<div class="lost">'.$API["translate"]["lost"]["title"].'</div>') : ""; ?>
        <div class="top">
            <a class="brand" target="_blank" href="#">
                <img class="logo" src="https://center.red-cat.hu/img/logo/logo1.svg" alt="Logo of creator">
                <div>Pet</div>
            </a>
            <div id="language" class="link"><?= $API["lang"] ?></div>
        </div>
        <div class="bottom">
            <h1><?= isset($API["name"]) ? buildName($API) : "?" ?></h1>
            <div id="darkmode" class="link"></div>
        </div>

        <div id="media">
            <img src="img/dog2.webp" alt="">
        </div>
    </div>
    <div class="box hide">
        <div class="buttons"><?= buildWidgets($API); ?></div>
        <div class="bottom">
            <div class="share link"><i class="bi bi-share-fill"></i> <?= $API["translate"]["share"] ?? ""; ?></div>
        </div>
    </div>
</main>

<footer>
    <a class="creator" target="_blank" href="https://red-cat.hu">
        <div>Powered by</div>
        <img class="logo" src="<?= $siteINFO -> redcatPath ?>img/logo/logo1.svg" alt="Logo of creator">
    </a>
    <div title="<?= $API["version"]["description"] ?? "" ?>" id="version">v<?= $API["version"]["date"] ?? "" ?></div>
</footer>

<?= buildScript($siteJSON, $API); ?>
<script src="js/main.js"></script>
</body>
</html>