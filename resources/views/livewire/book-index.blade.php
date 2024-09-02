<div class="max-w-6xl mx-auto">
    <div class="text-right m-2 p-2">
    <x-button class="bg-blue-600 mt-2" wire:click="showBookModal">登録</x-button>
    </div>

    
    <div class="m-2 p-2">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-gray-500 text-left">Id</th>
                        <th class="p-4 text-gray-500 text-left">Title</th>
                        <th class="p-4 text-gray-500 text-left">Image</th>
                        <th class="p-4 text-gray-500 text-left">Price</th>
                        <th class="p-4 text-gray-500 text-left">Description</th>
                        <th class="p-4 text-gray-500 text-right">Edit</th>
                    </tr>
                </thead>
                <tbody class="w-full divide-y divide-gray-200">
                    @foreach($books as $book)
                        <tr>
                            <td class="p-4 whitespce-nowrap">{{$book->id}}</td>
                            <td class="p-4 whitespce-nowrap">{{$book->title}}</td>
                            <td class="p-4 whitespace-nowrap">
                                <img class="w-12 h-9 rounded" src="{{Storage::url($book->image)}}" />
                            </td>
                            <td class="p-4 whitespace-nowrap">{{ $book->price }}</td>
                            <td class="p-4 whitespace-nowrap">{!! nl2br($book->description) !!}</td>
                            <td class="p-4 text-right text-sm">
                               <x-button class="bg-green-600" wire:click="showEditBookModal({{$book->id}})">編集</x-button> 
                               <x-button class="bg-red-400" wire:click="deleteBook({{$book->id}})">削除</x-button> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="m-2 p-2">{{$books->links()}}</div>
        </div>

        <x-confirmation-modal wire:model="liveModal">

            @if($editWork)
                <x-slot name="title"><h2 class="text-green-600">編集</h2></x-slot>
            @else
                <x-slot name="title"><h2 class="text-blue-600">登録</h2></x-slot>
            @endif
        <x-slot name="content">

            @if(Session()->has('message'))
                <h3 class="p-2 text-2xl text-green-600">{{session('message')}}</h3>
            @endif

            <form action="" enctype="multipart/form-data">

                <x-label for="title" value="Title"></x-label>
                <input type="text" class="block w-full bg-white border border-gyay-400 rounded-md" id="title" wire:model.lazy="title">
                @error('title') <span class="error text-red-400">{{$message}}</span>@enderror

                <x-label for="image" value="Book Image" class="mt-2"></x-label>
                @if($newImage)
                    Photo Preview:
                    <img src="{{$newImage->temporaryUrl()}}" class="w-48">
                @else
                    @if($oldImage)
                        <img src="{{Storage::url($oldImage)}}" class="w-48">
                    @endif
                @endif
                <input type="file" class="block w-full bg-white border border-gyay-400 rounded-md" id="image" 
                wire:model.lazy="newImage" accept="image/jpg, image/jpeg, image/png">
                @error('newImage') <span class="error text-red-400">{{$message}}</span>@enderror

                
                <x-label for="price" value="Price" class="mt-2"></x-label>
                <input type="number" class="block w-full bg-white border border-gyay-400 rounded-md"
                 id="price" wire:model.lazy="price">
                @error('price') <span class="error text-red-400">{{$message}}</span>@enderror
                
                <x-label for="description" value="Description" class="mt-2"></x-label>
                <textarea name="" class="block w-full bg-white border border-gyay-400 rounded-md"
                id="description" wire:model.lazy="description"></textarea>
                @error('description') <span class="error text-red-400">{{$message}}</span>@enderror
            </form>
        </x-slot>

        <x-slot name="footer">
            @if($editWork)
                <x-button wire:click="updateBook({{$id}})">編集実行</x-button>
            @else
                <x-button wire:click="bookPost">登録実行</x-button>
            @endif
        </x-slot>
    </x-confirmation-modal>
</div>
