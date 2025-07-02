@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Technical Term</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('glossary.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="term" class="form-label">Term</label>
                            <input type="text" class="form-control @error('term') is-invalid @enderror" 
                                id="term" name="term" value="{{ old('term') }}" required>
                            @error('term')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Programming" {{ old('category') == 'Programming' ? 'selected' : '' }}>Programming</option>
                                <option value="Database" {{ old('category') == 'Database' ? 'selected' : '' }}>Database</option>
                                <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                                <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                <option value="Software Engineering" {{ old('category') == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="definition_en" class="form-label">English Definition</label>
                            <textarea class="form-control @error('definition_en') is-invalid @enderror" 
                                id="definition_en" name="definition_en" rows="3" required>{{ old('definition_en') }}</textarea>
                            @error('definition_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="definition_id" class="form-label">Indonesian Definition</label>
                            <textarea class="form-control @error('definition_id') is-invalid @enderror" 
                                id="definition_id" name="definition_id" rows="3" required>{{ old('definition_id') }}</textarea>
                            @error('definition_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pronunciation" class="form-label">Pronunciation (Optional)</label>
                            <input type="text" class="form-control @error('pronunciation') is-invalid @enderror" 
                                id="pronunciation" name="pronunciation" value="{{ old('pronunciation') }}">
                            @error('pronunciation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usage Examples</label>
                            <div id="usage-examples">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" 
                                        name="usage_example[]" placeholder="Enter a usage example">
                                    <button type="button" class="btn btn-outline-danger remove-example">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-example">
                                Add Example
                            </button>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('glossary.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Term</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('add-example').addEventListener('click', function() {
    const container = document.getElementById('usage-examples');
    const newExample = document.createElement('div');
    newExample.className = 'input-group mb-2';
    newExample.innerHTML = `
        <input type="text" class="form-control" name="usage_example[]" placeholder="Enter a usage example">
        <button type="button" class="btn btn-outline-danger remove-example">Remove</button>
    `;
    container.appendChild(newExample);
});

document.getElementById('usage-examples').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-example')) {
        e.target.parentElement.remove();
    }
});
</script>
@endpush
@endsection 