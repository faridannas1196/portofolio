<x-layout>
  <x-slot:header>{{$header}}</x-slot:header>
  @foreach ($blog as $blg)      
  <article class="py-7 max-w-screen-md border-b border-gray-300">
    <h2 class="mb-1 text-3xl tracking-tight font-bold text-blue-900">{{$blg -> title}}</h2>
    <div class="text-justify text-gray-500">
      {{$blg -> subtitle}}
    </div>
    <p class="my-4 font-light">{{$blg -> description}}</p>
  </article>
  @endforeach
</x-layout>