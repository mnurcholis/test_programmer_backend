<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use App\Models\Settings;
use App\Models\SiteOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    public function index()
    {
        $page_title                 = 'Daftar Operator';
        $setting                    = Settings::find(1);

        return view('admin.data.operator.index', compact(['setting', 'page_title']));
    }

    public function json()
    {
        $data = Operator::orderBy('created_at', 'DESC');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<button id="button_edit_operator" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal_edit_operator" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="bi bi-pencil-square"></i></button>';
                $actionBtn .= ' <button id="button_delete_operator" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#modal_delete_operator" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="bi bi-trash-fill"></i></button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(Request $request)
    {
        $data = [
            'name'         => $request->name,
            'id_user'      => Auth::user()->id
        ];
        Operator::create($data);

        // Sending json response to client
        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Simpan Data"
        ]);
    }

    public function update(Request $request)
    {
        $data = [
            'name'         => $request->name,
            'updated_at'   => date("Y-m-d H:i:s")
        ];
        Operator::where('id', $request->id)->update($data);

        // Sending json response to client
        return response()->json([
            "status"    => true,
            "info"      => "Berhasil Update Data"
        ]);
    }

    public function delete(Request $request)
    {
        $check_count = SiteOperator::where(['id_operator' => $request->id]);
        if ($check_count->count() > 0) {
            return response()->json([
                "status"    => false,
                "info"      => "Tidak Bisa Hapus Data"
            ]);
        } else {
            $operator          = Operator::find($request->id);
            $operator->delete();

            // Sending json response to client
            return response()->json([
                "status"    => true,
                "info"      => "Berhasil Hapus Data"
            ]);
        }
    }
}
