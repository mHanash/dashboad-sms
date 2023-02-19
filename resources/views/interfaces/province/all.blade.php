<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Les provinces') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100" style="height:70vh;overflow:auto">
                    <button style="float: right" title="Ajouter une province" data-bs-toggle="modal"
                        data-bs-target="#createProvince" class="btn btn-primary">Ajouter</button>
                    <livewire:province-table />
                </div>
            </div>
        </div>
    </div>
    <div style="height: 100vh; padding:0" class="modal fade" id="createProvince" tabindex="-1"
        aria-labelledby="createProvinceLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProvinceLabel">Nouvel enregistrement</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0">
                    <livewire:province.create />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
