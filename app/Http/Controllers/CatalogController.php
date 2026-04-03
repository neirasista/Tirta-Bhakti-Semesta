<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Grade;

class CatalogController extends Controller
{
    // ========================
    // PUBLIC API (USER)
    // ========================
    public function index()
    {
        return Catalog::with(['grade', 'category'])->get();
    }

    public function show($id)
    {
        return Catalog::with(['grade', 'category'])->findOrFail($id);
    }

    // ========================
    // ADMIN — VIEW PAGE
    // ========================
    public function adminView()
    {
        $catalogs   = Catalog::with(['grade', 'category'])->get();
        $grades     = Grade::all();
        $categories = Category::all();

        return view('admin.catalogue', compact('catalogs', 'grades', 'categories'));
    }

   // ========================
// ADMIN — JSON LIST (support search + filter)
// Route: GET /admin/catalogue/list?q=&category_id=&grade=
// ========================
public function adminList(Request $request)
{
    $q          = $request->query('q');
    $categoryId = $request->query('category_id');
    $gradeKey   = $request->query('grade');

    // mapping key dropdown FE lama -> gradeName DB
    $map = [
        'gradeA' => 'Grade A',
        'gradeB' => 'Grade B',
        'gradeC' => 'Grade C',
    ];

    $catalogs = Catalog::with(['grade', 'category'])
        // SEARCH
        ->when($q, function ($query) use ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        })

        // FILTER CATEGORY (langsung ke FK)
        ->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })

        // FILTER GRADE (fleksibel)
        ->when($gradeKey, function ($query) use ($gradeKey, $map) {

            // 1) kalau numeric => pakai grade_id langsung
            if (is_numeric($gradeKey)) {
                $query->where('grade_id', $gradeKey);
                return;
            }

            // normalize string
            $normalized = strtolower(trim($gradeKey));

            // 2) kalau key gradeA/B/C => map ke gradeName DB
            if (isset($map[$gradeKey])) {
                $query->whereHas('grade', function ($q2) use ($map, $gradeKey) {
                    $q2->where('gradeName', $map[$gradeKey]);
                });
                return;
            }

            // 3) fallback => match gradeName lowercase
            $query->whereHas('grade', function ($q2) use ($normalized) {
                $q2->whereRaw('LOWER(gradeName) = ?', [$normalized]);
            });
        })

        ->get();

    return response()->json($catalogs);
}
    // ========================
    // ADMIN — GET 1 ITEM (EDIT)
    // Route: GET /admin/catalogue/{id}/edit
    // ========================
    public function edit($id)
    {
        return Catalog::findOrFail($id);
    }

    // ========================
    // ADMIN — STORE
    // Route: POST /admin/catalogue
    // ========================
    public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'grade_id'    => 'required|exists:grades,id',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric',
        'images'      => 'nullable',
        'images.*'    => 'nullable|image|max:2048',
    ]);

    $imagePaths = [];

    // ✅ lebih aman: cek images.0
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $imagePaths[] = $img->store('catalogs', 'public');
        }
    }

    $catalog = Catalog::create([
        'name'        => $request->name,
        'description' => $request->description,
        'grade_id'    => $request->grade_id,
        'category_id' => $request->category_id,
        'price'       => $request->price,

        // ✅ simpan array asli, jangan json_encode lagi
        'images'      => $imagePaths,
    ]);

    return response()->json(['success' => true, 'data' => $catalog]);
}


    // ========================
    // ADMIN — UPDATE (pola portofolio)
    // Route: POST /admin/catalogue/{id} + _method=PUT
    // ========================
    public function update(Request $request, $id)
{
    $catalog = Catalog::findOrFail($id);

    $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'grade_id'    => 'required|exists:grades,id',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric',
        'images'      => 'nullable',
        'images.*'    => 'nullable|image|max:2048',
    ]);

    // ✅ karena di Model sudah casts array
    $imgPaths = $catalog->images ?? [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $imgPaths[] = $img->store('catalogs', 'public');
        }
    }

    $catalog->update([
        'name'        => $request->name,
        'description' => $request->description,
        'grade_id'    => $request->grade_id,
        'category_id' => $request->category_id,
        'price'       => $request->price,
        'images'      => $imgPaths, // ✅ array
    ]);

    return response()->json(['success' => true]);
}


    // ========================
    // ADMIN — DELETE
    // Route: DELETE /admin/catalogue/{id}
    // ========================
    public function destroy($id)
    {
        Catalog::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // ========================
// USER — VIEW PAGE
// ========================
public function publicView()
{
    $categories = Category::all(); 
    $grades     = Grade::all();
    return view('katalog', compact('categories', 'grades'));
}

// ========================
// USER — SEARCH JSON
// route: /katalog/search?q=&category_id=&grade=
// ========================
public function search(Request $request)
{
    $q          = $request->query('q');
    $categoryId = $request->query('category_id');
    $gradeKey   = $request->query('grade'); // di user kita kirim gradeName lowercase

    $catalogs = Catalog::with(['grade','category'])
        ->when($q, function ($query) use ($q) {
            $query->where(function($qq) use ($q){
                $qq->where('name','like',"%$q%")
                   ->orWhere('description','like',"%$q%");
            });
        })
        ->when($categoryId, fn($query) =>
            $query->where('category_id', $categoryId)
        )
        ->when($gradeKey, function($query) use ($gradeKey){
            $query->whereHas('grade', fn($q2)=>
                $q2->whereRaw('LOWER(gradeName) = ?', [$gradeKey])
            );
        })
        ->get();

    return response()->json($catalogs);
}

}
