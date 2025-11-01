<div>
    @if(auth()->user()->hasTeamRole(auth()->user()->currentTeam, 'admin'))
        <form wire:submit="save" class="space-y-6">
           

            <div class="flex justify-end items-center gap-4">
                
            </div>
        </form>

    @else
        <img src="{{ auth()->user()->currentTeam->logo_url }}"
             alt="{{ auth()->user()->currentTeam->name }}"
             class="h-20 w-20 rounded-full object-cover border border-gray-300 shadow-sm">
    @endif
</div>
