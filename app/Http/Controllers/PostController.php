// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Exception;

class PostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;

        $this->middleware('auth:sanctum');
        $this->middleware('admin')->only('destroy');
    }

    // =============================
    // 1. TAMPILKAN DATA
    // =============================
    public function index(): JsonResponse
    {
        $posts = $this->service->getAll();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    // =============================
    // 2. TAMBAH DATA
    // =============================
    public function store(Request $request): JsonResponse
    {
        // VALIDASI (WAJIB)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        try {
            $post = $this->service->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $post
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =============================
    // 3. UPDATE DATA
    // =============================
    public function update(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string'
        ]);

        try {
            $updated = $this->service->update($post, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $updated
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =============================
    // 4. HAPUS DATA
    // =============================
    public function destroy(Post $post): JsonResponse
    {
        try {
            $this->service->delete($post);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal hapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}