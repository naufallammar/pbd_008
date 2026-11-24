<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaan = DB::select("SELECT * FROM v_penerimaan ORDER BY idpenerimaan DESC");
        return view('penerimaan.index', compact('penerimaan'));
    }

    public function create(Request $request)
    {
        $pengadaanList = DB::select("
            SELECT idpengadaan, timestamp, status, nama_vendor
            FROM v_pengadaan
            WHERE status != 'S'
            ORDER BY idpengadaan DESC
        ");

        $selectedPoId = $request->query('idpengadaan');
        $itemsPo = [];

        if ($selectedPoId) {
            $itemsPo = DB::select("
                SELECT idbarang, nama_barang, nama_satuan,
                       jumlah AS jumlah_pesan, harga_satuan,
                       sisa_belum_terima AS sisa_pesanan
                FROM v_detail_pengadaan
                WHERE idpengadaan = ? AND sisa_belum_terima > 0
            ", [$selectedPoId]);
        }

        return view('penerimaan.create', compact('pengadaanList', 'selectedPoId', 'itemsPo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpengadaan'   => 'required',
            'barang_id'     => 'required|array|min:1',
            'jumlah_terima' => 'required|array|min:1',
        ]);

        $iduser = Auth::id();

        try {
            DB::beginTransaction();

            $idpenerimaan_aktif = null;
            $adaYangDiproses = false;

            foreach ($request->barang_id as $key => $idbarang) {
                $qtyTerima = (int) $request->jumlah_terima[$key];
                if ($qtyTerima <= 0) continue;

                $sisaRow = DB::selectOne("SELECT f_sisa_pesanan(?, ?) AS sisa", [$request->idpengadaan, $idbarang]);
                if ($qtyTerima > $sisaRow->sisa) {
                    $barang = DB::selectOne("SELECT nama FROM barang WHERE idbarang = ?", [$idbarang]);
                    $namaBarang = $barang ? $barang->nama : 'Tidak diketahui';

                    throw new \Exception("Jumlah terima '$namaBarang' ($qtyTerima) melebihi sisa pesanan ({$sisaRow->sisa})!");
                }

                $poParam = ($idpenerimaan_aktif === null) ? $request->idpengadaan : null;

                $result = DB::select("CALL sp_tambah_item_penerimaan(?, ?, ?, ?, ?)", [
                    $idpenerimaan_aktif,
                    $poParam,
                    $iduser,
                    $idbarang,
                    $qtyTerima
                ]);

                if (!empty($result) && isset($result[0]->id_penerimaan)) {
                    $idpenerimaan_aktif = $result[0]->id_penerimaan;
                    $adaYangDiproses = true;
                }
            }

            if (!$adaYangDiproses) {
                throw new \Exception("Isi minimal satu barang dengan jumlah terima lebih dari 0.");
            }

            DB::commit();
            return redirect()->route('penerimaan.index')->with('success', 'Penerimaan Barang #' . $idpenerimaan_aktif . ' berhasil dicatat & stok bertambah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_system', 'Gagal memproses penerimaan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $header = DB::selectOne("SELECT * FROM v_penerimaan WHERE idpenerimaan = ?", [$id]);
        $details = DB::select("SELECT * FROM v_detail_penerimaan WHERE idpenerimaan = ?", [$id]);

        return view('penerimaan.show', compact('header', 'details'));
    }
}
