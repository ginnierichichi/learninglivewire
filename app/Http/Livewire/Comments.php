<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Comments extends Component
{
//    public $comments;
    use WithFileUploads;
    use WithPagination;
    public $newComment;
//    public $image;
    public $images = [];
    public $ticket;
    public $comments;
    public $active;     //first one is always selected
    public $newTicket;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected' => 'ticketSelected',
        'ticketClicked',
    ];

//    public function mount()
//    {
//        $this->comments = Comment::latest()->get();
//    }

//    public function updatedPhoto()
//    {
//        $this->validate([
//            'photo' => 'image|max:1024',
//        ]);
//    }


    public function addTicket()
    {
        $this->validate(['newTicket'=>'required|max:255']);

        $createdTicket = SupportTicket::create([
            'questions' => $this->newTicket,
        ]);
        $this->newTicket ='';
    }

    public function ticketClicked(SupportTicket $ticket)
    {
//        $this->active = $ticketId;

//        dd($ticket);
        $this->active = $ticket->id;
        $this->ticket = $ticket;
        $this->comments = Comment::where('support_ticket_id', $ticket->id)->with('creator')->latest()->get()->toArray();
    }


    public function oops($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function ticketSelected(SupportTicket $ticket)
    {
        dd($ticket);
        $this->ticket = $ticket;
        $this->comments = Comment::where('support_ticket_id', $ticket->id)->with('creator')->latest()->get()->toArray();
    }

    public function handleFileUpload($imagesData)
    {
        $this->images[] = $imagesData;
    }

    public function update($field)
    {
        $this->validateOnly($field, [
            'newComment'=> 'required|max:255',
            ]);
    }

    public function addComment()
    {
       $this->validate([
           'newComment'=>'required|max:255',
       ]);

       $images = $this->storeImage();



        $createdComment = Comment::create([
            'body' => $this->newComment,
            'user_id' => auth()->id(),
            'images' => $images,
            'support_ticket_id' => $this->ticket['id'],
        ]);

//        $this->comments->prepend($createdComment);

        $this->newComment = '';
        $this->images = [];

        session()->flash('message', 'Comment added successfully!');
    }

    public function storeImage()
    {
        if(count($this->images) == 0) {
            return null;
        }

        $filenames = [];

        foreach($this->images as $image){
            $img = ImageManagerStatic::make($image)->encode('jpg');

            $filename = Str::random() . '.jpg';

            Storage::disk('public')->put($filename, $img);

            $filenames[] = $filename;
        }

        return $filenames;



//        if(!$this->images) {
//            return null;
//        }
//
//        $img = ImageManagerStatic::make($this->images)->encode('jpg');
//        $name = Str::random() . '.jpg';
//        Storage::disk('public')->put($name, $img);
//        return $name;
    }


    public function save()
    {
        $this->validate([
            'images.*' => 'image|max:10240',
        ]);

        foreach ($this->images as $image) {
            $image->store('images');
        }

    }

    public function destroy($ticket)
    {
        $ticket->delete();
    }

    public function remove($commentId)
    {
         $comment = Comment::find($commentId);
         Storage::disk('public')->delete($comment->images);
         $comment->delete();
//         $this->comments = $this->comments->except($commentId);

        session()->flash('message', 'Comment deleted successfully!');

    }

    public function render()
    {
        return view('livewire.comments', [
            'tickets' => SupportTicket::all(),
//            'comments' => Comment::where('support_ticket_id', $this->ticket->id)->latest()->paginate(10)
        ]);
    }


}

