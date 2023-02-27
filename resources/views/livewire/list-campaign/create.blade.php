<form action="" method="post" wire:submit.prevent='save'>
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                Description
            </label>
        </div>
        <div class="md:w-2/3">
            <input required placeholder="Ex. Nord Kivu"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                id="inline-full-name" type="text" wire:model.defer='description'>
        </div>
    </div>
    <div class=" sm:overflow-hidden sm:rounded-md">
        <h6 class="text-gray-500">Numéros de téléphone associés</h6>
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
                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->phones()->count() }})</option>
                @endforeach
            </select>
        </div>
        <p style="font-size:12px;color:#7f1d1d">Maintenir CTRL ou Command pour séléctionner plusieurs
            numéros</p>
        <div wire:loading wire:target="phones" class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        {{ $phones->links() }}
        <select wire:model='datas' wire:change='selectChange' class="form-select" size="16"
            aria-label="size 3 select example" multiple>
            <option disabled selected>Sélectionner un ou plusieurs numéros</option>
            @foreach ($phones as $item)
                @php
                    $test = false;
                @endphp
                @if (count($phoneNumbers) > 0)
                    @if (in_array($item->id, $phoneNumbers))
                        @php
                            $test = true;
                        @endphp
                    @endif
                @endif
                @if ($test)
                    <option class="text-primary font-bold" value="{{ $item->id }}">
                        {{ $item->number }}({{ $item->network->name }}-{{ $item->city->name }})</option>
                @else
                    <option value="{{ $item->id }}">
                        {{ $item->number }}({{ $item->network->name }}-{{ $item->city->name }})</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Fermer</a>
        <button class="btn btn-sm btn-primary">Enregistrer</button>
    </div>
</form>
