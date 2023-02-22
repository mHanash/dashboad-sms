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
                <li class="list-group-item list-group-item-primary">{{ $i }}) {{ $item->number }}
                    ({{ $item->city->name }}-{{ $item->network->name }})
                </li>
            @endforeach
        @endisset
    </ul>
</div>
