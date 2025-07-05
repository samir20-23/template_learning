<x-layout>
    <h1 class="title">Latest Posts</h1>

    {{-- List of posts --}}
    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            <x-postCard :post="$post" />
        @endforeach
    </div>

    {{-- Pagination links --}}
    <div>
        {{ $posts->links() }}
    </div>
</x-layout>
