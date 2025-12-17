@props(['skin'])

@can('admin-access')
    <div class="absolute transition-opacity duration-300 opacity-0 top-2 left-2 group-hover:opacity-100">
        <div class="flex flex-col items-start px-2 py-1 text-xs text-white bg-black rounded gap-y-1 bg-opacity-70">
            <div class="flex items-center gap-x-1">
                <p>Chunk</p>
                <span>{{ number_format($skin->chunk_views ?? 0) }}</span>
            </div>
            <div class="flex items-center gap-x-1">
                <p>Chunk</p>
                <span>{{ number_format($skin->detailed_views ?? 0) }}</span>
            </div>
            <div class="flex items-center gap-x-1">
                <p>Total</p>
                <span>{{ number_format($skin->total_views ?? 0) }}</span>
            </div>
        </div>
    </div>
@endcan
