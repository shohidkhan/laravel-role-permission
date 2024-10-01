<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Permissons
            </h2>

            <a href="{{ route('permissions.create') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Create</a>
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
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    @if($permissions->isNotEmpty())
                    @foreach ($permissions as $permission) 
                    <tr class="text-white border-b hover:bg-gray-700">
                        <td class="px-4 py-4 text-center">{{ $permission->id }}</td>
                        <td class="px-4 py-4 text-center">{{ $permission->name }}</td>
                        <td class="px-4 py-4 text-center">{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Edit</a>
                            <a href="{{ route('permissions.destroy', $permission->id) }}" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    
                </tbody>
            </table>
            {{ $permissions->links() }}
        </div>
    </div>
</x-app-layout>
