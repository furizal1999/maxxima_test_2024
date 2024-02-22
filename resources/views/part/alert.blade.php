@extends('part.alert')
@section('alert')
@if (($alertclass = Session::get('alertclass')) && ($message = Session::get('message')))
    {{-- {{ $message }} --}}
    <div class="alert alert-{{ $alertclass }} text-light alert-block">
        {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection