@extends('layouts.public')
@section('title', $page->title . ' - SIBENGKEL')

@section('content')
<main class="flex-grow max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop py-xl w-full">
    <div class="mb-lg">
        <h1 class="font-headline-lg text-headline-lg font-bold text-on-background mb-xs">{{ $page->title }}</h1>
        <div class="w-16 h-1 bg-secondary"></div>
    </div>
    
    <div class="prose prose-slate max-w-none text-on-surface-variant font-body-md text-body-md">
        {!! $page->content !!}
    </div>
</main>
@endsection
