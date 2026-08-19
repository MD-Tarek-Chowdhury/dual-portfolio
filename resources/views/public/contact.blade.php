{{-- resources/views/public/contact.blade.php --}}
<x-public-layout
    :title="'Contact'"
    theme="academic"
    :heroImage="null"
    :heroTitle="'Get in Touch'"
    :heroSubtitle="'Reach out for academic collaborations or music bookings'">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">

        {{-- Left Column: Academic Contact --}}
        <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-academic/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-academic" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Academic</h2>
                    <p class="text-sm text-gray-500">For research, teaching, and academic inquiries</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-academic mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email</p>
                        <a href="mailto:{{ $academicContact['email'] }}" class="text-sm text-academic hover:text-academic-dark">{{ $academicContact['email'] }}</a>
                    </div>
                </div>

                @if($academicContact['office'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-academic mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Office</p>
                        <p class="text-sm text-gray-600">{{ $academicContact['office'] }}</p>
                    </div>
                </div>
                @endif

                @if($academicContact['hours'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-academic mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Office Hours</p>
                        <p class="text-sm text-gray-600">{{ $academicContact['hours'] }}</p>
                    </div>
                </div>
                @endif

                @if($academicContact['phone'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-academic mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Phone</p>
                        <a href="tel:{{ $academicContact['phone'] }}" class="text-sm text-gray-600">{{ $academicContact['phone'] }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Music Contact --}}
        <div class="bg-stone-50 rounded-2xl p-8 border border-stone-200 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-music/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-music" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-stone-800">Music</h2>
                    <p class="text-sm text-stone-500">For bookings, gigs, and music inquiries</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-music mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">Email</p>
                        <a href="mailto:{{ $musicContact['email'] }}" class="text-sm text-music hover:text-music-neon">{{ $musicContact['email'] }}</a>
                    </div>
                </div>

                @if($musicContact['studio'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-music mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">Studio</p>
                        <p class="text-sm text-stone-600">{{ $musicContact['studio'] }}</p>
                    </div>
                </div>
                @endif

                @if($musicContact['booking'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-music mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">Booking Status</p>
                        <p class="text-sm text-stone-600">{{ $musicContact['booking'] }}</p>
                    </div>
                </div>
                @endif

                @if($musicContact['phone'])
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-music mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">Phone</p>
                        <a href="tel:{{ $musicContact['phone'] }}" class="text-sm text-stone-600">{{ $musicContact['phone'] }}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Contact Form --}}
    <div class="mt-16 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800 mb-2 text-center">Send a Message</h2>
            <p class="text-gray-500 text-center mb-8">Choose who you'd like to contact below</p>

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Contact Type Toggle --}}
                <div class="flex justify-center gap-4 mb-6">
                    <label class="cursor-pointer">
                        <input type="radio" name="contact_type" value="academic" class="peer sr-only" checked>
                        <div class="px-6 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-academic peer-checked:bg-academic/5 peer-checked:text-academic transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                            <span class="font-medium">Academic</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="contact_type" value="music" class="peer sr-only">
                        <div class="px-6 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-music peer-checked:bg-music/5 peer-checked:text-music transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <span class="font-medium">Music</span>
                        </div>
                    </label>
                </div>

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-academic focus:ring-academic transition-colors"
                           placeholder="Your name">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-academic focus:ring-academic transition-colors"
                           placeholder="your@email.com">
                </div>

                {{-- Subject --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-academic focus:ring-academic transition-colors"
                           placeholder="What's this about?">
                </div>

                {{-- Message --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="message" id="message" rows="5" required
                              class="w-full rounded-lg border-gray-300 focus:border-academic focus:ring-academic transition-colors resize-none"
                              placeholder="Write your message here...">{{ old('message') }}</textarea>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 px-6 bg-academic text-white font-medium rounded-xl hover:bg-academic-dark focus:outline-none focus:ring-2 focus:ring-academic focus:ring-offset-2 transition-all duration-200">
                    Send Message
                </button>
            </form>
        </div>
    </div>

</x-public-layout>
