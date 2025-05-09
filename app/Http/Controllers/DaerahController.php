<?php

namespace App\Http\Controllers;

use App\Models\DaerahModel;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Daerah',
            'daerah'  => DaerahModel::oldest()->paginate(10)->withQueryString()
        ];
        return view('daerah.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daerah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_daerah' => ['required', 'unique:daerah', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
        ], [
            'nama_daerah.regex' => 'Nama daerah hanya boleh berisi huruf dan spasi.'
        ]);
        // Simpan data ke dalam model
        $daerah = new DaerahModel();
        $daerah->nama_daerah = $request->input('nama_daerah');

        // Simpan ke database
        $daerah->save();


        return redirect()->route('daerah.index')->with('message', 'Daerah Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $daerah = DaerahModel::find($id);
        return view('daerah.edit', compact('daerah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $daerah = DaerahModel::find($id);

        $daerah->nama_daerah =  $request->input('nama_daerah');

        $daerah->save();

        return redirect()->route('daerah.index')->with('message', "Daerah Berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daerah = DaerahModel::find($id);

        $daerah->delete();
        return redirect()->route('daerah.index')->with('message', 'Daerah Berhasil dihapus');
    }
}
