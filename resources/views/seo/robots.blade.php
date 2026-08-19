{{-- resources/views/seo/robots.blade.php --}}
User-agent: *
@if(app()->environment('local', 'testing'))
Disallow: /
@else
Disallow: /admin
Disallow: /login
Disallow: /register
Disallow: /forgot-password
Disallow: /reset-password
Disallow: /verify-email
Disallow: /confirm-password
Allow: /
Sitemap: {{ route('sitemap') }}
@endif
