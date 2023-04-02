<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="py-2.5">
        {{-- {{ $logo }} --}}
       <a href="{{route("/")}}"> <img class="img-fluid mx-auto" src="{{ asset('main/img/logoshoppyJapan.png')}}" alt="Image" width="30%"></a>
    </div>

    <div class="w-full sm:max-w-md my-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
