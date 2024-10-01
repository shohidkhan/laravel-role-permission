<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Roles
            </h2>

            <a href="{{ route('roles.create') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Create</a>
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
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Permission</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    @if($roles->isNotEmpty())
                    @foreach ($roles as $role) 
                    <tr class="text-white border-b hover:bg-gray-700">
                        <td class="px-4 py-4 text-center">{{ $role->id }}</td>
                        <td class="px-4 py-4 text-center">{{ $role->name }}</td>
                        <td class="px-4 py-4 text-center w-96 justify-items-center">
                            @if($role->permissions->isNotEmpty())
                            
                                
                                @foreach ($role->permissions->pluck('name') as $permission_name)
                                <span class="px-1 py-1 text-xs font-medium text-white bg-green-900 rounded me-2 dark:bg-green-900 ">
                                    {{ $permission_name }}
                                </span>
                                {{-- {{ $role->permissions->pluck('name') }} --}}
                                @endforeach
                            
                            @else
                            Has All Permission
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                        <td class="flex justify-center gap-2 px-4 py-4 text-center">
                            <a href="{{ route('roles.edit', $role->id) }}" class="px-2 py-1 font-bold text-white bg-green-500 rounded hover:bg-green-700">Edit</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-white">No roles found</td>
                    </tr>
                    @endif
                    
                </tbody>
            </table>
            {{ $roles->links() }}
        </div>
    </div>
</x-app-layout>
