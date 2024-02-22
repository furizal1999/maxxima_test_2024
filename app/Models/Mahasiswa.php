<?php

//sudah
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Model
{
    use HasFactory;
    function getAllDataMahasiswa($search){
        $data = DB::table('mahasiswa')
            ->select('mahasiswa.*', DB::raw('(SELECT COUNT(*) FROM krs WHERE krs.nim = mahasiswa.nim) AS jumlah_mk'))
            ->where('nama', 'like', '%'.$search.'%')
            ->orWhere('jk', 'like', '%'.$search.'%')
            ->orWhere('alamat', 'like', '%'.$search.'%')
            ->orderBy('created_at', 'DESC')
            ->get();

        return $data;
    }

    function getMahasiswa($nim){
        $data = DB::table('mahasiswa')
            ->where('nim', $nim);
        return $data;
    }

    function getKRS($nim){
        $data = DB::table('krs')
            ->where('nim', $nim)
            ->orderBy('id_krs', 'asc')
            ->get();
        return $data;
    }

    function addProcess($data, $fileName){
        return DB::table('mahasiswa')
            ->insert([
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'alamat' => $data['alamat'],
                'file_krs' => $fileName,
            ]);
    }

    function addKRS($data){
        return DB::table('krs')
            ->insert($data);
    }

    function updateProcess($data, $fileName){
        // dd($data);
        if(!empty($fileName)){
            return DB::table('mahasiswa')
                ->where('nim', $data['nim'])
                ->update([
                    'nama' => $data['nama'],
                    'jk' => $data['jk'],
                    'alamat' => $data['alamat'],
                    'file_krs' => $fileName
                ]);
        }else{
            return DB::table('mahasiswa')
                ->where('nim', $data['nim'])
                ->update([
                    'nama' => $data['nama'],
                    'jk' => $data['jk'],
                    'alamat' => $data['alamat']
                ]);
        }
    }

    function checkMatakuliah($matakuliah){
        return DB::table('krs')
            ->where('nama_mk', $matakuliah);
    }

    function getMatakuliah($nim){
        return DB::table('krs')
            ->select('nama_mk')
            ->where('nim', $nim);
    }

    function deleteMahasiswa($data){
        return DB::table('mahasiswa')
            ->where('nim', $data['nim'])
            ->delete();
    }

    function deleteKRS($nim){
        return DB::table('krs')
            ->where('nim', $nim)
            ->delete();
    }

    function deleteKRSByNama($nim, $nama_mk){
        return DB::table('krs')
            ->where('nim', $nim)
            ->where('nama_mk', $nama_mk)
            ->delete();
    }

    function deleteProcess($data){
        $this->deleteKRS($data['nim']);
        return $this->deleteMahasiswa($data);
    }



    // function selectRequest($lamp_to){
    //     $data = DB::table('tb_light_status')
    //         ->where("status_data", "=", "Available")
    //         ->where("lamp_to", "=", $lamp_to)
    //         ->orderby('id_light_status', 'desc')->first();
    //     if($data){
    //         return $data->lamp_status;
    //     }else{
    //         return 0;
    //     }
	// }
}
