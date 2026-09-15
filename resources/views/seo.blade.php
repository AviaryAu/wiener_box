<title inertia>{{ $seo['title'] }}</title>
@foreach ($seo['meta'] as $meta)
    <meta inertia="{{ $meta['key'] }}" {{ $meta['attribute'] }}="{{ $meta['name'] }}" content="{{ $meta['content'] }}">
@endforeach
@if ($seo['canonical'])
    <link inertia="canonical" rel="canonical" href="{{ $seo['canonical'] }}">
@endif
@if ($seo['structuredData'])
    <script inertia="structured-data" type="application/ld+json">{!! $seo['structuredData'] !!}</script>
@endif
