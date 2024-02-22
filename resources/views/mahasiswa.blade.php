@extends('part.app')
@section('content')
  <h1>List Mahasiswa</h1>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <form action="{{ route('data.mahasiswa.getdata') }}" method="GET">
        @csrf()
        <div class="input-group">
          <div class="p-2">
            Kata kunci: 
          </div>
          <div class="form-outline inline" data-mdb-input-init>
            <input type="search" name="search" id="form1" class="form-control" />
          </div>
          <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
            <i class="fas fa-search"></i>
          </button>
        </div>
        <small><i>*Kata kunci berdasarkan nama, jenis kelamin, dan alamat</i></small>
      </form>
    </div>
  </div>
  <br>
  <a href="{{ route('data.mahasiswa.addform') }}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</a>
  <br>
  <br>
  @yield('alert')
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
  <br>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Jenis Kelamin</th>
        <th scope="col">Alamat</th>
        <th scope="col">Jumlah Matakuliah</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @php
        $no = 1;
      @endphp
      @foreach($getAllDataMahasiswa as $data)
      <tr>
        <th>{{ ($no++) }}</th>
        <td>{{ $data->nama }}</td>
        <td>{{ $data->jk=="L"?"Laki-laki":"Perempuan" }}</td>
        <td>{{ $data->alamat }}</td>
        <td>{{ $data->jumlah_mk }}</td>
        <td>
          <a href="{{ url('updateform').'/'.$data->nim }}" class="btn btn-secondary"><i class="fa fa-pen" aria-hidden="true"></i> Edit</a>
          <a href="{{ url('deleteform').'/'.$data->nim }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
        </td>
      </tr>
      @endforeach
      
    </tbody>
  </table>
@endsection