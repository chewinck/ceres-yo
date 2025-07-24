<div 
    x-data="{ fileName: '', fileUrl: '' }" 
    class="w-full p-4 border border-gray-200 rounded-lg shadow-sm bg-white"
>
    <!-- Label -->
    <label class="block mb-2 text-gray-700 font-semibold">
        {{ $label ?? 'Subir documento PDF' }}
    </label>

    <!-- Botón y nombre -->
    <div class="flex items-center gap-4">
        <!-- Botón estilizado -->
        <button 
            type="button"
            @click="$refs.fileInput.click()"
            class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 focus:ring focus:ring-green-300 transition"
        >
            Seleccionar archivo
        </button>

        <!-- Nombre del archivo -->
        <template x-if="fileName">
            <span class="text-sm text-gray-700 truncate max-w-xs" x-text="fileName"></span>
        </template>
    </div>

    <!-- Input oculto -->
    <input 
        type="file"
        accept="application/pdf"
        name="{{ $name ?? 'documento_pdf' }}"
        x-ref="fileInput"
        class="hidden"
        @change="
            const file = $event.target.files[0];
            if (file) {
                fileName = file.name;
                fileUrl = URL.createObjectURL(file);
            }
        "
    >

    <!-- Previsualización PDF -->
    <template x-if="fileUrl">
        <div class="mt-4">
            <embed :src="fileUrl" type="application/pdf" class="w-full h-64 border rounded" />
        </div>
    </template>
</div>
