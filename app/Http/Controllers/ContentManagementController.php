<?php

namespace App\Http\Controllers;

use App\Models\AboutModel;
use App\Models\BlogModel;
use App\Models\HomeModel;
use App\Models\PortofolioModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ContentManagementController extends Controller
{
    public function index()
    {
        return view('manage', [
            'header' => 'Kelola Konten',
            'homeItems' => HomeModel::all(),
            'aboutItems' => AboutModel::all(),
            'portfolioItems' => PortofolioModel::all(),
            'blogItems' => BlogModel::all(),
        ]);
    }

    public function storeHome(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $data['foto'] = $this->storeImage($request->file('foto'), 'home');

        HomeModel::create($data);

        return $this->backWithStatus('Konten Home berhasil ditambahkan.');
    }

    public function updateHome(Request $request, HomeModel $home): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $oldImage = $home->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->storeImage($request->file('foto'), 'home');
        } else {
            unset($data['foto']);
        }

        $home->update($data);

        if (isset($data['foto'])) {
            $this->deleteImage($oldImage, 'home');
        }

        return $this->backWithStatus('Konten Home berhasil diperbarui.');
    }

    public function destroyHome(HomeModel $home): RedirectResponse
    {
        $image = $home->foto;
        $home->delete();
        $this->deleteImage($image, 'home');

        return $this->backWithStatus('Konten Home berhasil dihapus.');
    }

    public function storeAbout(Request $request): RedirectResponse
    {
        AboutModel::create($request->validate([
            'aboutme' => ['required', 'string'],
            'study' => ['required', 'string'],
            'skill' => ['required', 'string', 'max:250'],
        ]));

        return $this->backWithStatus('Konten About berhasil ditambahkan.');
    }

    public function updateAbout(Request $request, AboutModel $about): RedirectResponse
    {
        $about->update($request->validate([
            'aboutme' => ['required', 'string'],
            'study' => ['required', 'string'],
            'skill' => ['required', 'string', 'max:250'],
        ]));

        return $this->backWithStatus('Konten About berhasil diperbarui.');
    }

    public function destroyAbout(AboutModel $about): RedirectResponse
    {
        $about->delete();

        return $this->backWithStatus('Konten About berhasil dihapus.');
    }

    public function storePortfolio(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'link' => ['required', 'url:http,https', 'max:2048'],
        ]);
        $data['foto'] = $this->storeImage($request->file('foto'), 'portfolio');

        PortofolioModel::create($data);

        return $this->backWithStatus('Portofolio berhasil ditambahkan.');
    }

    public function updatePortfolio(Request $request, PortofolioModel $portfolio): RedirectResponse
    {
        $data = $request->validate([
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'link' => ['required', 'url:http,https', 'max:2048'],
        ]);
        $oldImage = $portfolio->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->storeImage($request->file('foto'), 'portfolio');
        } else {
            unset($data['foto']);
        }

        $portfolio->update($data);

        if (isset($data['foto'])) {
            $this->deleteImage($oldImage, 'portfolio');
        }

        return $this->backWithStatus('Portofolio berhasil diperbarui.');
    }

    public function destroyPortfolio(PortofolioModel $portfolio): RedirectResponse
    {
        $image = $portfolio->foto;
        $portfolio->delete();
        $this->deleteImage($image, 'portfolio');

        return $this->backWithStatus('Portofolio berhasil dihapus.');
    }

    public function storeBlog(Request $request): RedirectResponse
    {
        BlogModel::create($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]));

        return $this->backWithStatus('Artikel Blog berhasil ditambahkan.');
    }

    public function updateBlog(Request $request, BlogModel $blog): RedirectResponse
    {
        $blog->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]));

        return $this->backWithStatus('Artikel Blog berhasil diperbarui.');
    }

    public function destroyBlog(BlogModel $blog): RedirectResponse
    {
        $blog->delete();

        return $this->backWithStatus('Artikel Blog berhasil dihapus.');
    }

    private function storeImage(UploadedFile $image, string $directory): string
    {
        $path = $image->store($directory, 'public');

        if ($path === false) {
            throw new RuntimeException('Foto gagal disimpan ke penyimpanan publik.');
        }

        return '/storage/'.$path;
    }

    private function deleteImage(?string $image, string $directory): void
    {
        $path = parse_url($image ?? '', PHP_URL_PATH);
        $prefix = '/storage/'.$directory.'/';

        if (is_string($path) && str_starts_with($path, $prefix)) {
            Storage::disk('public')->delete(substr($path, strlen('/storage/')));
        }
    }

    private function backWithStatus(string $message): RedirectResponse
    {
        return redirect()->route('manage')->with('status', $message);
    }
}
