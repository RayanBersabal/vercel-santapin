<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutPageSetting::firstOrCreate();
        return view('admin.about', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required',
            'hero_subtitle' => 'required',
            'hero_image_url' => 'required|url',
            'about_paragraph' => 'required',
            'about_image_url' => 'required|url',
            'visi' => 'required',
            'misi' => 'required',
            'gallery_url.*' => 'required|url',
            'gallery_title.*' => 'required',
        ]);

        $about = AboutPageSetting::firstOrCreate();

        // Prepare gallery data as a JSON array
        $gallery = [];
        foreach ($request->input('gallery_url') as $index => $url) {
            $gallery[] = [
                'url' => $url,
                'title' => $request->input('gallery_title')[$index],
            ];
        }

        $about->update([
            'hero_title' => $request->input('hero_title'),
            'hero_subtitle' => $request->input('hero_subtitle'),
            'hero_image_url' => $request->input('hero_image_url'),
            'about_paragraph' => $request->input('about_paragraph'),
            'about_image_url' => $request->input('about_image_url'),
            'visi' => $request->input('visi'),
            'misi' => $request->input('misi'),
            'gallery' => $gallery,
        ]);

        return redirect()->route('admin.about.index')->with('success', 'Pengaturan halaman About Us berhasil diperbarui.');
    }
}
