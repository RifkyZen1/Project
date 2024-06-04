<x-app-layout title="Home">
        @section('hero')
        {{-- <div class="py-16 px-20 object-bottom" style="background-image: url('https://c.stocksy.com/a/KWr700/z9/1874032.jpg'); background-size: 100% 110%; background-position: center bottom; background-repeat: no-repeat;"> --}}
            <div class="w-full text-center">
                <div class="text-shadow text-shadow-[#3e4b92] text-shadow-blur-6">
                    <p class="mt-5 font-body font-bold text-center text-black md:text-6xl text-4xl">
                        CARI ARTIKEL MENARIK DI  <br><span class="text-shadow-x-4 text-blue-500"> RHBLOG </span>
                    </p>
                </div>
                <a class="inline-block px-3 py-2 mt-10 text-lg text-white bg-gray-800 rounded" href="http://rhblog.test/blog">
                    Mulai Membaca
                </a>
            </div>
        {{-- </div> --}}
            @endsection
            
            <div class="w-full mt-16 mb-10">
                <div class="mb-16">
                    <h2 class=" mb-5 text-3xl font-bold text-blue-500">Post Unggulan </h2>
                    <div class="w-full">
                        <div class="grid w-full grid-cols-3 gap-10 ">
                            @foreach ($featuredPosts as $post)
                            <x-posts.post-card :post="$post" class="col-span-3 md:col-span-1 " />
                            @endforeach
                        </div>
                    </div>
                    <a class="block mt-10 text-lg font-semibold text-center text-blue-500"
                    href="http://rhblog.test/blog?sort=desc">Post Lainnya</a>
                </div>
                <hr>
                
                <h2 class=" mt-6 mb-5 text-3xl font-bold text-blue-500">Post Terbaru</h2>
                <div class="w-full mb-5">
                    <div class="grid w-full grid-cols-3 gap-10">
                        @foreach ($latestPosts as $post)
                        <x-posts.post-card :post="$post" class="col-span-3 md:col-span-1" />
                        @endforeach
                    </div>
                </div>
                <a class="block mt-10 text-lg font-semibold text-center text-blue-500" href="http://rhblog.test/blog?sort=asc">Post Lainnya</a>
            
            </div>

        </x-app-layout>