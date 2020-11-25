<div class="flex justify-center mt-8">
    @if($paginator->hasPages())
    <ul class="w-2/3">
        <div class="flex justify-between">
            @if($paginator->onFirstPage())
                <li wire:click="previousPage" class="w-16 px-2 py-1 text-center rounded border ">Prev</li>
            @else
                <li wire:click="previousPage" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">Prev</li>
            @endif

            <div class="flex justify-center">
            @foreach($elements as $element)
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-blue-500 text-gray-100 cursor-pointer" wire:click="gotoPage({{$page}})">{{$page}}</li>
                            @else
                            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer" wire:click="gotoPage({{$page}})">{{$page}}</li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            </div>

            @if($paginator->hasMorePages())
                <li wire:click="nextPage" class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer">Next</li>
            @else
                <li class="w-16 px-2 py-1 text-center rounded border">Next</li>
            @endif
        </div>
    </ul>
    @endif
</div>
