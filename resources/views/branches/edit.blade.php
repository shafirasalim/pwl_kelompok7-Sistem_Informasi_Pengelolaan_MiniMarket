<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Cabang') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Nama Cabang')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $branch->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="city" :value="__('Kota')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $branch->city)" required />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="address" :value="__('Alamat Lengkap')" />
                        <textarea id="address" name="address" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('address', $branch->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('branches.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Kembali</a>
                        <x-primary-button class="ms-4">{{ __('Update') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>