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
                               step="500" value="{{ $frequency }}" id="customRange2"
                               oninput="output.value = customRange2.value">
                        <output id="output" for="customRange2">{{ $frequency }}</output>
                    </div>

                    <div class="form-control">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>


                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="col-1">Group</th>
                        <th scope="col">Known</th>
                        <th scope="col">Graph</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statistic['stat'] as $k => $v)
                        <tr>
                            <td scope="row">{{$k}}</td>
                            <td>
                                {{$v}}
                            </td>
                            <td>
                                {{ str_pad('', ceil(($v * 100) / $statistic['sum']), '#') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{$statistic['sum']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{--    <script src="{{ asset('js/translations-list.js') }}" defer></script>--}}
@endsection
