<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
        @if(Session::has('message'))
        <div class="container">
            <div class="alert alert-success"><em> {!! session('message') !!}</em>
            </div>
        </div>
    @endif
    <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="import_file" id="import_file">
        <input type="submit" value="submit">
    </form>
</body>
</html>