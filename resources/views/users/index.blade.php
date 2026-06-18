<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Pegawai') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert type="success" />
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Pegawai</h3>
                    <a href="{{ route('users.create') }}"><x-primary-button>+ Tambah Pegawai</x-primary-button></a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm capitalize">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $user->role }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $user->branch ? $user->branch->name : '-' }}</td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>