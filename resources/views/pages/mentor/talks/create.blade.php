<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title  }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">
                        Обсуждение с: <span class="text-blue-600">{{ $mentorName }}</span>
                    </h2>
                    <x-splade-form :for="$form" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
