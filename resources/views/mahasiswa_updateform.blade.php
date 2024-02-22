@extends('part.app')
@section('content')
  <h1>Update Mahasiswa</h1>
  <hr>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <form action="{{ route('data.mahasiswa.updateform.process') }}" method="POST" class="mb-5" enctype="multipart/form-data">
          @csrf()
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="nim" class="col-form-label">Nomor Induk Mahasiswa</label>
          </div>
          <div class="col-md-6">
            <input type="text" name="nim" id="nim" value="{{ $getMahasiswa->nim }}" class="form-control" @readonly(true)>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="nim" class="col-form-label">Nama Mahasiswa</label>
          </div>
          <div class="col-md-6">
            <input type="text" name="nama" value="{{ $getMahasiswa->nama }}" id="nama" class="form-control" @required(true)>
          </div>
          <div class="col-auto">
            <span id="passwordHelpInline" class="form-text">
              Masukkan nama lengkap tanpa gelar.
            </span>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="jk" class="col-form-label">Jenis Kelamin</label>
          </div>
          <div class="col-md-6">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="jk" id="Laki-laki" value="L" <?php if($getMahasiswa->jk=="L"){ echo 'checked'; } ?>>
              <label class="form-check-label" for="Laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="jk" id="Perempuan" value="P" <?php if($getMahasiswa->jk=="P"){ echo 'checked'; } ?>>
              <label class="form-check-label" for="Perempuan">Perempuan</label>
            </div>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="alamat" class="col-form-label">Alamat</label>
          </div>
          <div class="col-md-6">
            <textarea name="alamat" class="form-control" cols="30" rows="7">{{ $getMahasiswa->alamat }}</textarea>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="nim" class="col-form-label">Matakuliah</label>
          </div>
          <div class="col-md-6">
            <div id="matakuliah-container">
              @if (!(count($getKRS)==0))
                  @foreach ($getKRS as $index => $item)
                    <div class="form-group input-group pb-3">
                      <input type="text" name="matakuliah[]" value="{{ $item->nama_mk }}" class="form-control" required>
                      <div class="input-group-append">
                          <button type="button" class="btn btn-success" onclick="addMatakuliahField()">Tambah</button>
                          @if ($index!=0)
                              <button type="button" class="btn btn-secondary" onclick="removeMatakuliahField(this)">Hapus</button>
                          @endif
                      </div>
                    </div>
                  @endforeach
              @else
                <div class="form-group input-group pb-3">
                  <input type="text" name="matakuliah[]" class="form-control" required>
                  <div class="input-group-append">
                      <button type="button" class="btn btn-success" onclick="addMatakuliahField()">Tambah</button>
                  </div>
                </div>
              @endif
              
          </div>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
            <label for="file_krs" class="col-form-label">Upload KRS</label>
          </div>
          <div class="col-md-6">
            @if ($getMahasiswa->file_krs != null)
              <a href="{{ url('/file/krs').'/'.$getMahasiswa->file_krs }}">Lihat File</a>
            @else
              <i class="text-danger">File belum tersedia.</i>
            @endif
            <br>
            <input type="file" name="file_krs" id="file_krs" class="form-control" accept=".pdf" @required(false)>
          </div>
          <div class="col-auto">
            <span id="passwordHelpInline" class="form-text">
              Ekstensi file: PDF dengan size max 2 MB.
            </span>
          </div>
        </div>
        <br>
        <div class="row g-3 align-items-center form-group">
          <div class="col-md-2">
          </div>
          <div class="col-md-6">
            <a href="{{ route('data.mahasiswa.getdata') }}" class="btn btn-secondary">Kembali</a>
            <input type="submit" name="updatemahasiswa" value="Simpan Perubahan" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    function addMatakuliahField() {
        var div = document.createElement('div');
        div.classList.add('form-group', 'input-group', 'pb-2');
        div.innerHTML = '<input type="text" name="matakuliah[]" class="form-control" required>' +
                        '<div class="input-group-append">' +
                        '<button type="button" class="btn btn-success" onclick="addMatakuliahField()">Tambah</button>' +
                        '<button type="button" class="btn btn-secondary" onclick="removeMatakuliahField(this)">Hapus</button>' +
                        '</div>';
        document.getElementById('matakuliah-container').appendChild(div);
    }

    function removeMatakuliahField(element) {
        element.parentNode.parentNode.remove();
    }
</script>
@endsection