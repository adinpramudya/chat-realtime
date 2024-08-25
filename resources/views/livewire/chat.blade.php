  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                  <div wire:poll>
                      @foreach ($messages as $message)
                          <div class="chat mb-5 @if ($message->from_user_id == auth()->id()) chat-end @else chat-start @endif">
                              <div class="chat-image avatar">
                                  <div class="w-10 rounded-full">
                                   @if($message->from_user_id==auth()->user()->profile_photo_path || $message->to_user_id==auth()->user()->profile_photo_path)
                                          <img alt="Profile Photo"
                                               src="{{asset('storage/' .auth()->user()->profile_photo_path)}}" />
                                      @else

                                       @if($message->fromUser->profile_photo_path)
                                              <img alt="Profile Photo"
                                                   src="{{asset('storage/' .$message->fromUser->profile_photo_path)}}" />
                                          @else
                                              <img alt="default Photo"
                                                   src="{{asset('images/default-profile.png')}}" />

                                       @endif

                                   @endif
                                  </div>
                              </div>
                              <div class="chat-header">
                                  {{ $message->fromUser->name }}
                                  <time class="text-xs opacity-50">{{ $message->created_at->diffForHumans() }}</time>
                              </div>
                              <div class="chat-bubble">{{ $message->message }}</div>
                              <div class="chat-footer opacity-50 mt-2">
                                  @if ($message->status == 'pending' && $message->from_user_id == auth()->id())
                                      <i class="material-icons">schedule</i>Pending
                                  @elseif ($message->status == 'sent'&& $message->from_user_id == auth()->id())
                                      <div class="flex">
                                          <div class="bg-blue-900 w-5 h-5 rounded-full text-sm flex items-center justify-center mr-2">D</div>
                                          <p>Terkirim</p>
                                      </div>
                                  @elseif ($message->status == 'read'&& $message->from_user_id == auth()->id())
                                      <div class="flex">
                                          <div class="bg-green-900 w-5 h-5 rounded-full text-sm flex items-center justify-center mr-2">R</div>
                                          <p>Sudah dibaca</p>

                                      </div>
                                  @endif
                              </div>
                          </div>
                      @endforeach

                  </div>
                  <div class="form-control">
                      <form action="" wire:submit.prevent="sendMessage">
                          <textarea class="textarea textarea-bordered w-full" wire:model="message" placeholder="send your message..."></textarea>
                          <button class="btn btn-primary" type="submit">Send</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
