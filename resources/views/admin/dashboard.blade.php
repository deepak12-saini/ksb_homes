@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-card">
        <h2 style="margin-top:0;">Dashboard</h2>
        <p><a href="{{ route('admin.projects.index') }}" class="admin-btn">Manage Projects</a></p>
    </div>
@endsection
