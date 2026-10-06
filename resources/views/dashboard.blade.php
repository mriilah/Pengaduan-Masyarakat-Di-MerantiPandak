<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white leading-tight uppercase tracking-wider">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-charcoal border border-charcoal overflow-hidden">
                <div class="p-6 text-white uppercase tracking-wider text-sm">
                    {{ __("Anda berhasil login!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
