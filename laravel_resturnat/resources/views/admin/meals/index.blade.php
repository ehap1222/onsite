@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Meals</h4>
                <a href="{{ route('meals.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Meal
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meals as $meal)
                            <tr>
                                <td>
                                    @if($meal->image)
                                        <img src="{{ asset('storage/' . $meal->image) }}" alt="{{ $meal->name }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $meal->name }}</td>
                                <td><span class="badge bg-secondary">{{ $meal->category->name }}</span></td>
                                <td>${{ number_format($meal->price, 2) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('meals.edit', $meal) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('meals.destroy', $meal) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
