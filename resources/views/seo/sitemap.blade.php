<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Parent Landing --}}
    <url>
        <loc>{{ route('landing') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Academic Portfolio --}}
    <url>
        <loc>{{ route('academic') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($academicRecords as $record)
    <url>
        <loc>{{ route('academic', $record->slug) }}</loc>
        <lastmod>{{ $record->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Music Portfolio --}}
    <url>
        <loc>{{ route('music') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($musicRecords as $record)
    <url>
        <loc>{{ route('music', $record->slug) }}</loc>
        <lastmod>{{ $record->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Contact Page --}}
    <url>
        <loc>{{ route('contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
</urlset>
