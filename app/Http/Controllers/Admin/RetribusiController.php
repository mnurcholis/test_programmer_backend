<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retribusi;
use App\Models\Settings;
use App\Models\SiteOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RetribusiController extends Controller
{
    public function index()
    {
        $page_title               = 'Retribusi Operator';
        $setting                  = Settings::find(1);
        $data['data_site']        = SiteOperator::query()
            ->select('site_operators.id', 'site_operators.name', 'site_operators.site_id', 'site_operators.alamat', 'operators.name as operators_name', 'site_operators.titik_koordinat', 'site_operators.ketinggian', 'site_operators.tahun', 'site_operators.id_operator')
            ->join('operators', 'operators.id', '=', 'site_operators.id_operator')
            ->orderBy('site_operators.created_at', 'DESC')
            ->get();

        return view('admin.retribusi.index', compact(['setting', 'page_title']))->with($data);
    }

    public function json()
    {
        $data = Retribusi::query()
            ->select('retribusis.id', 'retribusis.id_user', 'retribusis.id_operator', 'retribusis.id_site', 'retribusis.retribusi', 'retribusis.tanggal', 'operators.name as operator_name', 'site_operators.name as site_name', 'site_operators.site_id')

            ->join('operators', 'operators.id', '=', 'retribusis.id_operator')
            ->join('site_operators', 'site_operators.id', '=', 'retribusis.id_site')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<button id="button_edit_retribusi" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal_edit_retribusi" data-id="' . $row->id . '" data-id_site="' . $row->id_site . '" data-retribusi="' . $row->retribusi . '" data-tanggal="' . $row->tanggal . '"><i class="bi bi-pencil-square"></i></button>';
                $actionBtn .= ' <button id="button_delete_retribusi" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#modal_delete_retribusi" data-id="' . $row->id . '" data-name="' . $row->site_name . ' - ' . $row->site_id . ' - ' . $row->operator_name . '"><i class="bi bi-trash-fill"></i></button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(Request $request)
    {
        $data_site = SiteOperator::find($request->id_site_operator);
        $data = [
            'id_site'   => $request->id_site_operator,
            'id_operator'   => $data_site->id_operator,
            'id_user'   => Auth::user()->id,
            'retribusi' => $request->retribusi,
            'tanggal'    => $request->tanggal
        ];
        Retribusi::create($data);

        // Sending json response to client
        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Simpan Data",
        ]);
    }

    public function update(Request $request)
    {
        $data_site = SiteOperator::find($request->id_site_operator);
        $data = [
            'id_site'   => $request->id_site_operator,
            'id_operator'   => $data_site->id_operator,
            'id_user'   => Auth::user()->id,
            'retribusi' => $request->retribusi,
            'tanggal'    => $request->tanggal
        ];
        Retribusi::where('id', $request->id)->update($data);

        // Sending json response to client
        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Update Data"
        ]);
    }

    public function delete(Request $request)
    {
        $retribusi          = Retribusi::find($request->id);
        $retribusi->delete();

        // Sending json response to client
        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Hapus Data"
        ]);
    }
}
