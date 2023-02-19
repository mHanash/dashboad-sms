<form action="#" method="POST" wire:submit.prevent='save'>
    <div class="row">
        <div class="col-md-4">
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-danger alert-block" data-target="alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
            </div>
            <div class=" sm:overflow-hidden sm:rounded-md">
                <h6 class="text-gray-500">Message</h6>
                <div class="space-y-6 bg-white px-2 py-3 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span
                                    class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">Titre</span>
                                <input required type="text" wire:model.defer='title' name="company-website"
                                    id="company-website"
                                    class="text-gray-500 block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="CENI-RDC">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="sms" class="block text-sm font-medium text-gray-700">Texte</label>
                        <div class="mt-1">
                            <textarea id="sms" required name="sms" rows="5" wire:model.defer='bodyMsg'
                                class=" text-gray-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Bonjour à tous, ceci est un test ..."></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Ce message sera envoyé après confirmation
                        </p>
                    </div>
                    <button title="Envoyer le message" class="btn btn-success">
                        <div wire:loading wire:target="save" class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>Envoyer
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class=" sm:overflow-hidden sm:rounded-md">
                <h6 class="text-gray-500">Numéros de téléphone</h6>
                <div class="d-flex">
                    <select wire:model='network'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Réseau</option>
                        @foreach ($networks as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model='province'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Province</option>
                        @foreach ($provinces as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model='city'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Ville</option>
                        @foreach ($cities as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p style="font-size:12px;color:#7f1d1d">Maintenir CTRL ou Command pour séléctionner plusieurs
                    numéros</p>
                <select wire:model='phoneNumbers' class="form-select" size="20" aria-label="size 3 select example"
                    multiple>
                    <option disabled selected>Sélectionner un ou plusieurs numéros</option>
                    @foreach ($phones as $item)
                        <option value="{{ $item->number }}">
                            {{ $item->number }}({{ $item->network->name }}-{{ $item->city->name }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</form>
