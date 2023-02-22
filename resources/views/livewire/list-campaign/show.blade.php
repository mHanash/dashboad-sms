<div class="row mb-2" style="height: 60vh;overflow:auto">
    <ul class="list-group">
        @isset($list)
            @php
                $i = 0;
            @endphp
            @foreach ($list->phones as $item)
                @php
                    $i++;
                @endphp
                <div class="d-fex">
                    <li class="list-group-item list-group-item-primary">
                        <div class="d-flex">
                            <div>
                                {{ $i }}) {{ $item->number }}
                                ({{ $item->city->name }}-{{ $item->network->name }})
                            </div>
                            <div
                                style="background-color: {{ $item->pivot->is_submit ? '#9dd0a7' : '#d69696' }}; margin-left:10px;padding:0 3px">
                                Status :
                                {{ $item->pivot->is_submit ? 'Envoyer' : 'Pas envoyer' }}
                            </div>
                        </div>
                    </li>
                </div>
            @endforeach
        @endisset
    </ul>
</div>
