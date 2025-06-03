@use('Illuminate\Support\Facades\Vite')

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @routes

    @if (env('APP_ENV') === 'local')
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @else
        {{ Vite::useManifestFilename('asset.json')->useBuildDirectory('build')->withEntryPoints(['resources/js/app.js', 'resources/scss/app.scss']) }}
    @endif

    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
