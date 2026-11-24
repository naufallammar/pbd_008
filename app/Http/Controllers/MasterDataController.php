<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function indexRole()
    {
        $roles = DB::select("SELECT * FROM view_role ORDER BY idrole ASC");
        return view('master.role', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['nama_role' => 'required|max:100']);
        DB::insert("INSERT INTO role (nama_role) VALUES (?)", [$request->nama_role]);
        return redirect()->route('master.role')->with('success', 'Role berhasil ditambahkan!');
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate(['nama_role' => 'required|max:100']);
        DB::update("UPDATE role SET nama_role = ? WHERE idrole = ?", [$request->nama_role, $id]);
        return redirect()->route('master.role')->with('success', 'Role berhasil diperbarui!');
    }

    public function destroyRole($id)
    {
        try {
            DB::delete("DELETE FROM role WHERE idrole = ?", [$id]);
            return redirect()->route('master.role')->with('success', 'Role berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('master.role')->with('error', 'Role tidak bisa dihapus karena sedang dipakai oleh User.');
        }
    }

    // ==================== 2. MASTER USER ====================
    public function indexUser()
    {
        $users = DB::select("SELECT * FROM v_detail_user ORDER BY iduser ASC");
        $roles = DB::select("SELECT * FROM view_role ORDER BY idrole ASC");
        return view('master.user', compact('users', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|max:45',
            'password' => 'required|max:100',
            'idrole'   => 'required|integer',
        ]);

        DB::insert("INSERT INTO user (username, password, idrole) VALUES (?, ?, ?)", [
            $request->username,
            $request->password,
            $request->idrole,
        ]);

        return redirect()->route('master.user')->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:45',
            'idrole'   => 'required|integer',
        ]);

        if ($request->filled('password')) {
            DB::update("UPDATE user SET username = ?, password = ?, idrole = ? WHERE iduser = ?", [
                $request->username,
                $request->password,
                $request->idrole,
                $id,
            ]);
        } else {
            DB::update("UPDATE user SET username = ?, idrole = ? WHERE iduser = ?", [
                $request->username,
                $request->idrole,
                $id,
            ]);
        }

        return redirect()->route('master.user')->with('success', 'Data User berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        try {
            DB::delete("DELETE FROM user WHERE iduser = ?", [$id]);
            return redirect()->route('master.user')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('master.user')->with('error', 'User tidak bisa dihapus karena memiliki riwayat transaksi.');
        }
    }

    // ==================== 3. MASTER SATUAN ====================
    public function indexSatuan()
    {
        $satuan = DB::select("SELECT * FROM v_satuan ORDER BY idsatuan ASC");
        return view('master.satuan', compact('satuan'));
    }

    public function storeSatuan(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|max:45',
            'status'      => 'required|in:0,1',
        ]);

        DB::insert("INSERT INTO satuan (nama_satuan, status) VALUES (?, ?)", [
            strtoupper($request->nama_satuan),
            $request->status,
        ]);

        return redirect()->route('master.satuan')->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function updateSatuan(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|max:45',
            'status'      => 'required|in:0,1',
        ]);

        DB::update("UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?", [
            strtoupper($request->nama_satuan),
            $request->status,
            $id,
        ]);

        return redirect()->route('master.satuan')->with('success', 'Satuan berhasil diperbarui!');
    }

    public function destroySatuan($id)
    {
        try {
            DB::delete("DELETE FROM satuan WHERE idsatuan = ?", [$id]);
            return redirect()->route('master.satuan')->with('success', 'Satuan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('master.satuan')->with('error', 'Satuan tidak bisa dihapus karena masih dipakai oleh Master Barang.');
        }
    }

    // ==================== 4. MASTER VENDOR ====================
    public function indexVendor()
    {
        $vendors = DB::select("SELECT * FROM v_vendor ORDER BY idvendor DESC");
        return view('master.vendor', compact('vendors'));
    }

    public function storeVendor(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|max:100',
            'badan_hukum' => 'required|max:2',
            'status'      => 'required|in:0,1',
        ]);

        DB::insert("INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)", [
            $request->nama_vendor,
            strtoupper($request->badan_hukum),
            $request->status,
        ]);

        return redirect()->route('master.vendor')->with('success', 'Vendor berhasil ditambahkan!');
    }

    public function updateVendor(Request $request, $id)
    {
        $request->validate([
            'nama_vendor' => 'required|max:100',
            'badan_hukum' => 'required|max:2',
            'status'      => 'required|in:0,1',
        ]);

        DB::update("UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?", [
            $request->nama_vendor,
            strtoupper($request->badan_hukum),
            $request->status,
            $id,
        ]);

        return redirect()->route('master.vendor')->with('success', 'Data Vendor berhasil diperbarui!');
    }

    public function destroyVendor($id)
    {
        try {
            DB::delete("DELETE FROM vendor WHERE idvendor = ?", [$id]);
            return redirect()->route('master.vendor')->with('success', 'Vendor berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('master.vendor')->with('error', 'Vendor tidak bisa dihapus karena sudah memiliki riwayat Pengadaan.');
        }
    }
        // ==================== 5. MASTER MARGIN PENJUALAN ====================
    public function indexMargin(Request $request)
    {
        $marginAktif = DB::selectOne("
            SELECT * FROM v_riwayat_margin
            WHERE status_margin = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ");

        $persenSimulasi = $request->input('persen', $marginAktif ? $marginAktif->persen : 10);

        $laporan = DB::select("
            SELECT
                idbarang,
                nama_barang,
                jenis,
                nama_satuan,
                harga AS harga_modal,
                f_cek_stok_terakhir(idbarang) AS stok_saat_ini,
                f_hitung_profit_bersih(harga, ?) AS profit_bersih,
                (harga + f_hitung_profit_bersih(harga, ?)) AS harga_jual_proyeksi
            FROM v_katalog_barang
            WHERE status = 1
            ORDER BY nama_barang ASC
        ", [$persenSimulasi, $persenSimulasi]);

        $riwayatMargin = DB::select("SELECT * FROM v_riwayat_margin ORDER BY persen ASC");

        return view('master.margin', compact('laporan', 'persenSimulasi', 'marginAktif', 'riwayatMargin'));
    }

    public function storeMargin(Request $request)
    {
        $request->validate(['persen' => 'required|numeric|min:0|max:500']);
        $iduser = session('iduser') ?? 1;

        DB::beginTransaction();
        try {
            DB::update("UPDATE margin_penjualan SET status = 0, updated_at = NOW()");
            DB::insert("
                INSERT INTO margin_penjualan (persen, status, iduser, created_at, updated_at)
                VALUES (?, 1, ?, NOW(), NOW())
            ", [
                $request->persen,
                $iduser,
            ]);
            DB::commit();
            return redirect()->route('master.margin')->with('success', 'Opsi margin baru (' . $request->persen . '%) berhasil ditambahkan dan diaktifkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master.margin')->with('error', 'Gagal menyimpan margin: ' . $e->getMessage());
        }
    }

    public function aktifkanMargin($id)
    {
        DB::beginTransaction();
        try {
            DB::update("UPDATE margin_penjualan SET status = 0, updated_at = NOW()");
            DB::update("UPDATE margin_penjualan SET status = 1, updated_at = NOW() WHERE idmargin_penjualan = ?", [$id]);
            DB::commit();
            return redirect()->route('master.margin')->with('success', 'Margin aktif kasir berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('master.margin')->with('error', 'Gagal mengaktifkan margin: ' . $e->getMessage());
        }
    }
        public function nonaktifkanMargin($id)
    {
        DB::update("UPDATE margin_penjualan SET status = 0, updated_at = NOW() WHERE idmargin_penjualan = ?", [$id]);
        return redirect()->route('master.margin')->with('success', 'Margin berhasil dinonaktifkan!');
    }


}
