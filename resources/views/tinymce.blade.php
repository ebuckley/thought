<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laracoding.com TinyMCE Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<h2>Laracoding.com - TinyMCE Example</h2>
<form action="" method="get">
    <div class="mb-3">
        <input id="content" value="Editor content goes here" type="hidden" name="content">
        <trix-editor class="trix-content" input="content"></trix-editor>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
