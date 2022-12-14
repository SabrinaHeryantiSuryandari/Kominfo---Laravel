<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\pelaksana;
use App\Models\barang;
use App\Models\jadwal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengadaan = DB::table('pengadaans')
            ->join('pelaksanas', 'pelaksana_id', '=', 'pelaksanas.id')
            ->select('pengadaans.*', 'pelaksanas.pt_pelaksana',)
            ->get();
        // $pengadaan = Pengadaan::all();
        $pelaksana = Pelaksana::all();
        // $barang = Barang::all();
        // $jadwals = Jadwal::all();

        return view(
            'admin.input_pengadaan',
            // 'admin.input_pengadaan',
            ['pengadaan' => $pengadaan],
            ['pelaksana' => $pelaksana]
        );

        // return view('admin.input_pengadaan',compact('pengadaans'))
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function index1()
    {
        // $pengadaan1 = Pengadaan::select('select * where nilai_negosiasi <= 10000000');
        $pengadaan1 = DB::table('pengadaans')
        ->join('pelaksanas', 'pelaksana_id', '=', 'pelaksanas.id')
        ->join('jadwals', 'pengadaan_id', '=', 'pengadaans.id')
        // ->join('barangs', 'pengadaan_id', '=', 'pengadaans.id')
        ->select('pengadaans.*', 'pelaksanas.pt_pelaksana', 'pelaksanas.alamat', 'pelaksanas.nama_pelaksana', 'pelaksanas.jabatan_pelaksana', 'pelaksanas.kode_rekening', 'pelaksanas.npwp', 'pelaksanas.tlp',
        'jadwals.kegiatan', 'jadwals.alokasi', 'jadwals.hari', 'jadwals.tanggal', 'jadwals.nomor', 'jadwals.deskripsi_tgl',
        // 'barangs.barang', 'barangs.jumlah_barang', 'barangs.satuan', 'barangs.harga_satuan'
        )

        ->where('nilai_negosiasi', '<=', 50)
        ->get();
        // $jadwal1 = DB::table('jadwals')
        //     ->where('nilai_negosiasi', '<=', 50)
        //     ->join('pelaksanas', 'pelaksana_id', '=', 'pelaksanas.id')
        //     ->join('jadwals', 'pengadaan_id', '=', 'pengadaans.id')
        //     // ->join('barangs', 'pengadaan_id', '=', 'pengadaans.id')
        //     ->select('pengadaans.*', 'pelaksanas.pt_pelaksana', 'pelaksanas.alamat', 'pelaksanas.nama_pelaksana', 'pelaksanas.jabatan_pelaksana', 'pelaksanas.kode_rekening', 'pelaksanas.npwp', 'pelaksanas.tlp',
        //         'jadwals.kegiatan', 'jadwals.alokasi', 'jadwals.hari', 'jadwals.tanggal', 'jadwals.nomor', 'jadwals.deskripsi_tgl',
        //         // 'barangs.barang', 'barangs.jumlah_barang', 'barangs.satuan', 'barangs.harga_satuan'
        //         )
        //     ->get();

        // $jadwal = Jadwal::all();
        // $pelaksana = Pelaksana::all();

        return view(
            'admin.pengadaan1',
            ['pengadaan1' => $pengadaan1],
            // ['jadwal' => $jadwal],
            // ['pelaksana' => $pelaksana]
        );

        // return redirect()->route('pengadaan.index');
    }

    public function index2()
    {
        // $pengadaan2 = Pengadaan::select('select * where nilai_negosiasi > 10000000');
        $pengadaan2 = DB::table('pengadaans')
            ->where('nilai_negosiasi', '>', 50)
            ->join('pelaksanas', 'pelaksana_id', '=', 'pelaksanas.id')
            ->join('jadwals', 'pengadaan_id', '=', 'jadwals.id')
            ->select('pengadaans.*', 'pelaksanas.pt_pelaksana', 'pelaksanas.alamat', 'pelaksanas.nama_pelaksana', 'pelaksanas.jabatan_pelaksana', 'pelaksanas.kode_rekening', 'pelaksanas.npwp', 'pelaksanas.tlp',
                'jadwals.kegiatan', 'jadwals.alokasi', 'jadwals.hari', 'jadwals.tanggal', 'jadwals.nomor', 'jadwals.deskripsi_tgl',
                'barangs.barang', 'barangs.jumlah_barang', 'barangs.satuan', 'barangs.harga_satuan')
            ->get();

        return view(
            'admin.pengadaan2',
            ['pengadaan2' => $pengadaan2]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.input_pengadaan');
        // $pelaksana = Pelaksana::all();
        // $pengadaans = Pengadaan::all();
        // $barang = Barang::all();

        // return view('pengadaan', compact('pelaksanas'));
        return view('admin.input_pengadaan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'id' => 'required',
            'pelaksana_id' => 'required',
            'jenis_pengadaan' => 'required',
            'total_hps' => 'required',
            'deskripsi_hps' => 'required',
            'harga_penawaran' => 'required',
            'deskripsi_penawaran' => 'required',
            'nilai_negosiasi' => 'required',
            'deskripsi_negosiasi' => 'required'
        ]);

        Pengadaan::create($request->post());

        return redirect()->route('pengadaan.index')
            ->with('success', 'Data Pelaksana Berhasil Ditambahkan');
        // return redirect()->to('input_jadwal');
        // return redirect()->route('home')
        //                 ->with('success','Aset Berhasil Dihapus!');


        // return redirect()->route('jadwals.index')
        //                 ->with('success','Data Pelaksana Berhasil Disimpan!');

        // $pelaksana =   Pelaksana::create($request->except([

        //     'jenis_pengadaan',
        //     'tanggal_acara',
        //     'deskripsi_tgl_acara',
        //     'waktu_acara',
        //     'tempat_acara',
        //     'total_hps',
        //     'deskripsi_hps',
        //     'nilai_negosiasi',
        //     'deskripsi_nilai_nego',        
        // ]));

        // $request['pelaksana_id'] = $pelaksana->id;
        // $pengadaan = Pengadaan::create($request->only([
        //     'pelaksana_id',
        //     'jenis_pengadaan',
        //     'tanggal_acara',
        //     'deskripsi_tgl_acara',
        //     'waktu_acara',
        //     'tempat_acara',
        //     'total_hps',
        //     'deskripsi_hps',
        //     'nilai_negosiasi',
        //     'deskripsi_nilai_nego'        
        // ]));

        // return back()->with('success',' Post baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pengadaan $pengadaan)
    {
        // return view('admin.input_pengadaan', compact('pengadaan'));
        return view('pengadaan.index', compact('pengadaan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengadaan $pengadaan)
    {

        // $pengadaan = Pengadaan::where('id', $pengadaan)->first();
        // return view('admin.edit', compact('pengadaan'));
        return view('admin.input_pengadaan', compact('pengdaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, pengadaan $pengadaan)
    public function update(Request $request, $id)
    {
        $pengadaan = Pengadaan::find($id)->update($request->all()); 

        return back()->with('success',' Data telah diperbaharui!');

        // $pengadaan = Pengadaan::where('id', $pengadaan)->first();
        // // $pengadaan->
        // // $pengadaan
        // $request->validate([
        //     // 'id' => 'required',
        //     'pelaksana_id' => 'required',
        //     'jenis_pengadaan' => 'required',
        //     'total_hps' => 'required',
        //     'deskripsi_hps' => 'required',
        //     'harga_penawaran' => 'required',
        //     'deskripsi_penawaran' => 'required',
        //     'nilai_negosiasi' => 'required',
        //     'deskripsi_negosiasi' => 'required'
        // ]);

        // Pengadaan::create($request->post());

        // return redirect()->to('input_jadwal');


        // $pengadaan =   Pelaksana::updating($request->except([
        //     'pelaksana_id',
        //     'jenis_pengadaan',
        //     'total_hps',
        //     'deskripsi_hps',
        //     'harga_penawaran',
        //     'deskripsi_penawaran',
        //     'nilai_negosiasi',
        //     'deskripsi_negosiasi'
        // ]));

        // $request['pelaksana_id'] = $pelaksanas ->id;
        // $pengadaans = Pengadaan::updating($request->only([
        //     'pelaksana_id',
        //     'jenis_pengadaan',
        //     'total_hps',
        //     'deskripsi_hps',
        //     'harga_penawaran',
        //     'deskripsi_penawaran',
        //     'nilai_negosiasi',
        //     'deskripsi_negosiasi'  
        // ]));

        // return back()->with('success',' Post baru berhasil dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengadaan  $pengadaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengadaan $pengadaan)
    {
        $pengadaan->delete();

        return redirect()->route('pengadaan.index')
            ->with('success', 'Pengadaan Berhasil Dihapus!');
    }
    // public function destroy1(pengadaan $pengadaan1)
    // {
    //     $pengadaan1->delete();

    //     return redirect()->route('pengadaan.index1')
    //         ->with('success', 'Pengadaan Berhasil Dihapus!');
    // }
}
