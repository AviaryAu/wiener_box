<!DOCTYPE html>
<html lang="en-AU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FFCF24">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    @if (empty($__inertiaSsrResponse))
        @include('seo', ['seo' => $page['props']['seo']])
    @endif
</head>
<body>
    @inertia
</body>
</html>
