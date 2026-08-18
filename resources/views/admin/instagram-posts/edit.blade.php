@extends('admin.layout')

@section('title', 'Edit Instagram Post')

@section('content')
    @include('admin.instagram-posts._form', [
        'formAction' => route('admin.instagram-posts.update', $post),
        'formMethod' => 'PUT',
        'submitLabel' => 'Save Changes',
        'post' => $post,
    ])
@endsection
