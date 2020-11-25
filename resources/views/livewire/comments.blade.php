<div class="text-center">
    {{-- In work, do what you enjoy. --}}
   <h1 class="text-2xl mb-6"> Comments</h1>
    @error('newComment') <span class="text-red-500 text-xs">{{$message}}</span>@enderror

    <section class="flex justify-center">
        <div class="w-2/3">
            <div>
                @error('photo') <span class="error">{{$message}}</span> @enderror
                <input type="file" wire:model="photo" />
                <button wire:click.prevent="save">Save</button>
            </div>
{{--            <div class="">--}}
{{--                @if($image)--}}
{{--                    <img src="{{$image}}" width="200" class="rounded-lg shadow-lg mr-10" />--}}
{{--                @endif--}}
{{--                <input type="file" id="image" wire:change="$emit('fileChosen')">--}}
{{--            </div>--}}
        </div>
    </section>

    <div class="flex justify-center">
        @if(session()->has('message'))
            <div class="alert alert-success bg-green-300 text-green-800 rounded-lg w-2/3 p-6 shadow">
                {{session('message')}}
            </div>
        @endif
    </div>

    <form wire:submit.prevent="addComment" class="my-4 flex justify-center">
        <input wire:model.debounce.500ms="newComment"
               type="text"
               class="w-2/3 rounded border shadow p-2 mr-2 my-2"
               placeholder="Whats on your mind?">
        <div class="py-2">
            <button type="submit" class="bg-blue-300 rounded-lg px-4 py-2 text-white">Add</button>
        </div>
    </form>

    @foreach($comments as $comment)
        <div class="flex justify-center mb-4">
            <div class="rounded-lg border bg-white shadow-lg p-3 w-2/3">

                <div class="flex justify-between">
                    <div class="flex items-center">
                    <p class="font-bold text-lg text-gray-700">{{$comment->creator->name}}</p>
                    <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">{{$comment->created_at->diffForHumans()}}</p>
                    </div>
                    <i wire:click="remove({{$comment->id}})" class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"></i>
                </div>
                    <p class="text-gray-700 text-left">{{$comment->body}}</p>
                @if($comment->image)
                    <img src="{{asset($comment->image)}}" width="200">
                @endif

            </div>
        </div>
    @endforeach

    {{$comments->links('pagination-links')}}
</div>

<script>
    window.livewire.on('fileChosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0]

        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result);
        }
        reader.readAsDataURL(file);
    })
</script>
