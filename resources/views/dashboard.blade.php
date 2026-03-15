<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Real-Time Chat Dashboard') }}
        </h2>
    </x-slot>


    <div class="h-[calc(100vh-65px)] flex overflow-hidden font-sans" x-data="chatApp()" @open-chat.window="selectUser($event.detail.id, $event.detail.name)" x-cloak>
        

        <div class="w-full md:w-80 lg:w-[380px] flex-shrink-0 flex flex-col border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 transition-all duration-300 z-20">

            <div class="h-16 px-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md sticky top-0">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">Повідомлення</h3>
            </div>
            

            <div class="flex-1 overflow-y-auto w-full pb-4 pt-2 px-3 no-scrollbar scroll-smooth">
                <ul class="space-y-1">
                    @forelse($users as $user)
                    <li>
                        <button class="w-full text-left p-3 rounded-2xl flex items-center justify-between transition-all duration-200 group border border-transparent outline-none focus:ring-2 focus:ring-indigo-500/50"
                            :class="activeUserId === {{ $user->id }} ? 'bg-blue-50 dark:bg-indigo-900/30' : 'hover:bg-gray-50 dark:hover:bg-gray-800/80'"
                            @click="selectUser({{ $user->id }}, '{{ addslashes($user->name) }}')">
                            
                            <div class="flex items-center space-x-3 1.5 overflow-hidden">
                                <div class="relative flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-sm transition-transform duration-300 group-hover:scale-105"
                                        :class="activeUserId === {{ $user->id }} ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : 'bg-gradient-to-br from-gray-400 to-gray-500 dark:from-gray-600 dark:to-gray-700'">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></span>
                                </div>
                                <div class="flex-1 min-w-0 pr-2">
                                    <p class="text-[15px] font-semibold text-gray-900 dark:text-gray-100 truncate" :class="activeUserId === {{ $user->id }} ? 'dark:text-white' : ''">{{ $user->name }}</p>
                                    <p class="text-[13px] text-gray-500 dark:text-gray-400 font-medium truncate mt-0.5" :class="activeUserId === {{ $user->id }} ? 'text-indigo-600 dark:text-indigo-400' : ''">
                                        {{ $user->roles->pluck('name')->first() ?: 'Користувач' }}
                                    </p>
                                </div>
                            </div>
                            
                            @role('admin')
                            <a href="{{ route('impersonate', $user->id) }}"
                               title="Увійти як {{ $user->name }}"
                               class="flex-shrink-0 p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/20 rounded-full transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100 outline-none"
                               @click.stop>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                            </a>
                            @endrole
                        </button>
                    </li>
                    @empty
                    <li class="p-8 mt-10 flex flex-col items-center text-center text-gray-400 dark:text-gray-500">
                        <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <p class="font-medium text-gray-500 dark:text-gray-400">Список контактів порожній</p>
                        <p class="text-sm mt-1">Тут з'являться ваші чати</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>


        <div class="flex-1 flex flex-col bg-[#F3F4F6] dark:bg-[#0B1120] relative max-w-full overflow-hidden">
            

            <div x-show="!activeUserId" class="flex-1 flex flex-col items-center justify-center text-gray-500 p-8 text-center"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="w-24 h-24 mb-6 rounded-3xl bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none flex items-center justify-center transform -rotate-6">
                    <svg class="w-12 h-12 text-indigo-500 dark:text-indigo-400 transform rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Ваші повідомлення</h3>
                <p class="text-base text-gray-500 dark:text-gray-400 max-w-sm">Виберіть контакт зі списку ліворуч, щоб почати безпечне спілкування в реальному часі.</p>
            </div>


            <div x-show="activeUserId" class="flex-1 flex flex-col h-full overflow-hidden w-full relative" style="display: none;">
                

                <div class="h-16 px-4 sm:px-6 border-b border-gray-200/50 dark:border-gray-800/80 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl flex items-center justify-between sticky top-0 z-20 shadow-sm">
                    <div class="flex items-center space-x-3 sm:space-x-4 cursor-pointer group">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-md transition-transform group-hover:scale-105" x-text="activeUserName ? activeUserName.charAt(0) : ''"></div>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-base sm:text-[17px] font-bold text-gray-900 dark:text-white leading-tight" x-text="activeUserName"></h3>
                            <div class="flex items-center space-x-1.5 mt-0.5">
                                <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]"></span>
                                <span class="text-[12px] font-medium text-gray-500 dark:text-gray-400">В мережі</span>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.02] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div id="messages-container" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-6 scroll-smooth z-10 w-full relative">


                    <div x-show="isLoading" class="flex justify-center py-6">
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm flex items-center space-x-3">
                            <div class="relative w-5 h-5">
                                <div class="absolute inset-0 rounded-full border-2 border-gray-200 dark:border-gray-600"></div>
                                <div class="absolute inset-0 rounded-full border-2 border-indigo-600 border-t-transparent animate-spin"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Завантаження...</span>
                        </div>
                    </div>


                    <div x-show="!isLoading && messages.length === 0" class="flex flex-col justify-center items-center h-full pb-10">
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-6 py-5 rounded-3xl text-center shadow-sm border border-gray-100 dark:border-gray-700 max-w-xs">
                            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-3 text-indigo-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>
                            </div>
                            <p class="text-[15px] font-semibold text-gray-800 dark:text-gray-200">Початок розмови</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 leading-relaxed">Всі повідомлення тимчасово зберігаються та передаються в реальному часі.</p>
                        </div>
                    </div>


                    <div class="flex flex-col justify-end min-h-full space-y-4 lg:space-y-5 pb-2">
                        <template x-for="(msg, index) in messages" :key="msg.id || index">
                            <div x-show="msg" class="flex w-full" :class="isMe(msg) ? 'justify-end' : 'justify-start'"
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                
                                <div class="flex max-w-[85%] md:max-w-[75%] lg:max-w-[65%]" :class="isMe(msg) ? 'flex-row-reverse' : 'flex-row'">
                                    

                                    <template x-if="!isMe(msg)">
                                        <div class="flex-shrink-0 mr-3 mt-auto hidden sm:block">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white text-[10px] font-bold shadow-sm" x-text="activeUserName ? activeUserName.charAt(0) : ''"></div>
                                        </div>
                                    </template>

                                    <div class="relative group flex flex-col" :class="isMe(msg) ? 'items-end' : 'items-start'">
                                        <div class="px-4 py-2.5 sm:px-5 sm:py-3 text-[15px] shadow-sm transition-all"
                                             style="word-break: break-word;"
                                             :class="isMe(msg) 
                                                ? 'bg-gradient-to-br from-indigo-600 to-blue-600 text-white rounded-[20px] rounded-br-[4px]' 
                                                : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-[20px] rounded-bl-[4px] border border-gray-100 dark:border-gray-700/60'">
                                            <p x-html="msg.text.replace(/\n/g, '<br>')" class="leading-relaxed"></p>
                                        </div>
                                        

                                        <div class="flex items-center text-[11px] mt-1.5 px-1 font-medium text-gray-400 dark:text-gray-500 select-none">
                                            <span x-text="msg.created_at_human"></span>

                                            <template x-if="isMe(msg)">
                                                <svg class="w-3.5 h-3.5 ml-1 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>


                <div class="px-4 py-4 sm:px-6 sm:py-5 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-800 z-20">
                    <form @submit.prevent="sendMessage" class="flex items-end space-x-2 sm:space-x-3 max-w-5xl mx-auto relative">
                        

                        
                        <div class="relative flex-1 bg-[#F3F4F6] dark:bg-gray-800 rounded-3xl border border-transparent focus-within:border-indigo-300 dark:focus-within:border-indigo-700/50 focus-within:ring-4 focus-within:ring-indigo-100/50 dark:focus-within:ring-indigo-900/20 transition-all shadow-inner shadow-gray-200/20 dark:shadow-none flex items-center group">
                            <textarea x-model="newMessage" x-ref="messageInput" required rows="1"
                                @keydown.enter.prevent="sendMessage"
                                class="w-full bg-transparent border-none text-gray-900 dark:text-white text-[15px] resize-none focus:ring-0 py-3.5 pl-5 pr-5 max-h-32 rounded-3xl no-scrollbar placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Напишіть повідомлення..." :disabled="isSending"
                                oninput="this.style.height = 'auto'; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"></textarea>
                        </div>

                        <button type="submit" :disabled="isSending || !newMessage.trim()"
                            class="inline-flex items-center justify-center w-[50px] h-[50px] rounded-full bg-gradient-to-tr from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white shadow-lg shadow-indigo-200/50 dark:shadow-none disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105 active:scale-95 flex-shrink-0 focus:outline-none focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-900/50 border border-indigo-400/50 dark:border-none">
                            <template x-if="!isSending">
                                <svg class="w-5 h-5 translate-x-0.5 -translate-y-0.5 transform rotate-45" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                            </template>
                            <template x-if="isSending">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chatApp', () => ({
                currentUserId: {{ auth()->id() }},
                activeUserId: null,
                activeUserName: '',
                messages: [],
                newMessage: '',
                isSending: false,
                isLoading: false,
                audio: new Audio('/sounds/notification.mp3'),

                init() {
                    // Restore active user from localStorage
                    const savedUserId = localStorage.getItem('activeUserId');
                    const savedUserName = localStorage.getItem('activeUserName');
                    
                    if (savedUserId && savedUserName) {
                        this.selectUser(parseInt(savedUserId), savedUserName);
                    }

                    // Fetch offline unread messages first
                    this.fetchUnreadMessages();

                    // Initialize Laravel Echo listener on the current user's private channel
                    if (window.Echo) {
                        window.Echo.private(`user.${this.currentUserId}`)
                            .listen('MessageSent', (e) => {
                                if (!e.message) return;

                                const isIncoming = e.message.sender_id !== this.currentUserId;
                                if (isIncoming) {
                                    this.playSound();
                                }

                                const isFromActiveUser = this.activeUserId === e.message.sender_id;
                                const isToActiveUser = this.activeUserId === e.message.receiver_id;

                                // If the message is part of the current conversation
                                if (isFromActiveUser || isToActiveUser) {
                                    // Prevent duplicates
                                    if (!this.messages.find(m => m.id === e.message.id)) {
                                        this.messages.push(e.message);
                                        this.scrollToBottom();

                                        if (isFromActiveUser) {
                                            this.notify(e.message);
                                        }
                                    }
                                } else {
                                    // Notification for message from someone else
                                    this.notify(e.message);
                                    // Update the bell icon since we have a new unread message
                                    this.updateUnreadCountSilently();
                                }
                            });
                    }
                },

                fetchUnreadMessages() {
                    axios.get('/messages/unread')
                        .then(response => {
                            const unreadMsgs = Array.isArray(response.data.data) ? response.data.data : [];
                            
                            // Dispatch event to update bell icon
                            const sendersList = this.processUnreadData(unreadMsgs);
                            window.dispatchEvent(new CustomEvent('unread-updated', { detail: { count: unreadMsgs.length, senders: sendersList } }));

                            if (unreadMsgs.length > 0) {
                                // Group by sender for a cleaner notification, or just show them sequentially.
                                // We reverse to show oldest first.
                                const showNotifications = () => {
                                    if (!window.Notyf) {
                                        // Wait 100ms if Notyf isn't loaded yet
                                        setTimeout(showNotifications, 100);
                                        return;
                                    }
                                    
                                    [...unreadMsgs].reverse().forEach((msg, index) => {
                                        setTimeout(() => {
                                            window.Notyf.success({
                                                message: `<b>${msg.sender_name} (Офлайн)</b>: ${msg.text}`,
                                                ripple: true,
                                                dismissible: true,
                                                duration: 7000 + (index * 500)
                                            });
                                            this.playSound();
                                        }, index * 1000); 
                                    });
                                };
                                
                                showNotifications();
                            }
                        })
                        .catch(error => console.error('Error fetching unread messages:', error));
                },

                playSound() {
                    if (this.audio) {
                        this.audio.currentTime = 0;
                        this.audio.play().catch(e => console.log('Audio autoplay prevented:', e));
                    }
                },

                notify(message) {
                    if (window.Notyf) {
                        window.Notyf.success({
                            message: `<b>${message.sender_name}</b>: ${message.text}`,
                            ripple: true,
                            dismissible: true
                        });
                    }
                },

                selectUser(id, name) {
                    if (this.activeUserId === id) return;
                    this.activeUserId = id;
                    this.activeUserName = name;
                    
                    // Persist to localStorage
                    localStorage.setItem('activeUserId', id);
                    localStorage.setItem('activeUserName', name);
                    
                    this.messages = [];
                    this.fetchMessages();
                    this.$nextTick(() => this.$refs.messageInput?.focus());
                },

                fetchMessages() {
                    if (!this.activeUserId) return;

                    this.isLoading = true;
                    axios.get(`/messages/${this.activeUserId}`)
                        .then(response => {
                            this.messages = Array.isArray(response.data.data) ? response.data.data : [];
                            this.scrollToBottom();
                            // Re-fetch global unread count to update the bell after opening a chat
                            this.updateUnreadCountSilently();
                        })
                        .catch(error => {
                            console.error('Error fetching messages:', error);
                            this.messages = [];
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                },

                updateUnreadCountSilently() {
                     axios.get('/messages/unread')
                        .then(response => {
                            const unreadMsgs = Array.isArray(response.data.data) ? response.data.data : [];
                            const sendersList = this.processUnreadData(unreadMsgs);
                            window.dispatchEvent(new CustomEvent('unread-updated', { detail: { count: unreadMsgs.length, senders: sendersList } }));
                        })
                        .catch(() => {});
                },

                processUnreadData(unreadMsgs) {
                    const sendersMap = new Map();
                    unreadMsgs.forEach(msg => {
                        if (!sendersMap.has(msg.sender_id)) {
                            sendersMap.set(msg.sender_id, { 
                                id: msg.sender_id, 
                                name: msg.sender_name, 
                                count: 1, 
                                text: msg.text, 
                                time: msg.created_at_human 
                            });
                        } else {
                            sendersMap.get(msg.sender_id).count++;
                        }
                    });
                    return Array.from(sendersMap.values());
                },

                sendMessage() {
                    const text = this.newMessage.trim();
                    if (!text || !this.activeUserId || this.isSending) return;

                    this.newMessage = '';
                    this.isSending = true;

                    axios.post('/messages', {
                        receiver_id: this.activeUserId,
                        text: text
                    })
                    .then(response => {
                        const newMsg = response.data.data;
                        if (!this.messages.find(m => m.id === newMsg.id)) {
                            this.messages.push(newMsg);
                            this.scrollToBottom();
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        this.newMessage = text;
                        if (window.Notyf) window.Notyf.error('Не вдалося надіслати повідомлення.');
                    })
                    .finally(() => {
                        this.isSending = false;
                        this.$nextTick(() => this.$refs.messageInput?.focus());
                    });
                },

                isMe(message) {
                    return message.sender_id === this.currentUserId;
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        setTimeout(() => {
                            const container = document.getElementById('messages-container');
                            if (container) {
                                container.scrollTo({
                                    top: container.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        }, 100);
                    });
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
