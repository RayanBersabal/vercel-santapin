@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Pengaturan Halaman About Us</h1>

    <form action="{{ route('admin.about.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <div>
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-4">Bagian Hero</h2>
                <div class="space-y-4">
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Hero</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $about->hero_title) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subjudul Hero</label>
                        <input type="text" name="hero_subtitle" id="hero_subtitle" value="{{ old('hero_subtitle', $about->hero_subtitle) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                    <div>
                        <label for="hero_image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Gambar Latar Hero</label>
                        <input type="url" name="hero_image_url" id="hero_image_url" value="{{ old('hero_image_url', $about->hero_image_url) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <div>
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-4">Bagian Tentang Kami</h2>
                <div class="space-y-4">
                    <div>
                        <label for="about_paragraph" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paragraf Tentang Kami (pisahkan dengan baris kosong)</label>
                        <textarea name="about_paragraph" id="about_paragraph" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">{{ old('about_paragraph', $about->about_paragraph) }}</textarea>
                    </div>
                    <div>
                        <label for="about_image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Gambar Tentang Kami</label>
                        <input type="url" name="about_image_url" id="about_image_url" value="{{ old('about_image_url', $about->about_image_url) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <div>
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-4">Bagian Visi & Misi</h2>
                <div class="space-y-4">
                    <div>
                        <label for="visi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visi</label>
                        <textarea name="visi" id="visi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">{{ old('visi', $about->visi) }}</textarea>
                    </div>
                    <div>
                        <label for="misi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Misi (satu poin per baris)</label>
                        <textarea name="misi" id="misi" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">{{ old('misi', $about->misi) }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <div>
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-4">Bagian Galeri</h2>
                <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">Isi URL gambar dan judulnya untuk ditampilkan di slider galeri.</p>
                @for ($i = 0; $i < 4; $i++)
                    @php
                        $gallery = $about->gallery[$i] ?? ['url' => '', 'title' => ''];
                    @endphp
                    <div class="space-y-2 border-l-4 border-indigo-500 pl-4 py-2 my-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Gambar {{ $i + 1 }}</h3>
                        <div>
                            <label for="gallery_url_{{ $i }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL Gambar</label>
                            <input type="url" name="gallery_url[]" id="gallery_url_{{ $i }}" value="{{ old("gallery_url.$i", $gallery['url']) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                        <div>
                            <label for="gallery_title_{{ $i }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul / Keterangan Gambar</label>
                            <input type="text" name="gallery_title[]" id="gallery_title_{{ $i }}" value="{{ old("gallery_title.$i", $gallery['title']) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                        </div>
                    </div>
                @endfor
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
            </div>
        </div>
    </form>
@endsection
