@extends('layouts.main_layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/translations-list.css') }}">
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{url()->current()}}">
                    @csrf
                    @method('GET')
                    <div class="form-check form-control form-check-inline">
                        <label for="customRange2" class="form-label">Frequency</label>
                        <input name="frequency" type="range" class="form-range form-control" min="0" max="10000"
                               step="500" value="{{ $frequency ?: '10000' }}" id="customRange2"
                               oninput="output.value = customRange2.value">
                        <output id="output" for="customRange2">{{ $frequency ?: '10000' }}</output>
                    </div>

                    <div class="form-control">
                        @foreach(range(0,10) as $i)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $i }}"
                                       id="rating-filter-{{ $i }}"
                                       name="ratings[]" @if(in_array($i, $ratings)) checked="checked" @endif>
                                <label class="form-check-label" for="rating-filter-{{ $i }}">
                                    {{ $i }}
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>


                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered">
                    <colgroup>
                        <col span="1" style="width: 5%;">
                        <col span="1" style="width: 60%;">
                        <col span="1" style="width: 15%;">
                        <col span="1" style="width: 20%;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th scope="col" class="col-1">#</th>
                        <th scope="col">Translate</th>
                        <th scope="col">Word</th>
                        <th scope="col">Controls</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($words as $word)
                        <tr class="word-row" data-index="{{$word->id}}">
                            <td scope="row">{{$word->id}}</td>
                            <td>
                                @foreach($word->translations as $tr)
                                    <span class="word-wrapper" data-index="{{$tr->id}}">
                                        <span class="translation-word">
                                            {{$tr->word}}
                                        </span>
                                        <span class="translation-cross">
                                            &#10060;
                                        </span>

                                        @if(!$loop->last)
                                            <span class="translation-comma">
                                                ,
                                            </span>
                                        @endif
                                    </span>

                                @endforeach
                            </td>
                            <td class="translate">
                                {{$word->word}}
                            </td>
                            <td class="controls" >
                                <button type="button" class="btn btn-success known">&#10003;</button>
                                <button type="button" class="btn btn-secondary improve">+1</button>
                                <button type="button" class="btn btn-warning decrease">-1</button>
                                <button type="button" class="btn btn-success translation-add">&#8630;</button>
                                <button type="button" class="btn btn-danger removing">&#9746;</button>
                                {{--<button type="button" class="btn btn-warning">+1</button>--}}
                                {{--<button type="button" class="btn btn-primary">Primary</button>--}}
                                {{--<button type="button" class="btn btn-warning">Warning</button>--}}
                                {{--<button type="button" class="btn btn-info">Info</button>--}}
                                {{--<button type="button" class="btn btn-light">Light</button>--}}
                                {{--<button type="button" class="btn btn-dark">Dark</button>--}}
                                {{--<button type="button" class="btn btn-danger">-1</button>--}}
                            </td>
                        </tr>


                    @endforeach


                    </tbody>
                </table>
                {{ $words->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/translations-list.js') }}" defer></script>
@endsection
