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
                    <div class="mb-4">
                        <strong>Текущий файл:</strong>
                        @if($talk->file)
                            <a download="" href="{{ asset('storage/' . $talk->file) }}" target="_blank" class="text-blue-600 underline">
                                Скачать файл
                            </a>
                        @else
                            <span class="text-gray-500">Файл не прикреплён</span>
                        @endif
                    </div>

                    <x-splade-form :for="$form" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
