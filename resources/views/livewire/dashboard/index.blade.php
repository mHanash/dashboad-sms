<div>
    <div class="row">
        <div class="col-md-4">
            <div style="height:90px;padding:10px" class="text-dark card bg-success">
                <h3 style="text-align: center;font-size:20px;font-weight: 800;color:beige;">Total SMS restant
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
                    Message envoyés
                </h4>
                <span
                    style="text-align: center;font-size:30px;font-weight: 800;color:rgb(174, 72, 72);">{{ number_format($countSendSMS) }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div style="height:90px;padding:10px" class="text-dark card bg-warning">
                <h4 style="text-align: center;font-size:20px;font-weight: 800;color:rgb(92, 99, 110);">
                    Numéros
                    pas
                    envoyés</h4>
                <span
                    style="text-align: center;font-size:30px;font-weight: 800;color:rgb(174, 72, 72);">{{ number_format($countNotSendSMS) }}</span>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-4">
            <h4>Répartition d'abonnés par réseau</h4>
            <div class="card bg-dark p-4 mt-1">
                <h4>Total</h4>
                <table class="table-sm table-bordered bg-light text-dark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Envoyés</th>
                            <th>Pas envoyés</th>
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
                                <td>{{ count($item->phonesSend($item)) }}</td>
                                <td>{{ count($item->phonesNotSend($item)) }}</td>
                                <td>{{ count($item->phones) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Statistique par filtre</h4>
            <div class="card bg-dark p-4 mt-1">
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
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <ul class="mt-3">
                        <li>Nombre d'abonnés total : {{ number_format(count($phones)) }}</li>
                        <li>Message envoyés : {{ number_format(count($phonesSend)) }}</li>
                        <li>Message pas encore envoyés : {{ number_format(count($phonesNotSend)) }}</li>
                    </ul>
                    <hr>
                    Total Province : {{ number_format($provinceCount) }}
                </div>
            </div>
        </div>
    </div>
</div>
