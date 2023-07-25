<?php

namespace App\Http\Controllers;

use App\Http\Resources\QueryAdapterCollection;
use App\Models\TahunAjaran;
use GhoniJee\DxAdapter\QueryAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Inertia\Response;

class TahunAjaranController extends Controller
{
    public function index(): Response
    {
        return inertia('tahun-ajaran/index', ['builder' => route('tahun-ajaran.builder')]);
    }

    public function builder(Request $request): ResourceCollection
    {
        $data = QueryAdapter::for(TahunAjaran::class, $request)->paginate($request->take ?? 10);
        return new QueryAdapterCollection($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tahun_ajaran' => 'required',
        ]);
        if ($request->has('is_aktif') && $request->is_aktif) {
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
            $form['is_aktif'] = true;
        }
        TahunAjaran::create($request->all());
        session()->flash("message", "Data berhasil disimpan");
        return redirect()->route('tahun-ajaran.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
        ]);
        if ($request->has('is_aktif') && $request->is_aktif) {
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
            $form['is_aktif'] = true;
        }
        TahunAjaran::find($id)->update($request->all());
        session()->flash("message", "Data berhasil diupdate");

        return redirect()->route('tahun-ajaran.index');
    }

    public function destroy($id)
    {
        $kelas = TahunAjaran::find($id);
        if (is_null($kelas)) {
            return back()->withErrors(['error' => 'Data not found']);
        }
        $kelas->delete();
        session()->flash("message", "Data berhasil dihapus");
        return redirect()->route('tahun-ajaran.index');
    }
}
