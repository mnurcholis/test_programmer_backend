<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use App\Models\Settings;
use App\Models\SiteOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SiteController extends Controller
{
    public function index()
    {
        $page_title                 = 'Daftar Site Operator';
        $setting                    = Settings::find(1);
        $data['data_operator']      = Operator::get();

        return view('admin.data.site.index', compact(['setting', 'page_title']))->with($data);
    }

    public function json()
    {
        $data = SiteOperator::query()
            ->select('site_operators.id', 'site_operators.name', 'site_operators.site_id', 'site_operators.alamat', 'operators.name as operators_name', 'site_operators.titik_koordinat', 'site_operators.ketinggian', 'site_operators.tahun', 'site_operators.id_operator')
            ->join('operators', 'operators.id', '=', 'site_operators.id_operator')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<button id="button_edit_operator" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal_edit_operator" data-id="' . $row->id . '" data-name="' . $row->name . '" data-site_id="' . $row->site_id . '" data-alamat="' . $row->alamat . '" data-id_operator="' . $row->id_operator . '" data-titik_koordinat="' . $row->titik_koordinat . '" data-ketinggian="' . $row->ketinggian . '" data-tahun="' . $row->tahun . '"><i class="bi bi-pencil-square"></i></button>';
                $actionBtn .= ' <button id="button_delete_operator" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#modal_delete_operator" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="bi bi-trash-fill"></i></button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(Request $request)
    {
        $check_count = SiteOperator::where(['site_id' => $request->site_id]);
        if ($check_count->count() > 0) {
            return response()->json([
                "status"    => 'site_id',
                "info"      => "Site Id sudah Ada...!!"
            ]);
        } else {
            $data = [
                'id_operator' => $request->id_operator,
                'name' => $request->name,
                'site_id' => $request->site_id,
                'alamat' => $request->alamat,
                'ketinggian' => $request->ketinggian,
                'tahun' => $request->tahun,
                'titik_koordinat' => $request->titik_koordinat,
                'id_user' => Auth::user()->id
            ];
            SiteOperator::create($data);

            // Sending json response to client
            return response()->json([
                "status"    => true,
                "info"      => "Berhasil Simpan Data"
            ]);
        }
    }

    public function update(Request $request)
    {
        $check_count = SiteOperator::where(['site_id' => $request->site_id])->where('id', '!=', $request->id);
        if ($check_count->count() > 0) {
            return response()->json([
                "status"    => 'site_id',
                "info"      => "Site Id sudah Ada...!!"
            ]);
        } else {
            $data = [
                'id_operator' => $request->id_operator,
                'name' => $request->name,
                'site_id' => $request->site_id,
                'alamat' => $request->alamat,
                'ketinggian' => $request->ketinggian,
                'tahun' => $request->tahun,
                'titik_koordinat' => $request->titik_koordinat,
                'id_user' => Auth::user()->id
            ];
            SiteOperator::where('id', $request->id)->update($data);

            // Sending json response to client
            return response()->json([
                "status"    => true,
                "info"      => "Berhasil Update Data"
            ]);
        }
    }

    public function delete(Request $request)
    {
        $site          = SiteOperator::find($request->id);

        // Sending json response to client
        if ($site->delete()) {
            return response()->json([
                "status"    => true,
                "info"      => "Berhasil Hapus Data"
            ]);
        } else {
            return response()->json([
                "status"    => false,
                "info"      => "Gagal Hapus Data"
            ]);
        }
    }
}
