<div class="flex w-full">
    <div class="text-center w-5/12 mx-2 mt-4 rounded-lg border shadow-lg p-2">
        {{-- The Master doesn't talk, he acts. --}}
        <h1 class="text-2xl">Tickets</h1>

        <form wire:submit.prevent="addTicket" class="my-4 flex justify-center">
            <input wire:model.debounce.500ms="newTicket"
                   type="text"
                   class="w-2/3 rounded border shadow p-2 mr-2 my-2"
                   placeholder="Create a Ticket">
            <div class="py-2">
                <button type="submit" class="bg-blue-300 rounded-lg px-4 py-2 text-white">Add</button>
            </div>
        </form>

        @foreach($tickets as $ticket)
            <div class="flex justify-center mb-4">
                <div class="flex items-center justify-between rounded-lg border bg-white p-3 w-2/3 {{$active == $ticket->id ? 'bg-gray-200' : 'shadow-lg'}}" wire:click="$emit('ticketClicked', {{$ticket->id}})">
                    <p class="text-gray-800 text-left">{{$ticket->questions}}</p>
                    <i wire:click="bye({{$ticket->id}})"
                       class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"></i>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center w-7/12 ">
        <div class="mx-2 rounded-lg border mt-4 shadow-lg p-2">
            @if($active)
            {{-- In work, do what you enjoy. --}}
                @error('newComment') <span class="text-red-500 text-xs">{{$message}}</span>@enderror

                <section class="flex w-full justify-center">
                    <div class="w-2/3">
                        {{--            <div>--}}
                        {{--                @error('images') <span class="error">{{$message}}</span> @enderror--}}
                        {{--                @if($images)--}}
                        {{--                    @foreach($images as $image)--}}
                        {{--                        <img src="{{$image->temporaryUrl()}}" width="200" class="rounded-lg shadow" alt=""/>--}}
                        {{--                    @endforeach--}}
                        {{--                @endif--}}

                        {{--                <div--}}
                        {{--                    x-data="{ isUploading: false, progress: 0 }"--}}
                        {{--                    x-on:livewire-upload-start="isUploading = true"--}}
                        {{--                    x-on:livewire-upload-finish="isUploading = false"--}}
                        {{--                    x-on:livewire-upload-error="isUploading = false"--}}
                        {{--                    x-on:livewire-upload-progress="progress = $event.detail.progress"--}}
                        {{--                >--}}
                        {{--                    <div @click="$refs.fileInput.click()">Upload Images</div>--}}
                        {{--                    <input x-ref="fileInput" multiple type="file" wire:model="image" />--}}
                        {{--                    <button wire:click.prevent="save">Save</button>--}}

                        {{--                    <!-- Progress Bar -->--}}
                        {{--                    <div x-show="isUploading">--}}
                        {{--                        <progress max="100" x-bind:value="progress"></progress>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--            </div>--}}

                        <form enctype="multipart/form-data" method="post">
                            <div class="px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md
        mb-5 relative hover:bg-gray-50">
                                <div class="text-center">
                                    <i class="fas fa-file-upload text-gray-400 fa-2x my-4"></i>
                                    <p class="mt-1 text-sm text-gray-600">
                                        <button type="button"
                                                class="font-medium text-brand-primary hover:underline focus:outline-none
                            focus:underline transition duration-150 ease-in-out">
                                            Click to upload files
                                        </button>
                                        or drag and drop files here
                                    </p>
                                    <input type="file" id="images" wire:change="$emit('fileChosen')"
                                           class="absolute h-full left-0 top-0 opacity-0 mb-8 cursor-pointer" multiple>
                                </div>
                            </div>
                        </form>


                        @foreach($images as $image)
                            @if ($image)
                                <img src="{{ $image }}" alt="preview" class="mb-8 w-56 rounded-lg shadow">
                            @endif
                        @endforeach

    {{--                    <form enctype="multipart/form-data" method="post">--}}
    {{--                        <input type="file" id="images" class="mb-8" wire:change="$emit('fileChosen')" multiple>--}}
    {{--                    </form>--}}

                        {{--            <div class="">--}}
                        {{--                    @if($images)--}}
                        {{--                        <img src="{{$images}}" width="200" class="rounded-lg shadow-lg mr-10" />--}}
                        {{--                    @endif--}}
                        {{--                <input type="file" multiple id="images" wire:change="$emit('fileChosen')">--}}
                        {{--            </div>--}}
                    </div>

                </section>

                <form wire:submit.prevent="addComment" class="my-4 flex justify-center">
                    <input wire:model.debounce.500ms="newComment"
                           type="text"
                           class="w-2/3 rounded border shadow p-2 mr-2 my-2"
                           placeholder="Whats on your mind?">
                    <div class="py-2">
                        <button type="submit" class="bg-blue-300 rounded-lg px-4 py-2 text-white">Add</button>
                    </div>
                </form>

                <div class="flex justify-center">
                    @if(session()->has('message'))
                        <div class="alert alert-success bg-green-300 text-green-800 rounded-lg w-2/3 p-6 shadow">
                            {{session('message')}}
                        </div>
                    @endif
                </div>
            @else
                <div class="flex items-center justify-center">
                    <i class="fas fa-arrow-left pr-6 "></i>
                    <h1 class="text-2xl">Please create a ticket</h1>
                </div>
            @endif

        </div>

        <div class="mx-2 rounded-lg border mt-4 shadow-lg p-2">
            <h1 class="text-2xl mb-6"> Comments</h1>
            @if($comments)
                @foreach($comments as $comment)
                    <div class="flex justify-center mb-4">
                        <div class="rounded-lg border bg-white shadow-lg p-3 w-2/3">

                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <p class="font-bold text-lg text-gray-700">{{$comment['creator']['name']}}</p>
                                    <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">{{$comment['created_at']}}</p>
                                </div>
                                <i wire:click="remove({{$comment['id']}})"
                                   class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"></i>
                            </div>
                            <p class="text-gray-700 text-left">{{$comment['body']}}</p>
                            @if($comment['images'])
                                @foreach ($comment['images'] as $image)
                                    <div class="flex-1 mr-2 " >
                                        <img src="{{ asset($image) }}" alt="Comment Image" class="my-4 rounded-lg shadow " width="300">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
                {{--        {{$comments['links']('pagination-links')}}--}}
            @else
                <div class="text-center text-gray-900 text-semibold text-lg">
                    No comments have been added for this ticket.
                </div>
            @endif
        </div>
    </div>
</div>
<script>

    window.livewire.on('fileChosen', () => {
        let inputFile = document.getElementById('images');
        let file = inputFile.files;
        for (let i = 0; i < file.length; i++) {
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result);
            };
            reader.readAsDataURL(file[i]);
        }

    });
</script>
