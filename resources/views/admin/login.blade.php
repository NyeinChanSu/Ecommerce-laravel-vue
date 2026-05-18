@extends('admin.layouts.app')

@section('title', 'Admin Login')

@section('content') 
<div class="row justify-content-center mt-5"> 
    <div class="col-md-4"> <div class="card"> 
        <div class="card-header text-center"> 
            <h4>Admin Login</h4> 
        </div> 
        <div class="card-body"> 
            <form method="POST" action="{{ route('admin.login.submit') }}"> 
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter admin email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

</div> 
@endsection