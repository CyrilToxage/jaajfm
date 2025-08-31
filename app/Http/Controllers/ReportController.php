<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        \App\Helpers\LogHelper::info('Signalement reçu', [
            'user' => auth()->user() ? auth()->user()->id : 'non connecté'
        ]);

        try {
            $request->validate([
                'reportable_type' => 'required|string|in:App\Models\Music,App\Models\User,App\Models\MusicComment,music,user,comment',
                'reportable_id' => 'required|integer|min:1',
                'reason' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000'
            ]);

            \App\Helpers\LogHelper::info('Validation réussie');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \App\Helpers\LogHelper::error('Erreur de validation', ['errors' => $e->errors()]);
            return response()->json(['error' => 'Données invalides', 'details' => $e->errors()], 422);
        }

        // Convertir les types courts en types complets
        $reportableType = $request->reportable_type;
        if ($reportableType === 'music') {
            $reportableType = 'App\Models\Music';
        } elseif ($reportableType === 'user') {
            $reportableType = 'App\Models\User';
        } elseif ($reportableType === 'comment') {
            $reportableType = 'App\Models\MusicComment';
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Vérifier si l'utilisateur a déjà signalé cet élément
        $existingReport = Report::where('reporter_id', $user->id)
            ->where('reportable_type', $reportableType)
            ->where('reportable_id', $request->reportable_id)
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return response()->json(['error' => 'Vous avez déjà signalé cet élément'], 400);
        }

        // Créer le signalement
        $report = Report::create([
            'reporter_id' => $user->id,
            'reportable_type' => $reportableType,
            'reportable_id' => $request->reportable_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Signalement envoyé avec succès',
            'report' => $report
        ]);
    }

    public function index()
    {
        $reports = Report::with(['reporter', 'reportable', 'resolvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'reports' => $reports
        ]);
    }

    public function resolve(Request $request, Report $report)
    {
        $user = Auth::user();
        if (!$user || !$user->is_admin) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $request->validate([
            'action' => 'required|string|in:resolve,dismiss'
        ]);

        $report->update([
            'status' => $request->action === 'resolve' ? 'resolved' : 'dismissed',
            'resolved_by' => $user->id,
            'resolved_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Signalement ' . ($request->action === 'resolve' ? 'résolu' : 'rejeté') . ' avec succès'
        ]);
    }


}
