<x-guest-layout-large>
    
<x-auth-session-status class="mb-1" :status="session('status')" />

<x-auth-session-status class="mb-1" :status="session('status')" />
<form action="{{ route('store.file') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <x-file-upload name="documento_pdf" label="Selecciona un archivo PDF" />
    @error('documento_pdf')
    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
    
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">
        Subir
    </button>
</form>
</x-guest-layout-large>