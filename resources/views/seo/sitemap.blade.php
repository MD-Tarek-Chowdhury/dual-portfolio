{{-- resources/views/seo/sitemap.blade.php --}}
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Static Pages --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('academic') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('music') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    {{-- Academic Section Pages --}}
    @foreach(['bio', 'research', 'teaching'] as $section)
    <url>
        <loc>{{ route('academic', $section) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Music Section Pages --}}
    @foreach(['band', 'discography', 'courses', 'booking'] as $section)
    <url>
        <loc>{{ route('music', $section) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Academic Records --}}
    @foreach($academicRecords as $record)
    <url>
        <loc>{{ route('academic.record.show', $record->slug) }}</loc>
        <lastmod>{{ $record->updated_at->toIso8601String() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    {{-- Music Records --}}
    @foreach($musicRecords as $record)
    <url>
        <loc>{{ route('music.record.show', $record->slug) }}</loc>
        <lastmod>{{ $record->updated_at->toIso8601String() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
