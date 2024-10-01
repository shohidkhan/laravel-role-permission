<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create Articles
            </h2>

            <a href="{{ route('articles.index') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(Session::has('success'))
                <div class="p-4 mb-4 text-sm font-bold text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <form action="{{ route('articles.store') }}" method="POST">
                    @csrf
                        <div>
                            <label for="name" class="text-lg font-medium ">Title</label>
                            <div class="my-3">
                                <input type="text" class="w-1/2 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300 focus:ring focus:ring-green-600 focus:ring-opacity-50" name="title" placeholder="Enter Title" value="{{ old('title') }}">
                                @error('title')
                                    <p class="font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="name" class="text-lg font-medium ">Author</label>
                            <div class="my-3">
                                <input type="text" class="w-1/2 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300 focus:ring focus:ring-green-600 focus:ring-opacity-50" name="author" placeholder="Enter author name" value="{{ old('author') }}">
                                @error('author')
                                    <p class="font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="name" class="text-lg font-medium ">Description</label>
                            <div class="my-3">
                                <textarea type="text" class="w-1/2 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300 focus:ring focus:ring-green-600 focus:ring-opacity-50" name="text" placeholder=" Description " cols="10" rows="5">{{ old('text') }}</textarea>
                                @error('text')
                                    <p class="font-medium text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Save</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
