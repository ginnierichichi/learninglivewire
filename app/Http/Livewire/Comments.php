<?php

namespace App\Http\Livewire;

use App\Models\Comment;
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
    public $image;
    public $photo;
    public $ticketId;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected' => 'ticketSelected',
    ];

//    public function mount()
//    {
//        $this->comments = Comment::latest()->get();
//    }

    public function save()
    {
        $this->validate([
           'photo' => 'image|max:1024',
        ]);

        $this->photo->store('photos');
    }

    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function update($field)
    {
        $this->validateOnly($field, [
            'newComment'=> 'required|max:255',
            ]);
    }

    public function addComment()
    {
       $this->validate(['newComment'=>'required|max:255']);
       $image = $this->storeImage();
        $createdComment = Comment::create([
            'body' => $this->newComment,
            'user_id' => 1,
            'image' => $image,
            'support_ticket_id' => $this->ticketId,
        ]);

//        $this->comments->prepend($createdComment);

        $this->newComment ='';
        $this->image = '';

        session()->flash('message', 'Comment added successfully!');
    }

    public function storeImage()
    {
        if(!$this->image) {
            return null;
        }

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function remove($commentId)
    {
         $comment = Comment::find($commentId);
         Storage::disk('public')->delete($comment->image);
         $comment->delete();
//         $this->comments = $this->comments->except($commentId);

        session()->flash('message', 'Comment deleted successfully!');

    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::where('support_ticket_id', $this->ticketId)->latest()->paginate(10)
        ]);
    }


}

