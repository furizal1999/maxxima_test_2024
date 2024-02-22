@extends('part.app')
@section('content')
  <h1>Delete Mahasiswa</h1>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <form action="{{ route('data.mahasiswa.deleteform.process') }}" method="POST">
        @csrf()
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
          </div>
          <div class="col-md-6">
            <h4>Apakah anda yakin ingin menghapus data {{ $getMahasiswa->nama }} ?</h4>
            <input type="hidden" name="nim" value="{{ $getMahasiswa->nim }}">
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
          </div>
          <div class="col-md-6">
            <a href="{{ route('data.mahasiswa.getdata') }}" class="btn btn-secondary">Tidak</a>
            <input type="submit" name="deletemahasiswa" value="Ya, Yakin" class="btn btn-danger">
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection