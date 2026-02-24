@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <h4 class="fw-bold mb-3">Admin Dashboard</h4>
            <p>Welcome to the Restaurant Management System Admin Dashboard.</p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white p-4 text-center border-0 shadow-sm">
                        <h2 class="fw-bold">{{ \App\Models\Category::count() }}</h2>
                        <p class="mb-0">Categories</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white p-4 text-center border-0 shadow-sm">
                        <h2 class="fw-bold">{{ \App\Models\Meal::count() }}</h2>
                        <p class="mb-0">Meals</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
