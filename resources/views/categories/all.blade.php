@extends('layouts.master')
@section('content')

<div class="accordion" id="accordionExample">
    @foreach($list as $key => $item)
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{$key}}" aria-expanded="false" aria-controls="collapseOne">
                    {{$item->id}} - {{$item->name}} - ({{count($item->children_categories)}})
                </button>
            </h2>
            <div id="{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Filhos: 
                    <ul>
                        @foreach($item->children_categories as $keyy => $itemm)
                            <li>{{$itemm->id}} - {{$itemm->name}}</li>
                        @endforeach     
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection