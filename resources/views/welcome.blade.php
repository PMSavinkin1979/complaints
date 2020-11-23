<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
{{--    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>

<div id="app">
    <v-container fluid>
        <pre id="axios-send"></pre>
        <v-app>
            {{--<table-main :masiv='@json($masiv)'></table-main>--}}
            <test></test>
            {{--<example-component></example-component>--}}
        </v-app>
    </v-container>
</div>

</body>
</html>
