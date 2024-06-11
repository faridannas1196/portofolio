<x-layout>
  <x-slot:header>{{$header}}</x-slot:header>
    <div class="flex">
      <div class="flex-1 bg-white flex items-center justify-center p-10">
          <article class="py-7 max-w-screen-md border-b border-gray-300">
              <h1 class="text-3xl font-bold mb-4 text-blue-900">Selamat Datang di Portofolio Saya  </h1>
              @foreach($home as $h)
              <p class="text-lg text-gray-500">{{$h -> content}}
              </p>
          </article>
      </div>
      @endforeach     

      <div class="flex-1 flex items-center justify-center">
          <img src="{{$h -> foto}}" alt="Placeholder Image" class="rounded-full object-cover w-62 h-60">
      </div> 
    </div>
</x-layout>