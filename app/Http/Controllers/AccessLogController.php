<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccessLogController extends Controller
{
    /**
     * Halaman riwayat login.
     */
    public function index()
    {
        return view('access-log');
    }

    /**
     * DataTable server-side.
     */
    public function ajax(Request $request)
    {
        $query = AccessLog::query()->with(['pegawai', 'unor', 'level_user'])->select(['id_session', 'id_pegawai', 'kode_unor', 'level', 'login_at', 'valid_thru', 'logout_at', 'browser', 'platform']);
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)
                ->startOfDay();
            $query->where('login_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)
                ->endOfDay();
            $query->where('login_at', '<=', $endDate);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('nama_pegawai', function ($row) {
                return ucwords(strtolower($row->pegawai->nama_pegawai)) ?? '-';
            })
            ->editColumn('kode_unor', function ($row) {
                return ucwords(strtolower($row->unor->nama_unor)) ?? '-';
            })
            ->editColumn('level', function ($row) {
                return $row->level_user->nama_level ?? '-';
            })
            ->editColumn('login_at', function ($row) {
                if (!$row->login_at) {
                    return '-';
                }
                $date = Carbon::parse($row->login_at);
                return $date->translatedFormat('d F Y')
                    . '<br>'
                    . $date->format('H:i:s');
            })
            ->editColumn('logout_at', function ($row) {
                if (!$row->logout_at) {
                    return '-';
                }
                $date = Carbon::parse($row->logout_at);
                return $date->translatedFormat('d F Y')
                    . '<br>'
                    . $date->format('H:i:s');
            })
            ->editColumn('browser', function ($row) {
                return $row->browser ?: '-';
            })
            ->editColumn('platform', function ($row) {
                return $row->platform ?: '-';
            })
            ->addColumn('status', function ($row) {
                /*
                 * logout_at terisi
                 * ATAU
                 * valid_thru sudah lewat
                 *
                 * = SESSION EXPIRED
                 */

                if (!empty($row->logout_at) || (!empty($row->valid_thru) && Carbon::parse($row->valid_thru)->isPast())) {
                    return '<span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                SESSION EXPIRED
                            </span>';
                }

                return '<span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-600 dark:bg-green-500/10 dark:text-green-400">
                            ONLINE
                        </span>';
            })
            ->rawColumns(['status', 'login_at', 'logout_at'])
            ->make(true);
    }
}
