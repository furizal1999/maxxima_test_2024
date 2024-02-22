<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->mahasiswa = new Mahasiswa;
    }

    function index(Request $request){
        $data['getAllDataMahasiswa'] = $this->mahasiswa->getAllDataMahasiswa($request->search);
        return view('mahasiswa', $data);
    }

    function addForm(){
        return view('mahasiswa_addform');
    }

    function addProcess(Request $request){
        try {
            if(isset($request->addmahasiswa) && isset($request->_token)){
                $data = $request->validate([
                    'nim' => 'required|numeric|digits:10',
                    'nama' => 'required|string|max:250',
                    'jk' => 'required|in:L,P',
                    'alamat' => 'required|string',
                    'file_krs' => 'required|file|mimes:pdf|max:2048', // Hanya menerima file PDF maksimal 2MB
                    'matakuliah' => 'required|array',
                    'matakuliah.*' => 'string|max:255',
                ]);

                if($this->mahasiswa->getMahasiswa($data['nim'])->count()<1){
                    // Proses pengunggahan file PDF
                    if ($request->hasFile('file_krs')) {
                        $file_krs = $request->file('file_krs');
                        $fileName = date("YmdHis").$file_krs->getClientOriginalName();
                        if($file_krs->storeAs('file/krs', $fileName)){ // Menyimpan file di dalam direktori storage/app/file/krs
                            if($this->mahasiswa->addProcess($data, $fileName)){
                                $matakuliahData = [];
                                foreach ($data['matakuliah'] as $matakuliah) {
                                    $matakuliahData[] = [
                                        'nim' => $data['nim'],
                                        'nama_mk' => $matakuliah
                                    ];
                                }
                                $this->mahasiswa->addKRS($matakuliahData);
                                return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "success"])->with(['message' => "Data berhasil ditambahkan."]);
                            }else{
                                return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, data gagal ditambahkan."]);
                            }
                        }else{
                            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, file gagal diunggah."]);
                        }
                    }else{
                        return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, file harus ditambahkan."]);
                    }
                }else{
                    return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, NIM sudah tersedia."]);
                }
            }else{
                return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Oppss.. ada kesalahan."]);
            }
        } catch (\Throwable $th) {
            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Error. Silahkan coba lagi."]);
        }
    }

    function updateProcess(Request $request){
        // try {
            if(isset($request->updatemahasiswa) && isset($request->_token)){
                $data = $request->validate([
                    'nim' => 'required|numeric|digits:10',
                    'nama' => 'required|string|max:250',
                    'jk' => 'required|in:L,P',
                    'alamat' => 'required|string',
                    'file_krs' => 'file|mimes:pdf|max:2048', // Hanya menerima file PDF maksimal 2MB
                    'matakuliah' => 'required|array',
                    'matakuliah.*' => 'string|max:255',
                ]);

                if($this->mahasiswa->getMahasiswa($data['nim'])->count()>0){
                    // Proses pengunggahan file PDF
                    if ($request->hasFile('file_krs')) {
                        $file_krs = $request->file('file_krs');
                        $fileName = date("YmdHis").$file_krs->getClientOriginalName();
                        if(!$file_krs->storeAs('file/krs', $fileName)){ // Menyimpan file di dalam direktori storage/app/file/krs
                            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, file gagal diunggah."]);
                        }
                    }else{
                        $fileName = null;
                    }
                    // mengupdate data mahasiswa
                    $this->mahasiswa->updateProcess($data, $fileName);

                    $matakuliahData = [];
                    $mkBeforeArray = $this->mahasiswa->getMatakuliah($data['nim'])->get()->toArray();
                    $mkBeforeArray = array_column($mkBeforeArray, 'nama_mk');
                    foreach ($data['matakuliah'] as $matakuliah) {
                        if(!in_array($matakuliah, $mkBeforeArray)){
                            $matakuliahData[] = [
                                'nim' => $data['nim'],
                                'nama_mk' => $matakuliah,
                            ];
                        }
                    }

                    // $willDeleteData = [];
                    // dd($data['matakuliah']);
                    foreach ($mkBeforeArray as $before) {
                        
                        if(!in_array($before, $data['matakuliah'])){
                            // dd($before);
                            $this->mahasiswa->deleteKRSByNama($data['nim'], $before);
                        }
                    }

                    $this->mahasiswa->addKRS($matakuliahData);
                    return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "success"])->with(['message' => "Data berhasil diubah."]);
                }else{
                    return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, NIM sudah tersedia."]);
                }
            }else{
                return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Oppss.. ada kesalahan."]);
            }
        // } catch (\Throwable $th) {
        //     return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Error. Silahkan coba lagi."]);
        // }
    }

     function deleteProcess(Request $request){
        try {
            if(isset($request->deletemahasiswa) && isset($request->_token)){
                $data = $request->validate([
                    'nim' => 'required|numeric|digits:10',
                ]);

                if($this->mahasiswa->getMahasiswa($data['nim'])->count()>0){
                    if($this->mahasiswa->deleteProcess($data)){
                        return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "success"])->with(['message' => "Data berhasil dihapus."]);
                    }else{
                        return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, data gagal dihapus."]);
                    }
                }else{
                    return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, data yang dihapus tidak tersedia."]);
                }
            }else{
                return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Oppss.. ada kesalahan."]);
            }
        } catch (\Throwable $th) {
            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Error. Silahkan coba lagi."]);
        }
    }

    function updateForm($nim){
        if($getMahasiswa = $this->mahasiswa->getMahasiswa($nim)->first()){
            $data['getMahasiswa'] = $getMahasiswa;
            $data['getKRS'] = $this->mahasiswa->getKRS($nim);
            return view('mahasiswa_updateform', $data);
        }else{
            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, data tidak tersedia."]);
        }
        
    }

    function deleteForm($nim){
        if($getMahasiswa = $this->mahasiswa->getMahasiswa($nim)->first()){
            $data['getMahasiswa'] = $getMahasiswa;
            return view('mahasiswa_deleteform', $data);
        }else{
            return redirect(route("data.mahasiswa.getdata"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, data tidak tersedia."]);
        }
        
    }

    // function login(Request $request){
    //     $row = $this->login->getUser($request->email);
    //     if($row){
    //         if($row->account_status=="Active"){
    //             if(password_verify($request->password, $row->password)){
    //                 Session::put('login_smartlight', true);
    //                 Session::put('user_id', $row->user_id);
    //                 Session::put('email', $row->email);
    //                 Session::put('name', $row->name);
    //                 Session::put('sex', $row->sex);
    //                 Session::put('created_at', $row->created_at);
    //                 return redirect(route("user.control.light"));
    //                 exit;
    //             }else{
    //                 return redirect(route("user.auth"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, password tidak sesuai"]);
    //             }
    //         }else{
    //             return redirect(route("user.auth"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, Akun anda sedang tidak aktif!"]);
    //         }
    //     }else{
    //         return redirect(route("user.auth"))->with(['alertclass' => "danger"])->with(['message' => "Maaf, username yang anda masukkan salah!"]);
    //     }
    // }

    // function logout(){
    //     Session::flush();
    //     return redirect(route('user.auth'));
    // }
}
