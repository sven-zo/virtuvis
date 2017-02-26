<!DOCTYPE html>

<html>
<head>
    <title>VirtuVis</title>
    <link rel="stylesheet" href="style/index.min.css">
</head>
<body>
    <div id="app">
        <h1>Hallo VirtuVis!</h1>
        <router-view></router-view>
        <fish-menu v-if="lang == 'nl'" left="Voeg vishengel toe" middle="Home" right="Instellingen en meer"></fish-menu>
        <fish-menu v-if="lang == 'en'" left="Add fishing rod" middle="Home" right="Settings & more"></fish-menu>
        <fish-menu v-if="lang == 'loading'" left="Loading..."></fish-menu>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-router@2.2.1/dist/vue-router.js"></script>
    <script src="script/lib/minAJAX.js"></script>
    <script src="script/pages.js"></script>
    <script src="script/components.js"></script>
    <script src="script/app.js"></script>
</body>
</html>