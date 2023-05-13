<div class="opacity-0 animate-skinApparition bg-primary-100" style="animation-delay: {{ ($key - (Self::ITEMS_PER_PAGE * ($currentPage - 1))) * 35 }}ms">
    <p>{{ $skin->id }}</p>
    @foreach($skin->Rewards()->get() as $reward)
        <p>{{ $reward->reward_rank }}</p>
    @endforeach
    <img src="{{ asset('storage\/') . $skin->image_path }}">
    <p>{{ $skin->updated_at }}</p>
    <p>{{ count($skin->Likes()->get()) }} j'aimes</p>
    <p class="text-goldText font-light text-[0.75rem] hover:text-goldTextLit">{{ $skin->User->name }}</p>
</div>
