<?php

namespace App\Http\Controllers;

use App\Http\Resources\QueryAdapterCollection;
use App\Models\Kelas;
use GhoniJee\DxAdapter\QueryAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Inertia\Response;

class KelasController extends Controller
{
    public function index(): Response
    {
        return inertia('kelas/index', ['builder' => route('kelas.builder')]);
    }

    public function builder(Request $request): ResourceCollection
    {
        $data = QueryAdapter::for(Kelas::class, $request)->paginate($request->take ?? 10);
        return new QueryAdapterCollection($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas',
        ]);
        Kelas::create($request->all());
        session()->flash("message", "Data berhasil disimpan");
        return redirect()->route('kelas.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . ($id ? ",$request->kelas" : ''),
        ]);
        Kelas::find($id)->update($request->all());
        session()->flash("message", "Data berhasil diupdate");

        return redirect()->route('kelas.index');
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        if (is_null($kelas)) {
            return back()->withErrors(['error' => 'Data not found']);
        }
        $kelas->delete();
        session()->flash("message", "Data berhasil dihapus");
        return redirect()->route('kelas.index');
    }
}
