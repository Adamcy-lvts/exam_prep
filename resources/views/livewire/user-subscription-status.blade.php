<div>
    {{-- The whole world belongs to you. --}}
    {{-- {{dd(auth()->user()->latestSubscriptionStatus())}} --}}
    @if(auth()->user()->latestSubscriptionStatus())
        <span class="inline-block px-2 py-1 text-xs font-semibold leading-none text-green-800 bg-green-200 rounded-lg">Active</span>
    @endif
    
</div>
