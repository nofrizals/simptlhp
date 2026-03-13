<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Level;
use App\Models\Tim;
use App\Models\Unor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        $instansis = Unor::whereRaw('CHAR_LENGTH(kode_unor) <= 5')
            ->whereRaw('RIGHT(kode_unor, 2) < 32')
            ->get()
            ->map(fn($i) => [
                'kode' => $i->kode_unor,
                'nama' => $i->nama_unor,
                'tipe' => 'instansi',
            ]);

        $kecamatans = Unor::whereRaw('CHAR_LENGTH(kode_unor) = ?', [5])
            ->whereRaw('RIGHT(kode_unor, 2) BETWEEN ? AND ?', [32, 45])
            ->get(['kode_unor', 'nama_unor'])
            ->map(fn($i) => [
                'kode' => $i->kode_unor,
                'nama' => $i->nama_unor,
                'tipe' => 'kecamatan',
            ]);

        $turunansmini = Instansi::where('kode_instansi', 'like', 'obrik%')->get(['kode_instansi', 'nama_instansi'])
            ->map(fn($tm) => [
                'kode' => $tm->kode_instansi,
                'nama' => $tm->nama_instansi,
                'tipe' => 'turunansmini',
            ]);

        $obriks = Instansi::whereRaw('CHAR_LENGTH(kode_instansi) = 8')->get(['id_instansi', 'kode_instansi', 'nama_instansi'])
            ->map(fn($o) => [
                'id' => $o->id_instansi,
                'kode' => $o->kode_instansi,
                'kode_opd' => substr($o->kode_instansi, 0, 5),
                'nama' => $o->nama_instansi,
                'tipe' => 'obrik',
            ]);

        $levels = Level::select('id_level', 'nama_level')->where('id_app', 14)->orderBy('tingkatan_level', 'asc')->get();
        $tims = Tim::get();
        return view('admin', compact('instansis', 'kecamatans', 'turunansmini', 'levels', 'tims', 'obriks'));
    }

    public function ajaxDataAdmin(Request $request)
    {
        $data = User::with([
            'instansi:id_instansi,kode_instansi,nama_instansi'
        ])
            ->leftJoin('kis_levels', function ($join) {
                $join->on('kis_users.id_app', '=', 'kis_levels.id_app')
                    ->on('kis_users.tingkatan_level', '=', 'kis_levels.tingkatan_level');
            })
            ->select(
                'kis_users.nama_pegawai',
                'kis_users.id_pegawai',
                'kis_users.kode_unor',
                'kis_users.simak',
                'kis_users.tingkatan_level',
                'kis_users.dihapus_oleh',
                'kis_levels.nama_level'
            )
            ->where('kis_users.id_app', 14)
            ->orderBy('kis_users.id_user', 'desc');

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('id_pegawai', function ($value) {
                $status = is_null($value->dihapus_oleh)
                    ? '<span class="px-2 py-0.5 text-xs font-medium text-green-600 bg-green-50 rounded-md">Aktif</span>'
                    : '<span class="px-2 py-0.5 text-xs font-medium text-red-600 bg-red-50 rounded-md">Tidak Aktif</span>';
                return '<div class="flex items-center gap-2"><span class="font-medium">' . $value->id_pegawai . '</span>' . $status . '</div>';
            })
            ->editColumn('nama_pegawai', function ($value) {
                $simakIcon = '';
                if ($value->simak == 1) {
                    $simakIcon = '<img src="' . asset('images/icons/SIMAK72r.png') . '" class="h-4 w-auto opacity-80 hover:opacity-100" title="Terdaftar di SIMAK"/>';
                }
                return '<div class="flex items-center gap-2"><span>' . $value->nama_pegawai . '</span>' . $simakIcon . '</div>';
            })
            ->addColumn('nama_obrik', function ($value) {
                return $value->instansi?->nama_bersih ?? '-';
            })
            ->addColumn('level', function ($value) {
                return $value->nama_level ?? '-';
            })
            ->addColumn('action', function ($value) {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <button type="button" data-id="' . $value->id . '" id="btn-deleteAdmin" title="Hapus" class="text-gray-500 hover:text-red-500 transition duration-200">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""/>
                            </svg>
                        </button>

                        <button type="button" data-id="' . $value->id . '" id="btn-editAdmin" title="Edit" class="text-gray-500 hover:text-blue-600 transition duration-200">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z" fill=""/></svg>
                        </button>
                    </div>';
            })
            ->rawColumns(['id_pegawai', 'nama_pegawai', 'nama_obrik', 'level', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'opd'    => ['required'],
            'id_pegawai'   => ['required', 'unique:mysql_root.kis_users,id_pegawai', 'digits_between:16,18'],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'level'     => ['required'],
            'tim'       => ['required_if:level,22'],
            'obrikRadio'  => [
                Rule::requiredIf(function () use ($request) {
                    $allowedKodeUnor = [
                        '01.32',
                        '01.33',
                        '01.34',
                        '01.35',
                        '01.36',
                        '01.37',
                        '01.38',
                        '01.39',
                        '01.40',
                        '01.41',
                        '01.42',
                        '01.43',
                        '01.44',
                        '01.45',
                        '01.13'
                    ];

                    return $request->id_level == 23
                        && in_array($request->kode_unor, $allowedKodeUnor);
                })
            ],
            'nama_obrik' => ['required_if:obrikRadio,1'],
            'password'     => ['required', 'min:6'],
        ], [
            'opd.required' => 'OPD wajib diisi',
            'id_pegawai.required' => 'NIP/NIK wajib diisi',
            'id_pegawai.unique' => 'NIP/NIK sudah terdaftar',
            'id_pegawai.digits_between' => 'NIP/NIK tidak valid',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'level.required' => 'Level wajib dipilih',
            'tim.required_if' => 'Tim wajib dipilih',
            'nama_obrik.required_if' => 'Nama obrik wajib dipilih',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        $validated = $validator->validated();
        User::create([
            'kode_unor'         => $validated['opd'],
            'id_app'            => '14',
            'id_pegawai'        => $validated['id_pegawai'],
            'nama_pegawai'      => $validated['nama_lengkap'],
            'simak'             => 0,
            'tingkatan_level'   => $validated['level'],
            // 'id_tim'            => $validated['tim'] ?? null,
            // 'obrikSelect'       => $validated['obrikRadio'] ?? null,
            // 'kode_turunan'      => $validated['nama_obrik'] ?? null,
            'password'          => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Admin berhasil ditambahkan'
        ]);
    }
}
