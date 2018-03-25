<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login Form</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">User Dashboard</h1>
                <p class="lead">
                    <a href="{{ route('logout') }}">Logout</a>
                </p> 
          </div>
        </div>        
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    @include('partials.message')
                </div>
            </div>
            <div class="row">
                <div class="col-6 offset-3">
                    <ul>
                        <li>Your User Id: {{ $user->id }}</li>
                        <li>Your Email Address: {{ $user->email }}</li>
                        <li>Your Activation status: {{ $user->active ? 'Active' : 'Inactive' }}
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
