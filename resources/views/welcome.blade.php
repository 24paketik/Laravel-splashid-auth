<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Главная страница</title>
    </head>
    <body>
    @guest
        <a href="https://id.mcsplash.ru/oauth2?token=NP7YODEYB8AWhEwzJuyRdEWA1y4AgSLAiqCeFbbu">Login</a>
    @endguest
    @auth
        <a href="{{Route('logout')}}">Logout</a>
    @endauth
    </body>
</html>
