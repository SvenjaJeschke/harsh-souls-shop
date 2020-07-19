<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="csrf-token" value="{{ csrf_token() }}"/>

    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
</head>
<body>
<div id="app">
    <v-app dark>
        <app></app>
    </v-app>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
