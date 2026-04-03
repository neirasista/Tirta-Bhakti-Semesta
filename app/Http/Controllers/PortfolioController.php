<?php

namespace App\Http\Controllers;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(){ return Portfolio::orderBy('created_at','desc')->get(); }

   public function adminIndex()
{
    $portfolios = Portfolio::latest()->get();
    return view('admin.portofolio', compact('portfolios'));
}

    public function adminUpdate(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images.*' => 'image|max:5120'
        ]);

        // update title & desc
        $portfolio->title = $request->title;
        $portfolio->description = $request->description;

        $images = $portfolio->images ?? [];

        // handle upload gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('portfolios', 'public');
                $images[] = $path;
            }
        }

        $portfolio->images = $images;
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio updated!');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'description'=>'nullable|string',
            'images.*'=>'image|max:5120' // each image max 5MB
        ]);
        $imagePaths = [];
        if($request->hasFile('images')){
            foreach($request->file('images') as $file){
                $path = $file->store('portfolios','public');
                $imagePaths[] = $path;
            }
        }
        $p = Portfolio::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'images'=>$imagePaths
        ]);
        return redirect()
    ->route('admin.portofolio')
    ->with('success', 'Portfolio berhasil ditambahkan!');

    }

    public function show(Portfolio $portfolio){ return $portfolio; }

    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title'=>'sometimes|string',
            'description'=>'nullable|string',
            'images.*'=>'image|max:5120'
        ]);
        $images = $portfolio->images ?? [];
        if($request->hasFile('images')){
            // append new images
            foreach($request->file('images') as $file){
                $path = $file->store('portfolios','public');
                $images[] = $path;
            }
        }
        $portfolio->update([
            'title'=>$request->title ?? $portfolio->title,
            'description'=>$request->description ?? $portfolio->description,
            'images'=>$images
        ]);
        return redirect()
    ->route('admin.portofolio')
    ->with('success', 'Portfolio berhasil diperbarui!');

    }

    public function destroy($id)
{
    $portfolio = Portfolio::findOrFail($id);

    // hapus file gambar
    foreach ($portfolio->images ?? [] as $img) {
        if (Storage::disk('public')->exists($img)) {
            Storage::disk('public')->delete($img);
        }
    }

    $portfolio->delete();

    return redirect()
        ->route('admin.portofolio')
        ->with('success', 'Portfolio berhasil dihapus!');
}


    public function showPublic()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')->get();

        return view('portofolio', compact('portfolios'));
    }

    public function adminShow($id)
{
    $item = Portfolio::findOrFail($id);
    return view('admin.portofolio_show', compact('item'));
}


}
