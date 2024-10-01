<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Users Lists
            </h2>
            @can('create user')
                
            <a href="{{ route('users.create') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Create</a>
            @endcan
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
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    @if($users->isNotEmpty())
                    @foreach ($users as $user) 
                    <tr class="text-white border-b hover:bg-gray-700">
                        <td class="px-4 py-4 text-center">{{ $user->id }}</td>
                        <td class="px-4 py-4 text-center">{{ $user->name }}</td>
                        <td class="px-4 py-4 text-center">{{ $user->email }}</td>
                        <td class="px-4 py-4 text-center">
                            @if($user->roles->isNotEmpty())
                            @foreach ($user->roles->pluck('name') as $role_name)
                            <span class="px-1 py-1 text-xs font-medium text-white bg-green-900 rounded me-2 dark:bg-green-900 ">
                                {{ $role_name }}
                            </span>
                            @endforeach
                            @else
                            This user has no roles
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                        <td class="px-4 py-4 text-center">
                            @can('edit user')
                                
                            <sa href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Edit</sa>
                            @endcan
                            @can('delete user')
                                
                            <a href="" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
