<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title  }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                    <a href="{{ route('admin::assignment.create') }}" class="ml-auto bg-black rounded-md px-4 py-2.5 font-medium text-white text-center">{{ __('Добавить') }}</a>
                    <x-splade-table :for="$assignments">
                        @cell('action', $assignment)
                        <Link href="{{ route("admin::assignment.edit", ['assignment' => $assignment]) }}">{{ __('Редактировать') }}</Link>
                        <Link href="{{ route("admin::assignment.destroy", ['assignment' => $assignment]) }}"
                              method="DELETE" confirm="Удалить запись"
                              confirm-text="Запись будет удалена. Продолжить?" confirm-button="Да"
                              cancel-button="Нет"
                              class="text-red-600">
                            {{ __('Удалить') }}
                        </Link>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
