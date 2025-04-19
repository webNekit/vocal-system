<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title  }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$users">
                        @cell('action', $user)
                            <Link href="{{ route("admin::user.edit", ['user' => $user]) }}">{{ __('Редактировать') }}</Link>
                            <Link href="{{ route("admin::user.destroy", ['user' => $user]) }}"
                            method="DELETE" confirm="Удалить пользователя" confirm-text="Пользователь будет удален. Продолжить?" confirm-button="Да" cancel-button="Нет"
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
