<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AudioController extends Controller
{
    public function serve(Request $request, $filename)
    {
        // Vérifier que le fichier existe
        $path = 'uploads/music/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        // Récupérer le fichier
        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        // Retourner le fichier avec les bons headers
        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Length' => Storage::disk('public')->size($path),
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
