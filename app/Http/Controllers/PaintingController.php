<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Barryvdh\DomPDF\Facade\Pdf;

class PaintingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Painting::query();
        
        // Handle search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('artist', 'like', "%{$searchTerm}%")
                  ->orWhere('year', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        $paintings = $query->latest()->get();
        return view('paintings.index', compact('paintings'));
    }

    public function create()
    {
        return view('paintings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
            'description' => 'nullable|string'
        ]);

        $data = $request->except('image');
        $data['user_id'] = Auth::id();
        
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Log file information
                Log::info('Image upload attempt', [
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'extension' => $image->getClientOriginalExtension()
                ]);
                
                // Generate unique filename
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $relativePath = 'paintings/' . $imageName;
                $fullPath = storage_path('app/public/' . $relativePath);
                
                // Ensure directory exists
                $directory = dirname($fullPath);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }
                
                // Store file using direct file operations
                File::put($fullPath, file_get_contents($image->getRealPath()));
                Log::info('Image saved to: ' . $fullPath);
                
                // Set image path in database
                $data['image'] = $relativePath;
                
                // Verify file exists
                if (File::exists($fullPath)) {
                    Log::info('File verified to exist at: ' . $fullPath);
                } else {
                    Log::error('File does not exist after upload: ' . $fullPath);
                }
            }
            
            // Create painting record
            $painting = Painting::create($data);
            Log::info('Painting created', ['id' => $painting->id, 'title' => $painting->title]);
            
            return redirect()->route('paintings.index')
                ->with('success', 'Lukisan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['image' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
        }
    }

    public function show(Painting $painting)
    {
        $comments = $painting->comments()->with('user')->latest()->get();
        return view('paintings.show', compact('painting', 'comments'));
    }

    public function edit(Painting $painting)
    {
        $this->authorize('update', $painting);
        return view('paintings.edit', compact('painting'));
    }

    public function update(Request $request, Painting $painting)
    {
        $this->authorize('update', $painting);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'description' => 'nullable|string'
        ]);

        $data = $request->except('image');
        
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Log file information
                Log::info('Image update attempt', [
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'extension' => $image->getClientOriginalExtension()
                ]);
                
                // Delete old image if exists
                if ($painting->image) {
                    $oldFullPath = storage_path('app/public/' . $painting->image);
                    if (File::exists($oldFullPath)) {
                        File::delete($oldFullPath);
                        Log::info('Deleted old image: ' . $oldFullPath);
                    }
                }
                
                // Generate unique filename
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $relativePath = 'paintings/' . $imageName;
                $fullPath = storage_path('app/public/' . $relativePath);
                
                // Ensure directory exists
                $directory = dirname($fullPath);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }
                
                // Store file using direct file operations
                File::put($fullPath, file_get_contents($image->getRealPath()));
                Log::info('Image updated to: ' . $fullPath);
                
                // Set image path in database
                $data['image'] = $relativePath;
                
                // Verify file exists
                if (File::exists($fullPath)) {
                    Log::info('File verified to exist at: ' . $fullPath);
                } else {
                    Log::error('File does not exist after upload: ' . $fullPath);
                }
            }
            
            // Update painting record
            $painting->update($data);
            Log::info('Painting updated', ['id' => $painting->id, 'title' => $painting->title]);
            
            return redirect()->route('paintings.index')
                ->with('success', 'Lukisan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating image: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['image' => 'Gagal memperbarui gambar: ' . $e->getMessage()]);
        }
    }

    public function destroy(Painting $painting)
    {
        $this->authorize('delete', $painting);
        
        try {
            // Hapus gambar jika ada
            if ($painting->image) {
                $fullPath = storage_path('app/public/' . $painting->image);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                    Log::info('Deleted image during painting removal: ' . $fullPath);
                }
            }
            
        $painting->delete();
            Log::info('Painting deleted', ['id' => $painting->id, 'title' => $painting->title]);
            
            return redirect()->route('paintings.index')
                ->with('success', 'Lukisan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting painting: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withErrors(['general' => 'Gagal menghapus lukisan: ' . $e->getMessage()]);
        }
    }

    /**
     * Export painting to PDF
     *
     * @param  \App\Models\Painting  $painting
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Painting $painting)
    {
        // Authorize view access
        $this->authorize('view', $painting);
        
        $pdf = PDF::loadView('paintings.pdf', compact('painting'));
        
        return $pdf->download($painting->title . '.pdf');
    }
}
