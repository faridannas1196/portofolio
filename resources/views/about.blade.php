<x-layout>
  <x-slot:header>{{$header}}</x-slot:header>
  @forelse($about as $item)
    <article class="py-7 max-w-screen-md border-b border-gray-300">
      <h5 class="mb-1 text-2xl tracking-tight font-bold text-blue-900">Tentang Saya</h5>
      <p class="my-4 whitespace-pre-line font-light">{{ $item->aboutme }}</p>
    </article>
    
    <article class="py-9 max-w-screen-md border-b border-gray-300">
      <h5 class="mb-1 text-2xl tracking-tight font-bold text-blue-900">Pendidikan</h5>
      <p class="my-4 whitespace-pre-line font-light">{{ $item->study }}</p>
    </article>

    <article class="py-7 max-w-screen-md border-b border-gray-300">
      <h5 class="mb-1 text-2xl tracking-tight font-bold text-blue-900">Kemampuan</h5>
      <p class="my-4 whitespace-pre-line font-light">{{ $item->skill }}</p>
    </article>
  @empty
    <p class="rounded-lg bg-slate-100 p-6 text-gray-600">Konten About belum tersedia.</p>
  @endforelse
  </x-layout>