<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Level;
use App\Models\PegawaiSimak;
use App\Models\Tim;
use App\Models\TimAnggota;
use App\Models\Unor;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // Kode OPD yang termasuk wilayah obrik
    private const OBRIK_KODE_UNOR = [
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
        '01.13',
    ];

    private const SVG_DELETE = '<svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""/></svg>';
    private const SVG_EDIT = '<svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z" fill=""/></svg>';

    public function index(): View
    {
        $instansis = Unor::whereRaw('CHAR_LENGTH(kode_unor) <= 5')
            ->whereRaw('RIGHT(kode_unor, 2) < 32')
            ->get(['kode_unor', 'nama_unor'])
            ->map(fn($i) => ['kode' => $i->kode_unor, 'nama' => $i->nama_unor]);

        $kecamatans = Unor::whereRaw('CHAR_LENGTH(kode_unor) = ?', [5])
            ->whereRaw('RIGHT(kode_unor, 2) BETWEEN ? AND ?', [32, 45])
            ->get(['kode_unor', 'nama_unor'])
            ->map(fn($i) => ['kode' => $i->kode_unor, 'nama' => $i->nama_unor]);

        $turunansmini = Instansi::where('kode_instansi', 'like', 'obrik%')
            ->get(['kode_instansi', 'nama_instansi'])
            ->map(fn($tm) => ['kode' => $tm->kode_instansi, 'nama' => $tm->nama_instansi]);

        $obriks = Instansi::whereRaw('CHAR_LENGTH(kode_instansi) = 8')
            ->get(['id_instansi', 'kode_instansi', 'nama_instansi'])
            ->map(fn($o) => [
                'id'       => $o->id_instansi,
                'kode'     => $o->kode_instansi,
                'kode_opd' => substr($o->kode_instansi, 0, 5),
                'nama'     => $o->nama_instansi,
            ]);

        $levels = Level::select('tingkatan_level', 'nama_level')
            ->where('id_app', 14)
            ->orderBy('tingkatan_level')
            ->get();
        $tims = Tim::with('ketua')->get();

        return view('admin', compact(
            'instansis',
            'kecamatans',
            'turunansmini',
            'levels',
            'tims',
            'obriks',
        ));
    }

    public function ajaxDataAdmin(Request $request): JsonResponse
    {
        $query = $this->baseUserQuery();

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('id_pegawai', function (User $user) {
                $badge = is_null($user->dihapus_oleh)
                    ? '<span class="px-2 py-0.5 text-xs font-medium text-green-600 bg-green-50 rounded-md">Aktif</span>'
                    : '<span class="px-2 py-0.5 text-xs font-medium text-red-600 bg-red-50 rounded-md">Tidak Aktif</span>';

                return '<div class="flex items-center gap-2"><span class="font-medium">'
                    . e($user->id_pegawai) . '</span>' . $badge . '</div>';
            })
            ->editColumn('nama_pegawai', function (User $user) {
                $simakIcon = $user->simak
                    ? '<img src="' . asset('images/icons/SIMAK72r.png') . '" class="h-4 w-auto opacity-80 hover:opacity-100" title="Terdaftar di SIMAK"/>'
                    : '';
                $parts = explode(',', $user->nama_pegawai);
                $nama_pegawai = ucwords(strtolower(trim($parts[0])));
                if (count($parts) > 1) {
                    $gelar = implode(',', array_slice($parts, 1));
                    return e($nama_pegawai . ',' . $gelar);
                }
                return '<div class="flex items-center gap-2"><span>'
                    . e($nama_pegawai) . '</span>' . $simakIcon . '</div>';
            })
            ->addColumn('nama_obrik', fn(User $user) => e($user->instansi?->nama_instansi ? ucwords(strtolower($user->instansi->nama_instansi)) : '-'))

            ->addColumn('level', fn(User $user) => e($user->nama_level ?? '-'))
            ->addColumn('action', function (User $user) {
                $timId   = TimAnggota::where('id_user', $user->id_user)->value('id_tim') ?? '';
                $isObrik = strlen((string) $user->kode_unor) === 8;

                return $this->renderActionButtons($user, $timId, $isObrik);
            })
            ->rawColumns(['id_pegawai', 'nama_pegawai', 'action'])
            ->make(true);
    }

    private function formatNama(PegawaiSimak $pegawai): string
    {
        $nama = $pegawai->nama_pegawai ?? '';

        // Tambahkan gelar non-akademis di depan jika ada
        if (!empty($pegawai->gelar_nonakademis) && $pegawai->gelar_nonakademis !== '-') {
            $nama = $pegawai->gelar_nonakademis . $nama;
        }

        // Format: "Gelar Depan Nama, Gelar Belakang"
        $gelarDepan    = trim((string) $pegawai->gelar_depan);
        $gelarBelakang = trim((string) $pegawai->gelar_belakang);

        if ($gelarDepan) {
            $nama = $gelarDepan . ' ' . $nama;
        }
        if ($gelarBelakang) {
            $nama = $nama . ', ' . $gelarBelakang;
        }

        return trim($nama);
    }

    public function ajaxDataSimak(Request $request): JsonResponse
    {
        $opd = $request->string('opd')->toString();
        $query = PegawaiSimak::from('r_pegawai_aktual as a')
            ->leftJoin('r_peg_alamat as b', 'a.id_pegawai', '=', 'b.id_pegawai')
            ->selectRaw("
            a.nip_baru,
            MAX(a.kode_unor)           AS kode_unor,
            MAX(a.nama_pegawai)        AS nama_pegawai,
            MAX(a.gelar_nonakademis)   AS gelar_nonakademis,
            MAX(a.gelar_depan)         AS gelar_depan,
            MAX(a.gelar_belakang)      AS gelar_belakang,
            MAX(a.nomenklatur_pada)    AS nomenklatur_pada,
            MAX(a.nomenklatur_jabatan) AS nomenklatur_jabatan,
            MAX(a.nama_pangkat)        AS nama_pangkat,
            MAX(a.nama_golongan)       AS nama_golongan,
            MAX(b.ktp_nomor)           AS ktp_nomor
        ")
            ->when(
                $opd,
                fn(Builder $q) =>
                $q->whereRaw('LEFT(a.kode_unor, 5) = ?', [$opd])
            )
            ->groupBy('a.nip_baru');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('nama_pegawai', function (PegawaiSimak $pegawai) {
                $nama = $this->formatNama($pegawai);
                return '<div>'
                    . '<span class="font-medium">' . e($nama) . '</span>'
                    . '<br><code class="text-xs text-gray-500">' . e($pegawai->nip_baru) . '</code>'
                    . '</div>';
            })
            ->addColumn(
                'jabatan',
                fn(PegawaiSimak $pegawai) =>
                e($pegawai->nomenklatur_jabatan)
                    . '<br>'
                    . e($pegawai->nama_pangkat)
                    . ' (' . e($pegawai->nama_golongan) . ')'
            )
            ->addColumn('action', function (PegawaiSimak $pegawai) {
                $nama      = $this->formatNama($pegawai);
                return '
                <div class="flex items-center justify-center gap-2 px-4 py-2">
                    <button type="button"
                        data-nip="' . e($pegawai->nip_baru) . '"
                        data-nama="' . e($nama) . '"
                        data-nama_opd="' . e($pegawai->nomenklatur_pada) . '"
                        data-kode_unor="' . e($pegawai->kode_unor) . '"
                        class="btn-pickSimak px-3 py-1.5 text-xs font-medium text-white bg-brand-500 hover:bg-brand-600 rounded-lg">
                        Pilih
                    </button>
                </div>';
            })
            ->filterColumn('nama_pegawai', function (Builder $query, string $keyword) {
                $query->where(function (Builder $q) use ($keyword) {
                    foreach (PegawaiSimak::SEARCHABLE_COLUMNS as $i => $column) {
                        $method = $i === 0 ? 'where' : 'orWhere';
                        $q->{$method}($column, 'LIKE', "%{$keyword}%");
                    }
                });
            })
            ->rawColumns(['nama_pegawai', 'jabatan', 'action'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $isUpdate = (bool) $request->id;
        $isSimak  = $request->boolean('simak');
        $validator = Validator::make($request->all(), [
            'opd'          => ['required'],
            'id_pegawai'   => [
                'required',
                'digits_between:16,18',
                Rule::unique('mysql_root.kis_users', 'id_pegawai')
                    ->where('id_app', 14)
                    ->ignore($request->id, 'id_user'),
            ],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'level'        => ['required'],
            'tim'          => ['required_if:level,2'],
            'obrikRadio'   => [Rule::requiredIf(fn() => $this->isObrikRequired($request))],
            'nama_obrik'   => ['required_if:obrikRadio,1'],
            'password'     => [($isUpdate || $isSimak) ? 'nullable' : 'required', 'min:6'],
        ], [
            'opd.required'              => 'OPD wajib diisi',
            'id_pegawai.required'       => 'NIP/NIK wajib diisi',
            'id_pegawai.unique'         => 'NIP/NIK sudah terdaftar',
            'id_pegawai.digits_between' => 'NIP/NIK tidak valid',
            'nama_lengkap.required'     => 'Nama lengkap wajib diisi',
            'level.required'            => 'Level wajib dipilih',
            'tim.required_if'           => 'Tim wajib dipilih',
            'nama_obrik.required_if'    => 'Nama obrik wajib dipilih',
            'password.required'         => 'Password wajib diisi',
            'password.min'              => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(), // Fix: 'error' → 'errors'
            ], 422); // Fix: 200 → 422
        }

        $validated = $validator->validated();

        // Tentukan kode_unor: obrik gunakan nama_obrik, selain itu gunakan opd
        $kodeUnor = ($request->obrikRadio == 1) ? $request->nama_obrik : $request->opd;

        $payload = [
            'kode_unor'       => $kodeUnor,
            'id_app'          => 14,
            'id_pegawai'      => $validated['id_pegawai'],
            'nama_pegawai'    => $validated['nama_lengkap'],
            'simak'           => $request->boolean('simak'), // ← tambahkan ini
            'tingkatan_level' => $validated['level'],
        ];

        if (!empty($validated['password'] ?? null)) {
            $payload['password'] = Hash::make($validated['password']);
        }

        if ($isUpdate) {
            $user = User::findOrFail($request->id); // Fix: find() → findOrFail()
            $user->update(array_merge($payload, [
                'diedit_oleh'  => Auth::id(),
                'diedit_waktu' => now(),
            ]));
            $message = 'User berhasil diperbarui'; // Fix: pesan berbeda untuk update
        } else {
            $user = User::create(array_merge($payload, [
                'diinput_oleh'  => Auth::id(),
                'diinput_waktu' => now(),
            ]));
            $message = 'User berhasil ditambahkan';
        }

        // Sync tim anggota berdasarkan level
        if ((int) $validated['level'] === 2 && !empty($request->tim)) {
            TimAnggota::updateOrCreate(
                ['id_user' => $user->id_user],
                ['id_tim'  => $request->tim],
            );
        } else {
            TimAnggota::where('id_user', $user->id_user)->delete();
        }

        return response()->json([
            'status'  => true,
            'message' => $message,
        ]);
    }

    public function destroy(User $admin): JsonResponse
    {
        TimAnggota::where('id_user', $admin->id_user)->delete();
        $admin->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }

    private function baseUserQuery(?string $opd = null): Builder
    {
        return User::with(['instansi:id_instansi,kode_instansi,nama_instansi'])
            ->leftJoin('kis_levels', function ($join) {
                $join->on('kis_users.id_app', '=', 'kis_levels.id_app')
                    ->on('kis_users.tingkatan_level', '=', 'kis_levels.tingkatan_level');
            })
            ->select(
                'kis_users.id_user',
                'kis_users.nama_pegawai',
                'kis_users.id_pegawai',
                'kis_users.kode_unor',
                'kis_users.simak',
                'kis_users.tingkatan_level',
                'kis_users.dihapus_oleh',
                'kis_levels.nama_level',
            )
            ->where('kis_users.id_app', 14)
            ->when($opd, fn(Builder $q) => $q->whereRaw('LEFT(kis_users.kode_unor, 5) = ?', [$opd]))
            ->orderBy('kis_users.id_user', 'desc');
    }

    private function isObrikRequired(Request $request): bool
    {
        return (int) $request->level === 3
            && in_array($request->opd, self::OBRIK_KODE_UNOR, strict: true);
    }

    private function renderActionButtons(User $user, mixed $timId, bool $isObrik): string
    {
        return '
            <div class="flex items-center justify-center gap-3 px-4 py-2">
                <a href="javascript:void(0)"
                    data-id="' . $user->id_user . '"
                    title="Hapus"
                    class="btn-deleteAdmin text-gray-500 hover:text-red-500 transition duration-200">
                    ' . self::SVG_DELETE . '
                </a>
                <a href="javascript:void(0)"
                    data-id="' . $user->id_user . '"
                    data-opd="' . e($user->kode_unor) . '"
                    data-id_pegawai="' . e($user->id_pegawai) . '"
                    data-nama="' . e($user->nama_pegawai) . '"
                    data-level="' . $user->tingkatan_level . '"
                    data-obrik="' . ($isObrik ? '1' : '0') . '"
                    data-nama_obrik="' . e((string) ($user->instansi?->id_instansi ?? '')) . '"
                    data-tim="' . e((string) $timId) . '"
                    title="Edit"
                    class="btn-editAdmin text-gray-500 hover:text-blue-600 transition duration-200">
                    ' . self::SVG_EDIT . '
                </a>
            </div>';
    }
}
