<div id="recommended-topics-box">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Kategori</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ($categories as $category)
            <x-badge wire:navigate href=" {{ route('posts.index', ['category' => $category->title]) }} " :textColor="$category->text_color" :bgColor="$category->bg_color">
                {{ $category->title }}
            </x-badge>
        @endforeach
    </div>
</div>