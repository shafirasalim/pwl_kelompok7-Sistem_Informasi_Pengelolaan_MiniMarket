<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Pegawai') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password (Kosongkan jika tidak ingin mengubah)')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Role / Jabatan')" />
                        <x-select name="role" id="role" required class="block mt-1 w-full">
                            <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="supervisor" {{ old('role', $user->role) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="cashier" {{ old('role', $user->role) == 'cashier' ? 'selected' : '' }}>Cashier</option>
                            <option value="warehouse" {{ old('role', $user->role) == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                        </x-select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="branch_id" :value="__('Cabang')" />
                        <x-select name="branch_id" id="branch_id" class="block mt-1 w-full">
                            <option value="">-- Pilih Cabang (Kosongkan jika Owner) --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Kembali</a>
                        <x-primary-button class="ms-4">{{ __('Update') }}</x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>