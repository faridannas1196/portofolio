<x-layout>
  <x-slot:header>{{ $header }}</x-slot:header>

  <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-xl bg-blue-50 p-5 text-blue-950">
    <div>
      <p class="font-semibold">Kelola konten portofolio</p>
      <p class="mt-1 text-sm text-blue-900">Pilih entitas untuk melihat data, lalu edit atau tambahkan record.</p>
    </div>
    <nav class="flex flex-wrap gap-2 text-sm font-medium">
      <a href="#home" class="rounded-lg bg-white px-3 py-2 text-blue-900 shadow-sm hover:bg-blue-100">Home</a>
      <a href="#about" class="rounded-lg bg-white px-3 py-2 text-blue-900 shadow-sm hover:bg-blue-100">About</a>
      <a href="#portfolio" class="rounded-lg bg-white px-3 py-2 text-blue-900 shadow-sm hover:bg-blue-100">Portfolio</a>
      <a href="#blog" class="rounded-lg bg-white px-3 py-2 text-blue-900 shadow-sm hover:bg-blue-100">Blog</a>
    </nav>
  </div>

  @if (session('status'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">
      {{ session('status') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800" role="alert">
      <p class="font-semibold">Periksa kembali isian berikut:</p>
      <ul class="mt-2 list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <section id="home" x-data="{ adding: false }" class="mb-10 scroll-mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
      <div>
        <h2 class="text-xl font-bold text-blue-900">Home</h2>
        <p class="mt-1 text-sm text-gray-600">Teks sambutan dan foto profil.</p>
      </div>
      <button type="button" @click="adding = !adding" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800" x-text="adding ? 'Tutup form' : '+ Tambah Home'"></button>
    </div>

    <div>
      <form x-cloak x-show="adding" action="{{ route('manage.home.store') }}" method="POST" enctype="multipart/form-data" class="m-4 rounded-xl border border-blue-100 bg-blue-50/60 p-4">
        @csrf
        <h3 class="mb-4 font-semibold text-blue-900">Form tambah Home</h3>
        <div class="grid gap-4 md:grid-cols-2">
          <div>
            <label for="home-content" class="mb-1 block text-sm font-medium text-gray-700">Teks sambutan</label>
            <textarea id="home-content" name="content" rows="3" required class="w-full rounded-lg border border-slate-300 bg-white p-3 focus:border-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('content') }}</textarea>
          </div>
          <div>
            <label for="home-foto" class="mb-1 block text-sm font-medium text-gray-700">Foto profil</label>
            <input id="home-foto" type="file" name="foto" accept="image/jpeg,image/png,image/webp" required class="block w-full rounded-lg border border-slate-300 bg-white p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-900">
            <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP; maksimal 5 MB.</p>
          </div>
        </div>
        <div class="mt-4 flex gap-2">
          <button type="submit" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan</button>
          <button type="button" @click="open = false" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-100">Batal</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full min-w-[700px] divide-y divide-slate-200 text-left text-sm">
        <thead class="bg-white text-xs uppercase tracking-wide text-gray-500">
          <tr>
            <th class="px-5 py-3 font-semibold">ID</th>
            <th class="px-5 py-3 font-semibold">Foto</th>
            <th class="px-5 py-3 font-semibold">Teks sambutan</th>
            <th class="px-5 py-3 text-right font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody x-data="{ editingId: null }" class="divide-y divide-slate-100">
          @forelse ($homeItems as $item)
            <tr class="align-top hover:bg-slate-50">
              <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-700">{{ $item->id }}</td>
              <td class="px-5 py-4"><img src="{{ $item->foto }}" alt="Foto profil" class="h-12 w-12 rounded-full object-cover"></td>
              <td class="max-w-lg px-5 py-4 text-gray-600"><p class="line-clamp-2 whitespace-pre-line">{{ $item->content }}</p></td>
              <td class="px-5 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <button type="button" @click="editingId = editingId === {{ $item->id }} ? null : {{ $item->id }}" class="rounded-md border border-blue-200 px-3 py-1.5 font-medium text-blue-900 hover:bg-blue-50" x-text="editingId === {{ $item->id }} ? 'Tutup' : 'Edit'"></button>
                  <form action="{{ route('manage.home.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus konten Home ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 font-medium text-red-700 hover:bg-red-50">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
            <tr x-cloak x-show="editingId === {{ $item->id }}" class="bg-blue-50/50">
              <td colspan="4" class="border-t border-blue-100 px-5 py-4">
                <form action="{{ route('manage.home.update', $item) }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-4xl rounded-lg border border-blue-100 bg-white p-4">
                  @csrf
                  @method('PUT')
                  <h3 class="mb-4 font-semibold text-blue-900">Edit Home #{{ $item->id }}</h3>
                  <div class="grid gap-4 md:grid-cols-2">
                    <div>
                      <label for="home-content-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Teks sambutan</label>
                      <textarea id="home-content-{{ $item->id }}" name="content" rows="3" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->content }}</textarea>
                    </div>
                    <div>
                      <label for="home-foto-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Ganti foto (opsional)</label>
                      <div class="flex items-center gap-3">
                        <img src="{{ $item->foto }}" alt="Foto profil saat ini" class="h-12 w-12 rounded-full object-cover">
                        <input id="home-foto-{{ $item->id }}" type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="min-w-0 flex-1 rounded-lg border border-slate-300 p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-900">
                      </div>
                      <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP; maksimal 5 MB.</p>
                    </div>
                  </div>
                  <button type="submit" class="mt-4 rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan perubahan</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500">Belum ada data Home.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <section id="about" x-data="{ adding: false }" class="mb-10 scroll-mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
      <div>
        <h2 class="text-xl font-bold text-blue-900">About</h2>
        <p class="mt-1 text-sm text-gray-600">Profil, pendidikan, dan kemampuan.</p>
      </div>
      <button type="button" @click="adding = !adding" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800" x-text="adding ? 'Tutup form' : '+ Tambah About'"></button>
    </div>

    <div>
      <form x-cloak x-show="adding" action="{{ route('manage.about.store') }}" method="POST" class="m-4 rounded-xl border border-blue-100 bg-blue-50/60 p-4">
        @csrf
        <h3 class="mb-4 font-semibold text-blue-900">Form tambah About</h3>
        <div class="grid gap-4 md:grid-cols-3">
          <div><label for="aboutme" class="mb-1 block text-sm font-medium text-gray-700">Tentang saya</label><textarea id="aboutme" name="aboutme" rows="3" required class="w-full rounded-lg border border-slate-300 bg-white p-3">{{ old('aboutme') }}</textarea></div>
          <div><label for="study" class="mb-1 block text-sm font-medium text-gray-700">Pendidikan</label><textarea id="study" name="study" rows="3" required placeholder="Pisahkan tiap pendidikan dengan baris baru" class="w-full rounded-lg border border-slate-300 bg-white p-3">{{ old('study') }}</textarea></div>
          <div><label for="skill" class="mb-1 block text-sm font-medium text-gray-700">Kemampuan (maks. 250 karakter)</label><textarea id="skill" name="skill" rows="3" maxlength="250" required class="w-full rounded-lg border border-slate-300 bg-white p-3">{{ old('skill') }}</textarea></div>
        </div>
        <div class="mt-4 flex gap-2">
          <button type="submit" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan</button>
          <button type="button" @click="open = false" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-100">Batal</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full min-w-[850px] divide-y divide-slate-200 text-left text-sm">
        <thead class="bg-white text-xs uppercase tracking-wide text-gray-500">
          <tr><th class="px-5 py-3 font-semibold">ID</th><th class="px-5 py-3 font-semibold">Tentang saya</th><th class="px-5 py-3 font-semibold">Pendidikan</th><th class="px-5 py-3 font-semibold">Kemampuan</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr>
        </thead>
        <tbody x-data="{ editingId: null }" class="divide-y divide-slate-100">
          @forelse ($aboutItems as $item)
            <tr class="align-top hover:bg-slate-50">
              <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-700">{{ $item->id }}</td>
              <td class="max-w-xs px-5 py-4 text-gray-600"><p class="line-clamp-2 whitespace-pre-line">{{ $item->aboutme }}</p></td>
              <td class="max-w-xs px-5 py-4 text-gray-600"><p class="line-clamp-2 whitespace-pre-line">{{ $item->study }}</p></td>
              <td class="max-w-xs px-5 py-4 text-gray-600"><p class="line-clamp-2 whitespace-pre-line">{{ $item->skill }}</p></td>
              <td class="whitespace-nowrap px-5 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <button type="button" @click="editingId = editingId === {{ $item->id }} ? null : {{ $item->id }}" class="rounded-md border border-blue-200 px-3 py-1.5 font-medium text-blue-900 hover:bg-blue-50" x-text="editingId === {{ $item->id }} ? 'Tutup' : 'Edit'"></button>
                  <form action="{{ route('manage.about.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus konten About ini?')">@csrf @method('DELETE')<button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 font-medium text-red-700 hover:bg-red-50">Hapus</button></form>
                </div>
              </td>
            </tr>
            <tr x-cloak x-show="editingId === {{ $item->id }}" class="bg-blue-50/50">
              <td colspan="5" class="border-t border-blue-100 px-5 py-4">
                <form action="{{ route('manage.about.update', $item) }}" method="POST" class="rounded-lg border border-blue-100 bg-white p-4">
                  @csrf @method('PUT')
                  <h3 class="mb-4 font-semibold text-blue-900">Edit About #{{ $item->id }}</h3>
                  <div class="grid gap-4 md:grid-cols-3">
                    <div><label for="aboutme-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Tentang saya</label><textarea id="aboutme-{{ $item->id }}" name="aboutme" rows="3" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->aboutme }}</textarea></div>
                    <div><label for="study-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Pendidikan</label><textarea id="study-{{ $item->id }}" name="study" rows="3" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->study }}</textarea></div>
                    <div><label for="skill-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Kemampuan (maks. 250 karakter)</label><textarea id="skill-{{ $item->id }}" name="skill" rows="3" maxlength="250" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->skill }}</textarea></div>
                  </div>
                  <button type="submit" class="mt-4 rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan perubahan</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada data About.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <section id="portfolio" x-data="{ adding: false }" class="mb-10 scroll-mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
      <div>
        <h2 class="text-xl font-bold text-blue-900">Portfolio</h2>
        <p class="mt-1 text-sm text-gray-600">Judul proyek, deskripsi, tautan, dan foto.</p>
      </div>
      <button type="button" @click="adding = !adding" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800" x-text="adding ? 'Tutup form' : '+ Tambah Portfolio'"></button>
    </div>

    <div>
      <form x-cloak x-show="adding" action="{{ route('manage.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="m-4 rounded-xl border border-blue-100 bg-blue-50/60 p-4">
        @csrf
        <h3 class="mb-4 font-semibold text-blue-900">Form tambah Portfolio</h3>
        <div class="grid gap-4 md:grid-cols-2">
          <div><label for="portfolio-judul" class="mb-1 block text-sm font-medium text-gray-700">Judul proyek</label><input id="portfolio-judul" type="text" name="judul" value="{{ old('judul') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 bg-white p-3"></div>
          <div><label for="portfolio-link" class="mb-1 block text-sm font-medium text-gray-700">Tautan proyek (URL http/https)</label><input id="portfolio-link" type="url" name="link" value="{{ old('link') }}" required class="w-full rounded-lg border border-slate-300 bg-white p-3"></div>
          <div><label for="portfolio-isi" class="mb-1 block text-sm font-medium text-gray-700">Deskripsi</label><textarea id="portfolio-isi" name="isi" rows="3" required class="w-full rounded-lg border border-slate-300 bg-white p-3">{{ old('isi') }}</textarea></div>
          <div><label for="portfolio-foto" class="mb-1 block text-sm font-medium text-gray-700">Foto proyek</label><input id="portfolio-foto" type="file" name="foto" accept="image/jpeg,image/png,image/webp" required class="block w-full rounded-lg border border-slate-300 bg-white p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-900"><p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP; maksimal 5 MB.</p></div>
        </div>
        <div class="mt-4 flex gap-2">
          <button type="submit" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan</button>
          <button type="button" @click="open = false" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-100">Batal</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full min-w-[850px] divide-y divide-slate-200 text-left text-sm">
        <thead class="bg-white text-xs uppercase tracking-wide text-gray-500">
          <tr><th class="px-5 py-3 font-semibold">ID</th><th class="px-5 py-3 font-semibold">Foto</th><th class="px-5 py-3 font-semibold">Judul proyek</th><th class="px-5 py-3 font-semibold">Deskripsi</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr>
        </thead>
        <tbody x-data="{ editingId: null }" class="divide-y divide-slate-100">
          @forelse ($portfolioItems as $item)
            <tr class="align-top hover:bg-slate-50">
              <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-700">{{ $item->id }}</td>
              <td class="px-5 py-4"><img src="{{ $item->foto }}" alt="Foto proyek {{ $item->judul }}" class="h-12 w-16 rounded-md object-cover"></td>
              <td class="max-w-xs px-5 py-4 font-medium text-gray-800">{{ $item->judul }}</td>
              <td class="max-w-sm px-5 py-4 text-gray-600"><p class="line-clamp-2">{{ $item->isi }}</p></td>
              <td class="px-5 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <button type="button" @click="editingId = editingId === {{ $item->id }} ? null : {{ $item->id }}" class="rounded-md border border-blue-200 px-3 py-1.5 font-medium text-blue-900 hover:bg-blue-50" x-text="editingId === {{ $item->id }} ? 'Tutup' : 'Edit'"></button>
                  <form action="{{ route('manage.portfolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus portfolio ini?')">@csrf @method('DELETE')<button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 font-medium text-red-700 hover:bg-red-50">Hapus</button></form>
                </div>
              </td>
            </tr>
            <tr x-cloak x-show="editingId === {{ $item->id }}" class="bg-blue-50/50">
              <td colspan="5" class="border-t border-blue-100 px-5 py-4">
                <form action="{{ route('manage.portfolio.update', $item) }}" method="POST" enctype="multipart/form-data" class="rounded-lg border border-blue-100 bg-white p-4">
                  @csrf @method('PUT')
                  <h3 class="mb-4 font-semibold text-blue-900">Edit Portfolio #{{ $item->id }}</h3>
                  <div class="grid gap-4 md:grid-cols-2">
                    <div><label for="portfolio-judul-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Judul proyek</label><input id="portfolio-judul-{{ $item->id }}" type="text" name="judul" value="{{ $item->judul }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 p-3"></div>
                    <div><label for="portfolio-link-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Tautan proyek</label><input id="portfolio-link-{{ $item->id }}" type="url" name="link" value="{{ $item->link }}" required class="w-full rounded-lg border border-slate-300 p-3"></div>
                    <div><label for="portfolio-isi-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Deskripsi</label><textarea id="portfolio-isi-{{ $item->id }}" name="isi" rows="3" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->isi }}</textarea></div>
                    <div>
                      <label for="portfolio-foto-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Ganti foto (opsional)</label>
                      <div class="flex items-center gap-3"><img src="{{ $item->foto }}" alt="Foto proyek saat ini" class="h-12 w-16 rounded-md object-cover"><input id="portfolio-foto-{{ $item->id }}" type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="min-w-0 flex-1 rounded-lg border border-slate-300 p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-900"></div>
                      <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP; maksimal 5 MB.</p>
                    </div>
                  </div>
                  <button type="submit" class="mt-4 rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan perubahan</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada data Portfolio.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <section id="blog" x-data="{ adding: false }" class="mb-10 scroll-mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
      <div>
        <h2 class="text-xl font-bold text-blue-900">Blog</h2>
        <p class="mt-1 text-sm text-gray-600">Judul, subjudul, dan isi artikel.</p>
      </div>
      <button type="button" @click="adding = !adding" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800" x-text="adding ? 'Tutup form' : '+ Tambah Blog'"></button>
    </div>

    <div>
      <form x-cloak x-show="adding" action="{{ route('manage.blog.store') }}" method="POST" class="m-4 rounded-xl border border-blue-100 bg-blue-50/60 p-4">
        @csrf
        <h3 class="mb-4 font-semibold text-blue-900">Form tambah Blog</h3>
        <div class="grid gap-4 md:grid-cols-2">
          <div><label for="blog-title" class="mb-1 block text-sm font-medium text-gray-700">Judul</label><input id="blog-title" type="text" name="title" value="{{ old('title') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 bg-white p-3"></div>
          <div><label for="blog-subtitle" class="mb-1 block text-sm font-medium text-gray-700">Subjudul</label><input id="blog-subtitle" type="text" name="subtitle" value="{{ old('subtitle') }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 bg-white p-3"></div>
          <div class="md:col-span-2"><label for="blog-description" class="mb-1 block text-sm font-medium text-gray-700">Isi artikel</label><textarea id="blog-description" name="description" rows="4" required class="w-full rounded-lg border border-slate-300 bg-white p-3">{{ old('description') }}</textarea></div>
        </div>
        <div class="mt-4 flex gap-2">
          <button type="submit" class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan</button>
          <button type="button" @click="open = false" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-100">Batal</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full min-w-[800px] divide-y divide-slate-200 text-left text-sm">
        <thead class="bg-white text-xs uppercase tracking-wide text-gray-500">
          <tr><th class="px-5 py-3 font-semibold">ID</th><th class="px-5 py-3 font-semibold">Judul</th><th class="px-5 py-3 font-semibold">Subjudul</th><th class="px-5 py-3 font-semibold">Isi artikel</th><th class="px-5 py-3 text-right font-semibold">Aksi</th></tr>
        </thead>
        <tbody x-data="{ editingId: null }" class="divide-y divide-slate-100">
          @forelse ($blogItems as $item)
            <tr class="align-top hover:bg-slate-50">
              <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-700">{{ $item->id }}</td>
              <td class="max-w-xs px-5 py-4 font-medium text-gray-800">{{ $item->title }}</td>
              <td class="max-w-xs px-5 py-4 text-gray-600"><p class="line-clamp-2">{{ $item->subtitle }}</p></td>
              <td class="max-w-sm px-5 py-4 text-gray-600"><p class="line-clamp-2">{{ $item->description }}</p></td>
              <td class="px-5 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <button type="button" @click="editingId = editingId === {{ $item->id }} ? null : {{ $item->id }}" class="rounded-md border border-blue-200 px-3 py-1.5 font-medium text-blue-900 hover:bg-blue-50" x-text="editingId === {{ $item->id }} ? 'Tutup' : 'Edit'"></button>
                  <form action="{{ route('manage.blog.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 font-medium text-red-700 hover:bg-red-50">Hapus</button></form>
                </div>
              </td>
            </tr>
            <tr x-cloak x-show="editingId === {{ $item->id }}" class="bg-blue-50/50">
              <td colspan="5" class="border-t border-blue-100 px-5 py-4">
                <form action="{{ route('manage.blog.update', $item) }}" method="POST" class="rounded-lg border border-blue-100 bg-white p-4">
                  @csrf @method('PUT')
                  <h3 class="mb-4 font-semibold text-blue-900">Edit Blog #{{ $item->id }}</h3>
                  <div class="grid gap-4 md:grid-cols-2">
                    <div><label for="blog-title-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Judul</label><input id="blog-title-{{ $item->id }}" type="text" name="title" value="{{ $item->title }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 p-3"></div>
                    <div><label for="blog-subtitle-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Subjudul</label><input id="blog-subtitle-{{ $item->id }}" type="text" name="subtitle" value="{{ $item->subtitle }}" maxlength="255" required class="w-full rounded-lg border border-slate-300 p-3"></div>
                    <div class="md:col-span-2"><label for="blog-description-{{ $item->id }}" class="mb-1 block text-sm font-medium text-gray-700">Isi artikel</label><textarea id="blog-description-{{ $item->id }}" name="description" rows="4" required class="w-full rounded-lg border border-slate-300 p-3">{{ $item->description }}</textarea></div>
                  </div>
                  <button type="submit" class="mt-4 rounded-lg bg-blue-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">Simpan perubahan</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada data Blog.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</x-layout>
