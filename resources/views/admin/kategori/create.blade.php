<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="nama" :value="__('Nama Kategori')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-2 block w-full text-sm" :value="old('nama')" required autofocus placeholder="Contoh: Lampu Jalan" />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-2 block w-full border-gray-200 bg-white text-gray-900 rounded-lg focus:border-gray-900 focus:ring-gray-900 text-sm shadow-sm" placeholder="Jelaskan cakupan kategori ini...">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('admin.kategori.index') }}" class="text-gray-500 hover:text-gray-700 mr-6 font-medium text-sm transition-colors">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
