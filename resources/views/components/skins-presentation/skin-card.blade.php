<div class="opacity-0 animate-skinApparition" style="animation-delay: {{ ($key - (Self::ITEMS_PER_PAGE * ($currentPage - 1))) * 35 }}ms">
    <p>{{ $skin->id }}</p>
    <img src="{{ asset('storage\/') . $skin->image_path }}">
    <p>{{ $skin->User->name }}</p>
</div>
