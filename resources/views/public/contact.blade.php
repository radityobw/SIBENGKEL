@extends('layouts.public')
@section('title', 'Contact Us - SIBENGKEL')

@section('content')
<main class="flex-grow max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop py-xl w-full">
    <div class="mb-lg">
        <h1 class="font-headline-lg text-headline-lg font-bold text-on-background mb-xs">Contact Us</h1>
        <div class="w-16 h-1 bg-secondary"></div>
    </div>
    
    <div class="prose prose-slate max-w-none text-on-surface-variant font-body-md text-body-md">
        <div class="grid md:grid-cols-2 gap-xl">
            {!! $page->content ?? '' !!}

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg">
                <h3 class="font-headline-md text-headline-md text-on-background font-bold mb-md">Send us a message</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800 p-4 rounded-lg mb-6 flex items-start gap-3">
                        <span class="material-symbols-outlined">check_circle</span>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="bg-error text-white p-4 rounded-lg mb-6">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded border border-outline-variant p-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-transparent dark:text-white dark:placeholder-gray-400" placeholder="Your full name" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded border border-outline-variant p-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-transparent dark:text-white dark:placeholder-gray-400" placeholder="your@email.com" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium mb-1">Message</label>
                        <textarea name="message" id="message" class="w-full rounded border border-outline-variant p-2 min-h-[120px] focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-transparent dark:text-white dark:placeholder-gray-400" placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="bg-primary text-on-primary font-bold py-2 px-6 rounded hover:opacity-90 w-full transition-opacity">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
