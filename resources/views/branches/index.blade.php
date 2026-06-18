<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Cabang') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert type="success" />
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Cabang</h3>
                    <a href="{{ route('branches.create') }}"><x-primary-button>+ Tambah Cabang</x-primary-button></a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($branches as $branch)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-medium">{{ $branch->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $branch->city }}</td>
                                <td class="px-6 py-4 text-sm">{{ $branch->address }}</td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('branches.edit', $branch->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
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