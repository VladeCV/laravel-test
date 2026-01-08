<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold mb-4">
                        {{ __("You're logged in!") }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{  url('/items') }}"
                           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                            <h3 class="text-lg font-medium text-gray-900">
                                Items
                            </h3>
                            <p class="text-sm text-gray-500">
                                Manage your items (create, edit, delete)
                            </p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
