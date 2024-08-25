<div>
   <form wire:submit.prevent="savePhoto">
       @if(session()->has('message'))
           <div class="mb-4 p-2 text-green-700 bg-green-200 border border-green-600 rounded">
               {{session('message')}}
           </div>
       @endif

       <div class="mb-4">
           <input type="file" wire:model="photo" class="form-input">
           @error('photo')<span class="text-red-500">{{$message}}</span> @enderror
       </div>

       <button type="submit" class="btn btn-primary">Upload Photo</button>
   </form>
</div>
