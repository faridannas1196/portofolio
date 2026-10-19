<x-layout>
  <x-slot:header>{{$header}}</x-slot:header>
  @forelse($home as $item)
    <div class="flex flex-col items-center gap-8 md:flex-row">
      <div class="flex-1 bg-white p-6 md:p-10">
        <article class="py-7 max-w-screen-md border-b border-gray-300">
          <h1 class="text-3xl font-bold mb-4 text-blue-900">Selamat Datang di Portofolio Saya</h1>
          <p class="text-lg text-gray-500 whitespace-pre-line">{{ $item->content }}</p>
        </article>
      </div>
      <div class="flex-1 flex items-center justify-center">
        <img src="{{ $item->foto }}" alt="Foto profil" class="rounded-full object-cover w-60 h-60">
      </div>
    </div>
  @empty
    <p class="rounded-lg bg-slate-100 p-6 text-gray-600">Konten Home belum tersedia.</p>
  @endforelse
</x-layout>