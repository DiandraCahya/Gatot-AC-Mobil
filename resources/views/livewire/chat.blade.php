<div class="h-screen bg-gray-900/60 backdrop-blur-sm">
    <div class="flex h-full">
        <!-- User List - Hidden on mobile when chat is open -->
        <div
            class="w-full md:w-96 bg-gray-800/60 overflow-hidden rounded-l-2xl {{ !$showMobileUserList ? 'hidden md:block' : '' }}">
            <div class="p-4 bg-gray-900/60 border-b border-gray-700/60">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-600/60 rounded-full flex items-center justify-center">
                        <span class="text-lg font-semibold text-gray-100">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                    <h2 class="ml-3 text-lg font-semibold text-gray-100">{{ auth()->user()->name }}</h2>
                </div>
            </div>
            <div class="overflow-y-auto h-[calc(100vh-72px)]">
                @foreach ($users as $user)
                    <div wire:click="selectUser({{ $user->id }})"
                        class="flex items-center p-4 hover:bg-gray-700/60 cursor-pointer border-b border-gray-700/60 {{ $selectedUserId === $user->id ? 'bg-gray-700/60' : '' }}">
                        <div class="w-12 h-12 bg-gray-600/60 rounded-full flex items-center justify-center">
                            <span class="text-lg font-semibold text-gray-100">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between items-center">
                                <h3 class="font-medium text-gray-100">{{ $user->name }}</h3>
                                @if (isset($unreadMessages[$user->id]) && $unreadMessages[$user->id] > 0)
                                    <span class="bg-emerald-500/60 text-gray-100 px-2 py-1 rounded-full text-xs">
                                        {{ $unreadMessages[$user->id] }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-400">Click to chat</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col rounded-r-2xl {{ $showMobileUserList ? 'hidden md:flex' : '' }}">
            @if ($selectedUserId)
                <!-- Chat Header -->
                <div class="p-4 bg-gray-800/60 border-b border-gray-700/60 rounded-tr-2xl flex items-center">
                    <button class="md:hidden mr-2 text-gray-100" wire:click="showUserList">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="flex items-center flex-1">
                        <div class="w-12 h-12 bg-gray-600/60 rounded-full flex items-center justify-center">
                            <span class="text-lg font-semibold text-gray-100">
                                {{ substr($selectedUser->name ?? '', 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-lg font-semibold text-gray-100">{{ $selectedUser->name ?? '' }}</h2>
                            <p class="text-sm text-gray-400">
                                @if ($this->selectedUser)
                                    {{ $this->selectedUser->email }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto bg-gray-900/60 p-4" id="chat-messages"wire:poll.5s="checkNewMessages">
                    @foreach ($chatMessages as $msg)
                        <div
                            class="flex mb-4 {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            @if ($msg->sender_id !== auth()->id())
                                <div class="w-8 h-8 bg-gray-600/60 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-sm font-semibold text-gray-100">
                                        {{ substr($selectedUser->name ?? '', 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div
                                class="max-w-[70%] break-words rounded-2xl px-4 py-2 {{ $msg->sender_id === auth()->id() ? 'bg-emerald-600/60 text-gray-100 rounded-br-none' : 'bg-gray-700/60 text-gray-100 rounded-bl-none' }}">
                                {!! $this->processMessage($msg->message) !!}
                                <div class="flex items-center justify-end gap-1 mt-1">
                                    <span class="text-xs text-gray-300">
                                        {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                    </span>
                                    @if ($msg->sender_id === auth()->id())
                                        <span class="text-xs">
                                            @if ($msg->read_at)
                                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7 M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Message Input -->
                <div class="bg-gray-800/60 p-4 border-t border-gray-700/60 rounded-br-2xl">
                    <div class="relative">
                        @if ($showBookingMentions)
                            <div
                                class="absolute bottom-full mb-2 w-full bg-gray-800/60 rounded-lg shadow-lg border border-gray-700/60 max-h-60 overflow-y-auto">
                                @foreach ($bookingMentions as $booking)
                                    <div wire:click="insertBookingMention({{ $booking['id'] }}, '{{ $booking['jenis'] }}')"
                                        class="p-2 hover:bg-gray-700/60 cursor-pointer text-gray-100">
                                        #{{ $booking['id'] }} - {{ $booking['jenis'] }}
                                        ({{ $booking['tanggal'] }})
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex items-center">
                            <button wire:click="toggleBookingSelector"
                                class="p-2 text-gray-300 hover:text-gray-100 rounded-full hover:bg-gray-700/60">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <input type="text" wire:model="message" wire:keydown.enter="sendMessage"
                                placeholder="Type a message"
                                class="flex-1 bg-gray-700/60 border-gray-600/60 border rounded-full py-2 px-4 mx-2 focus:outline-none focus:border-emerald-500/60 text-gray-100 placeholder-gray-400">
                            <button wire:click="sendMessage"
                                class="p-2 bg-emerald-600/60 text-gray-100 rounded-full hover:bg-emerald-500/60">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Chat Selected -->
                <div class="flex-1 flex items-center justify-center bg-gray-800/60 rounded-r-2xl">
                    <p class="text-gray-400">Select a chat to start messaging</p>
                </div>
            @endif
        </div>
    </div>


    @if ($showBookingModal && $selectedBooking)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 z-50">
            <div class="bg-gray-800/60 rounded-2xl max-w-4xl w-full p-6 border border-gray-700/60">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-100">Detail Pemesanan</h3>
                    <button wire:click="$set('showBookingModal', false)" class="text-gray-400 hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @if (auth()->user()->is_admin)
                        <!-- Informasi Pemohon Card - Only visible to admin -->
                        <div class="bg-gray-700/60 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-gray-300 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-100">Informasi Pemohon</h3>
                            </div>
                            <div class="space-y-4 text-gray-300">
                                <p><span class="font-semibold">Nama:</span> {{ $selectedBooking->user->name }}</p>
                                <p><span class="font-semibold">Email:</span> {{ $selectedBooking->user->email }}</p>
                                <p><span class="font-semibold">Telepon:</span> {{ $selectedBooking->user->nomor }}</p>
                                <p><span class="font-semibold">Alamat:</span> {{ $selectedBooking->user->alamat }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Informasi Pesanan Card -->
                    <div class="bg-gray-700/60 rounded-lg p-6 {{ !auth()->user()->is_admin ? 'lg:col-span-2' : '' }}">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-gray-300 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-100">Informasi Pesanan</h3>
                        </div>
                        <div class="space-y-4 text-gray-300">
                            <p>
                                <span class="font-semibold">Status:</span>
                                <span
                                    class="px-3 py-1 rounded-full text-white text-sm font-medium
                                {{ $selectedBooking->status === 'pending' ? 'bg-yellow-500/60' : '' }}
                                {{ $selectedBooking->status === 'approved' ? 'bg-emerald-500/60' : '' }}
                                {{ $selectedBooking->status === 'rejected' ? 'bg-red-500/60' : '' }}">
                                    {{ ucfirst($selectedBooking->status) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Jenis Layanan:</span> {{ $selectedBooking->jenis }}</p>
                            <p><span class="font-semibold">Tanggal:</span> {{ $selectedBooking->tanggal }}</p>
                            <p><span class="font-semibold">Jam:</span>
                                {{ date('H:i', strtotime($selectedBooking->jam)) }}</p>
                            <p><span class="font-semibold">Mobil:</span> {{ $selectedBooking->mobil }}</p>
                            <p><span class="font-semibold">Lokasi:</span>
                                {{ $selectedBooking->tempat ? 'Di Bengkel' : $selectedBooking->user->alamat }}</p>
                            @if ($selectedBooking->keterangan)
                                <p><span class="font-semibold">Keterangan:</span> {{ $selectedBooking->keterangan }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button wire:click="$set('showBookingModal', false)"
                        class="w-full md:w-auto px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Scripts -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollToBottom', () => {
            const chatMessages = document.getElementById('chat-messages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    });

    function loadBookingModal(route, bookingId) {
        Livewire.dispatch('showBookingDetails', {
            bookingId: bookingId
        });
    }
</script>
