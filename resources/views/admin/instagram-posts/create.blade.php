@extends('admin.layout')

@section('title', 'Add Instagram Post')

@section('content')
    @include('admin.instagram-posts._form', [
        'formAction' => route('admin.instagram-posts.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'Create Post',
    ])
@endsection
