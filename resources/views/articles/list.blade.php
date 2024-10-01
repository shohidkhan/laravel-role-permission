<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Permissons
            </h2>

            <a href="{{ route('articles.create') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Create</a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(Session::has('success'))
            <div class="p-4 mb-4 text-sm font-bold text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
            <table class="w-full ">
                <thead class="bg-white dark:bg-gray-800">
                    <tr class="text-white border-b">
                        <th class="px-4 py-2 ">#</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Author</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    @if($articles->isNotEmpty())
                    @foreach ($articles as $article) 
                    <tr class="text-white border-b hover:bg-gray-700">
                        <td class="px-4 py-4 text-center">{{ $article->id }}</td>
                        <td class="px-4 py-4 text-center">{{ $article->title }}</td>
                        <td class="px-4 py-4 text-center">{{ $article->author }}</td>
                        <td class="px-4 py-4 text-center">{{ $article->text }}</td>
                        <td class="px-4 py-4 text-center">{{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}</td>
                        <td class="flex justify-center gap-2 px-4 py-4 text-center">
                            <a href="{{ route('articles.edit', $article->id) }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Edit</a>
                            <a href="{{ route('articles.show', $article->id) }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">View</a>

                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    
                </tbody>
            </table>
            {{ $articles->links() }}
        </div>
    </div>
</x-app-layout>
