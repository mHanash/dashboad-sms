<div>
    <div class="row">
        <div class="col-md-4">
            <div style="height:90px;padding:10px" class="text-dark card bg-success">
                <h3 style="text-align: center;font-size:20px;font-weight: 800;color:beige;">Balance crédit
                </h3>
                @if (count($responseSolde) == 0)
                    <div style="text-align: center">
                        <div style="color:aliceblue" class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                @else
                    <span
                        style="text-align: center;font-size:30px;font-weight: 800;color:rgb(174, 72, 72);">{{ $solde }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div style="height:90px;padding:10px" class="text-dark card bg-info">
                <h4 style="text-align: center;font-size:20px;font-weight: 800;color:rgb(92, 99, 110);">
                    Campagnes
                </h4>
                <span
                    style="text-align: center;font-size:30px;font-weight: 800;color:rgb(174, 72, 72);">{{ number_format($countCampaign) }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div style="height:90px;padding:10px" class="text-dark card bg-warning">
                <h4 style="text-align: center;font-size:20px;font-weight: 800;color:rgb(92, 99, 110);">
                    Total numéros</h4>
                <span
                    style="text-align: center;font-size:30px;font-weight: 800;color:rgb(174, 72, 72);">{{ number_format($countTotPhones) }}</span>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-4">
            <h4>Répartition d'abonnés par réseau</h4>
            <div class="card bg-white dark:bg-dark p-4 mt-1">
                <h4 class="text-dark">Total</h4>
                <table class="table-sm table-bordered bg-light text-dark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Envoyé</th>
                            <th>Attente</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($networks as $item)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format(App\Models\Network::phonesSend($item)) }}</td>
                                <td>{{ number_format(App\Models\Network::phonesNotSend($item)) }}</td>
                                <td>{{ number_format($item->phones()->count()) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Détails</h4>
            <div class="card bg-white bg-dark p-4 mt-1">
                <div class="d-flex">
                    <select wire:model='campaign'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Campagnes</option>
                        @foreach ($campaigns as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model='list'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Listes</option>
                        @foreach ($listCampaigns as $item)
                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <ul class="mt-3 text-dark">
                        <div wire:loading wire:target="list,campaign" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <li>Nombre de message envoyé : {{ number_format($phonesListSend) }}</li>
                        <li>Nombre de message non envoyé : {{ number_format($phonesListNotSend) }}</li>
                        <li>Total de la liste : {{ number_format($phonesListSend + $phonesListNotSend) }}</li>
                    </ul>
                    <hr class="text-dark">
                    <span class="text-dark">Total de listes : {{ number_format($phonesListTot) }}</span><span
                        class="text-dark"> | Total
                        messages envoyés : {{ number_format($countCampaignListSend) }}</span>
                </div>
            </div>
            <h4>Statistique par filtre</h4>
            <div class="card bg-white bg-dark p-4 mt-1">
                <div class="d-flex">
                    <select wire:model='network'
                        class="block text-gray-500 appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8  leading-tight focus:outline-none ">
                        <option value="0">Réseau</option>
                        @foreach ($networks_filter as $item)
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
                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->phones()->count() }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <ul class="mt-3 text-dark">
                        <div wire:loading wire:target="province,city" class="spinner-border spinner-border-sm"
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <li>Nombre d'abonnés total : {{ number_format($phonesCount) }}</li>
                    </ul>
                    <hr class="text-dark">
                    <span class="text-dark">Total Province : {{ number_format($provinceCount) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
