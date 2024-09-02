<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;//画像を削除するため

class BookIndex extends Component
{   
    use WithFileUploads;//ファイルのアップロードに必要
    use WithPagination;//別途追加　BookIndexクラスに追加
    public $liveModal = false;//モーダルウィンドウ
    public $title;
    public $newImage;
    public $price;
    public $description;
    public $id;
    public $oldImage;
    public $editWork = false;//更新するかどうかに必要
    public $search = '';



    public function showBookModal(){
        $this->reset();
        $this->liveModal = true;
    }

    
    public function bookPost(){

        $this->validate([

            'title' => 'required',
            'newImage' => 'image|max:2048',
            'price' => 'integer|required',
            'price' => 'integer|required',
            'description' => 'required',
        ]);
        $image = $this->newImage->store('public/books');
        Book::create([
            'title' => $this->title,
            'image' => $image,
            'price' => $this->price,
            'description' => $this->description,
        ]);
        $this->reset();
    }

    public function showEditBookModal($id){

        $book = Book::findOrFail($id);
        $this-> id = $book->id;
        $this-> title = $book->title;
        $this-> oldImage = $book->image;
        $this-> price = $book->price;
        $this-> description = $book->description;
        $this-> editWork  = true;
        $this-> liveModal = true;
    }

    public function updateBook($id){

        $this->validate([

            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        if($this->newImage){
            $image = $this->newImage->store('public/books');
            Book::where('id', $id)->update([

                'title' => $this->title,
                'image' => $image,
                'price' => $this->price,
                'description' => $this->description,
            ]);

        }else{
            Book::where('id', $id)->update([

                'title' => $this->title,
                'price' => $this->price,
                'description' => $this->description,
            ]);
        }
        session()->flash('message', '更新しました!');
    }

    public function deleteBook($id){

        $book = Book::findOrFail($id);
        Storage::delete($book->image);
        $book->delete();
        $this->reset();
    }


    public function render()
    {   
        if(!empty($this->search)){
  
            return view('livewire.book-index',[

                'books' => Book::where('title', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'DESC')->paginate(3),
            ]);
        }else{

            return view('livewire.book-index', [
                'books' => Book::select('id', 'title', 'price', 'image', 'description')
                ->orderBy('id', 'DESC')
                ->paginate(3),
            ]);
        }
    }
}
