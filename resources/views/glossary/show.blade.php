@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $term->term }}</h4>
                    <div>
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('glossary.edit', $term) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('glossary.destroy', $term) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        @endauth
                        <a href="{{ route('glossary.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="card-body">
                    @if($term->pronunciation)
                        <div class="mb-4">
                            <h5>Pronunciation</h5>
                            <p class="text-muted">{{ $term->pronunciation }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Category</h5>
                        <p>{{ $term->category }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">English Definition</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $term->definition_en }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Indonesian Definition</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $term->definition_id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Usage Examples</h5>
                        <ul class="list-group">
                            @foreach($term->usage_example as $example)
                                <li class="list-group-item">{{ $example }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 