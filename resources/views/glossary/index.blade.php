@extends('layouts.app')

@section('styles')
<style>
.category-filter {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.term-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
}

.term-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.pronunciation {
    color: #6c757d;
    font-style: italic;
}

.definition-preview {
    color: #495057;
    font-size: 0.95rem;
}

.category-badge {
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 15px;
    background-color: #e9ecef;
    color: #495057;
    margin-right: 5px;
}

.search-box {
    position: relative;
    margin-bottom: 25px;
}

.search-box .form-control {
    padding-left: 40px;
    border-radius: 20px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.language-switch {
    margin-bottom: 20px;
}
</style>
@endsection

@section('content')
<div class="container mx-auto px-4">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Technical Terms Glossary</h1>
            <p class="text-gray-600 mt-2">English for Computer Science - Comprehensive Technical Terms Dictionary</p>
        </div>
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('glossary.create') }}" class="mt-4 md:mt-0 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full inline-flex items-center transition duration-150">
                    <i class="fas fa-plus mr-2"></i> Add New Term
                </a>
            @endif
        @endauth
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Search Box -->
            <div class="md:col-span-2">
                <form action="{{ route('glossary.search') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" 
                            class="w-full bg-gray-50 border border-gray-200 rounded-full py-3 px-4 pl-12 focus:outline-none focus:ring-2 focus:ring-red-600"
                            placeholder="Search technical terms..." value="{{ $query ?? '' }}">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
            </div>
            <!-- Category Filter -->
            <div>
                <select id="categoryFilter" class="w-full bg-gray-50 border border-gray-200 rounded-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-red-600">
                    <option value="">All Categories</option>
                    <option value="Programming">Programming</option>
                    <option value="Database">Database</option>
                    <option value="Networking">Networking</option>
                    <option value="Security">Security</option>
                    <option value="Web Development">Web Development</option>
                    <option value="Software Engineering">Software Engineering</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Language Switch -->
    <div class="flex justify-center mb-8">
        <div class="inline-flex rounded-full border border-gray-200 p-1">
            <button type="button" class="px-6 py-2 rounded-full bg-red-600 text-white" data-language="en">English</button>
            <button type="button" class="px-6 py-2 rounded-full text-gray-700 hover:bg-gray-100" data-language="id">Indonesian</button>
        </div>
    </div>

    <!-- Terms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($terms as $term)
        <div class="term-item bg-white rounded-lg shadow-sm hover:shadow-md transition duration-150" data-category="{{ $term->category }}">
            <div class="p-6">
                <!-- Term Header -->
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $term->term }}</h3>
                        @if($term->pronunciation)
                            <p class="text-gray-500 text-sm italic mt-1">{{ $term->pronunciation }}</p>
                        @endif
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $term->category }}</span>
                </div>

                <!-- Definitions -->
                <div class="space-y-4 mb-4">
                    <div class="definition-en">
                        <h4 class="text-sm font-semibold text-gray-600 mb-1">English Definition</h4>
                        <p class="text-gray-700">{{ Str::limit($term->definition_en, 100) }}</p>
                    </div>
                    <div class="definition-id">
                        <h4 class="text-sm font-semibold text-gray-600 mb-1">Indonesian Definition</h4>
                        <p class="text-gray-700">{{ Str::limit($term->definition_id, 100) }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('glossary.show', $term) }}" class="text-red-600 hover:text-red-700 font-medium">
                        View Details
                    </a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <div class="flex space-x-2">
                                <a href="{{ route('glossary.edit', $term) }}" class="text-yellow-600 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('glossary.destroy', $term) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $terms->links() }}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Filter
    const categoryFilter = document.getElementById('categoryFilter');
    const termItems = document.querySelectorAll('.term-item');

    categoryFilter.addEventListener('change', function() {
        const selectedCategory = this.value;
        
        termItems.forEach(item => {
            if (!selectedCategory || item.dataset.category === selectedCategory) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Language Switch
    const languageButtons = document.querySelectorAll('[data-language]');
    languageButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update button styles
            languageButtons.forEach(btn => {
                btn.classList.remove('bg-red-600', 'text-white');
                btn.classList.add('text-gray-700', 'hover:bg-gray-100');
            });
            this.classList.remove('text-gray-700', 'hover:bg-gray-100');
            this.classList.add('bg-red-600', 'text-white');

            // Toggle definitions
            const language = this.dataset.language;
            const definitions = document.querySelectorAll('.definition-en, .definition-id');
            definitions.forEach(def => {
                if (def.classList.contains(`definition-${language}`)) {
                    def.style.order = '1';
                    def.style.display = 'block';
                } else {
                    def.style.order = '2';
                    def.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush
@endsection 