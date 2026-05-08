<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function store(Request $request) {
        $request->validate(['documento' => 'required|file|mimes:pdf|max:10240']);

        $file = $request->file('documento');
        $path = $file->store('documents', 'public');

        $doc = \App\Models\Document::create([
            'original_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'size_readable' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
            'mime_type' => $file->getMimeType(),
            'status' => 'pending_processing'
        ]);

        try {
            $response = Http::timeout(30)->post('http://python_service:5000/process', [
                'document_id' => $doc->id,
                'file_path' => $path
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $doc->update([
                    'status' => 'processed',
                    'metadata' => $data['metadata']
                ]);
            } else {
                $doc->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            $doc->update(['status' => 'failed']);
        }

        return response()->json(['success' => true, 'data' => $doc->fresh()], 201);
    }
}
