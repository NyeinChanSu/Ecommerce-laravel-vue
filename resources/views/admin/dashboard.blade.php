@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>Admin Dashboard</h1>
        </div>
        <div class="card-body">
            <p>Welcome, {{ auth()->user()->name }}</p>
        </div>
    </div>
</div>
@endsection
