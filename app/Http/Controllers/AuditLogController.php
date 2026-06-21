<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $auditLogs = $query->paginate(20);
        $users = \App\Models\User::all();

        return view('audit_logs.index', compact('auditLogs', 'users', 'request'));
    }

    public function exportPdf(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $filename = 'audit-log-' . $request->start_date . '-to-' . $request->end_date . '.pdf';
        } else {
            $filename = 'audit-log-' . now()->format('Y-m-d') . '.pdf';
        }

        $auditLogs = $query->get();
        $totalLogs = $auditLogs->count();

        $pdf = Pdf::loadView('audit_logs.pdf', compact('auditLogs', 'totalLogs', 'request'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}