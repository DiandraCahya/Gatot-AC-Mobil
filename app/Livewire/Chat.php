<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Booking;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Collection;

class Chat extends Component
{
    public $users;
    public $selectedUserId = null;
    public $selectedUser = null; 
    public $message = '';
    public $chatMessages;
    public $lastMessageId = 0;
    public $unreadMessages = [];
    public $showMobileUserList = true;
    public $showBookingModal = false;
    public $selectedBooking = null;
    public $showBookingMentions = false;
    public $bookingMentions = [];

    protected $listeners = [
        'showBookingDetails' => 'showBookingDetails'
    ];

    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    public function mount()
    {
        $this->chatMessages = collect([]);
        $this->loadUsers();
        $this->loadUnreadMessages();
    }

    public function markAsRead($messageId)
    {
        Message::where('id', $messageId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()->timezone('Asia/Jakarta')]);

    }

    public function showBookingDetails($bookingId)
    {
        $this->selectedBooking = Booking::find($bookingId);
        $this->showBookingModal = true;
    }


    public function loadUsers()
    {
        if (auth()->user()->is_admin) {
            $this->users = User::whereHas('sentMessages', function ($query) {
                $query->where('receiver_id', auth()->id());
            })
                ->where('is_admin', false)
                ->orderBy('name')
                ->get();
        } else {
            $this->users = User::where('is_admin', true)
                ->orderBy('name')
                ->get();
        }
    }

    public function loadUnreadMessages()
    {
        $this->unreadMessages = Message::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->groupBy('sender_id')
            ->selectRaw('sender_id, count(*) as count')
            ->pluck('count', 'sender_id')
            ->toArray();
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        $this->showMobileUserList = false;
        
        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->loadUnreadMessages();
        $this->loadMessages();
    }

    public function showUserList()
    {
        $this->showMobileUserList = true;
    }

    public function loadMessages()
    {
        if (!$this->selectedUserId) {
            $this->chatMessages = collect([]);
            return;
        }

        $this->chatMessages = Message::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $this->selectedUserId);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->selectedUserId)
                ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read when loaded
        Message::where('sender_id', $this->selectedUserId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($this->chatMessages->isNotEmpty()) {
            $this->lastMessageId = $this->chatMessages->last()->id;
        }

        $this->dispatch('scrollToBottom');
    }

    public function loadBookingMentions()
    {
        if (auth()->user()->is_admin) {
            $this->bookingMentions = Booking::where('user_id', $this->selectedUserId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'jenis' => $booking->jenis,
                        'tanggal' => $booking->tanggal,
                        'mobil' => $booking->mobil,
                        'status' => $booking->status
                    ];
                });
        } else {
            $this->bookingMentions = Booking::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'jenis' => $booking->jenis,
                        'tanggal' => $booking->tanggal,
                        'mobil' => $booking->mobil,
                        'status' => $booking->status
                    ];
                });
        }
    }

    public function hideBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedBooking = null;
    }

    public function insertBookingMention($bookingId, $jenis)
    {
        $mention = "@{$jenis}-{$bookingId}";
        
        if (empty($this->message)) {
            $this->message = $mention . ' ';
        } else {
            if (substr($this->message, -1) !== ' ') {
                $this->message .= ' ';
            }
            $this->message .= $mention . ' ';
        }

        $this->showBookingMentions = false;
    }

    public function toggleBookingSelector()
    {
        $this->loadBookingMentions();
        $this->showBookingMentions = !$this->showBookingMentions;
    }

    public function processMessage($message)
    {
        return preg_replace_callback(
            '/@([^-]+)-(\d+)/',
            function ($matches) {
                $jenis = $matches[1];
                $bookingId = $matches[2];
                return sprintf(
                    '<span wire:click="showBookingDetails(%d)" class="inline-flex items-center bg-blue-600/20 text-blue-400 px-1.5 py-0.5 rounded cursor-pointer hover:bg-blue-600/30 transition-colors">@%s</span>',
                    $bookingId,
                    $jenis
                );
            },
            htmlspecialchars($message)
        );
    }

    public function sendMessage()
    {
        if (!$this->selectedUserId || empty($this->message)) {
            return;
        }

        try {
            Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedUserId,
                'message' => $this->message,
                'created_at' => now()->timezone('Asia/Jakarta')
            ]);

            $this->message = '';
            $this->loadMessages();

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }

    public function getSelectedUserProperty()
    {
        return $this->selectedUserId ? User::find($this->selectedUserId) : null;
    }

    public function getListeners()
    {
        return [
            'echo-private:chat.' . auth()->id() . ',MessageSent' => 'notifyNewMessage',
            'checkNewMessages' => 'checkNewMessages'
        ];
    }

    public function checkNewMessages()
    {
        if (!$this->selectedUserId) return;

        $newMessages = Message::where(function ($query) {
            $query->where(function ($q) {
                $q->where('sender_id', auth()->id())
                    ->where('receiver_id', $this->selectedUserId);
            })->orWhere(function ($q) {
                $q->where('sender_id', $this->selectedUserId)
                    ->where('receiver_id', auth()->id());
            });
        })
        ->where('id', '>', $this->lastMessageId)
        ->get();

        if ($newMessages->count() > 0) {
            $this->loadMessages();
        }
    }

    public function notifyNewMessage($event)
    {
        $this->loadUnreadMessages();
        if ($this->selectedUserId == $event['message']['sender_id']) {
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.chat')->layout('layouts.app');
    }    
}