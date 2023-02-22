<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boite d\'envoie') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100" style="height:70vh;overflow:auto">
                    <button style="float: right" title="Ajouter une campagne" data-bs-toggle="modal"
                        data-bs-target="#createNetwork" class="btn btm-sm btn-primary">Ajouter</button>
                    <a href="{{ route('campaign') }}" style="float: right;margin-right:5px" title="Retour"
                        class="btn btm-sm btn-secondary">Retour</a>
                    <livewire:list-campaign-table :campaign="$campaign">
                </div>
            </div>
        </div>
    </div>
    <div style="height: 100vh;" class="modal fade" id="createNetwork" tabindex="-1"
        aria-labelledby="createNetworkLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNetworkLabel">Ajouter les participants</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0">
                    <livewire:list-campaign.create :campaign="$campaign">
                </div>
            </div>
        </div>
    </div>
    <div style="height: 100vh;" class="modal fade" id="show" tabindex="-1" aria-labelledby="showLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showLabel">Numéro associés</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0">
                    <livewire:list-campaign.show />
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('showModal', (event) => {
            Livewire.emit('details', event.detail.id);
            $('#show').modal('show');
        })
        window.addEventListener('deletedlist', (event) => {
            let id = event.detail.id;
            Swal.fire({
                title: 'Etes vous sûr?',
                text: "Veuillez confirmer l'action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmer'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteConfirmed', id)
                }
            })
        })
    </script>
</x-app-layout>
