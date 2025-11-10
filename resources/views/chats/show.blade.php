<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- {{ __('navigation.settings') }} --}}
            <!-- {{ __('Чат з') }} {{ $conversation->participants->where('id', '!=', auth()->id())->first()->nickname ?? 'User' }} -->
              {{ __('chat.show.title_prefix') }} {{ $conversation->participants->where('id', '!=', auth()->id())->first()->nickname ?? 'User' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="chat-container p-4 sm:p-6 flex flex-col h-[75vh]">

                    <div class="participants border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                        <p class="font-bold text-gray-900 dark:text-gray-200">{{ __('chat.show.online_users_title') }}</p>
                        <ul id="online-users"
                            class="flex flex-wrap space-x-2 text-sm text-gray-600 mt-2">
                        </ul>
                    </div>

                    <div id="messages-container"
                        class="flex-grow overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}"
                                data-message-id="{{ $message->id }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-xl {{ $message->user_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100' }}">
                                    <p class="text-sm" style="word-break: break-word;">{{ $message->body }}</p>
                                    <div class="flex items-center justify-end mt-1 space-x-1">
                                        <p class="text-xs opacity-80 {{ $message->user_id === auth()->id() ? 'text-blue-100' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $message->created_at->format('H:i') }}
                                        </p>
                                        @if ($message->user_id === auth()->id())
                                            <span class="read-status">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    height="16px"
                                                    viewBox="0 -960 960 960"
                                                    width="16px"
                                                    fill="{{ $message->read_at ? '#34D399' : '#9CA3AF' }}">
                                                    <path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <form id="message-form"
                            class="flex space-x-3">
                            <input type="text"
                                id="message-input"
                                placeholder="{{ __('chat.show.message_placeholder') }}"
                                autocomplete="off"
                                class="flex-grow border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:placeholder-gray-400"
                                required>
                            <button type="submit"
                                class="bg-blue-600 text-white rounded-full px-5 py-2 hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M120-160v-320l320-80-320-80v-320l760 400L120-160Z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="online-user-template">
        <li id="user-__USER_ID__" class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full text-xs font-medium">
            __USER_NAME__
        </li>
    </template>

    <template id="message-template">
        <div class="flex __FLEX_JUSTIFY__" data-message-id="__MESSAGE_ID__">
            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-xl __BUBBLE_CLASSES__">
                <p class="text-sm" style="word-break: break-word;">__MESSAGE_BODY__</p>
                <div class="flex items-center justify-end mt-1 space-x-1">
                    <p class="text-xs opacity-80 __TIME_CLASSES__">
                        __TIME__
                    </p>
                    __READ_STATUS_HTML__
                </div>
            </div>
        </div>
    </template>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* gray-300 */
            border-radius: 4px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563; /* gray-600 */
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* gray-400 */
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #374151; /* gray-700 */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const conversationId = {{ $conversation->id }};
            const currentUserId = {{ auth()->id() }};
            const onlineUsersList = document.getElementById('online-users');
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');

            // Отримуємо HTML з наших нових шаблонів
            const userTemplate = document.getElementById('online-user-template').innerHTML;
            const messageTemplate = document.getElementById('message-template').innerHTML;

            // Нова функція для додавання користувача за шаблоном
            function appendOnlineUser(user) {
                const userHtml = userTemplate
                    .replace('__USER_ID__', user.id)
                    .replace('__USER_NAME__', user.nickname); // Використовуємо nickname
                onlineUsersList.innerHTML += userHtml;
            }

            function updateOnlineList(users) {
                onlineUsersList.innerHTML = ''; // Очищуємо список
                const otherUsers = users.filter(user => user.id !== currentUserId);
                otherUsers.forEach(user => {
                    appendOnlineUser(user); // Додаємо кожного за шаблоном
                });
            }

            function markMessagesAsRead() {
                fetch(`/chat/{{ $conversation->id }}/read`, {
                    method  : 'PATCH',
                    headers : {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Socket-ID'  : window.Echo.socketId()
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Оновлення загального лічильника непрочитаних (якщо він є в 'x-app-layout')
                    const badge = document.getElementById('total-unread-badge');
                    if (badge) {
                        if (data.total_unread > 0) {
                            badge.innerText = data.total_unread;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error marking messages as read:', error));
            }

            // Викликаємо одразу при завантаженні
            markMessagesAsRead();

            // Нова функція для додавання повідомлення за шаблоном
            function appendMessage(message) {
                const isMyMessage = message.user_id === currentUserId;

                const justifyClass = isMyMessage ? 'justify-end' : 'justify-start';
                const bubbleClasses = isMyMessage
                    ? 'bg-blue-600 text-white'
                    : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100';
                const timeClasses = isMyMessage
                    ? 'text-blue-100'
                    : 'text-gray-500 dark:text-gray-400';

                const readStatusHtml = isMyMessage ? `
                    <span class="read-status">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#9CA3AF">
                            <path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/>
                        </svg>
                    </span>
                ` : '';

                // Функція для екранування HTML
                const escapeHTML = (str) => str.replace(/[&<>"']/g, (match) => {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;'
                    }[match];
                });

                const messageHtml = messageTemplate
                    .replace('__FLEX_JUSTIFY__', justifyClass)
                    .replace('__MESSAGE_ID__', message.id)
                    .replace('__BUBBLE_CLASSES__', bubbleClasses)
                    .replace('__MESSAGE_BODY__', escapeHTML(message.body)) // Важливо! Екранування XSS
                    .replace('__TIME_CLASSES__', timeClasses)
                    .replace('__TIME__', new Date(message.created_at).toLocaleTimeString('uk-UA', { hour: '2-digit', minute: '2-digit' }))
                    .replace('__READ_STATUS_HTML__', readStatusHtml);

                messagesContainer.innerHTML += messageHtml;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Прокрутка донизу при завантаженні
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            messageForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const messageText = messageInput.value.trim(); // Додано .trim()
                if (!messageText) {
                    return;
                }

                // Оптимістичне додавання повідомлення (тимчасове)
                const tempId = 'temp_' + Date.now();
                const optimisticMessage = {
                    id: tempId,
                    user_id: currentUserId,
                    body: messageText,
                    created_at: new Date().toISOString(),
                };
                // appendMessage(optimisticMessage); // Можна ввімкнути для "миттєвої" відправки

                messageInput.value = ''; // Очищуємо поле одразу

                fetch(`/chat/send/{{ $conversation->id }}`, {
                    method  : 'POST',
                    headers : {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Socket-ID'  : window.Echo.socketId()
                    },
                    body    : JSON.stringify({ body: messageText })
                })
                .then(response => response.json())
                .then(message => {
                    // Якщо ми використовували оптимістичне додавання,
                    // нам треба знайти 'temp_' повідомлення і замінити його ID.
                    // Але простіше просто додати реальне повідомлення з сервера,
                    // якщо не було оптимістичного додавання.

                    // Видаляємо оптимістичне, якщо воно було
                    const tempMsg = document.querySelector(`[data-message-id="${tempId}"]`);
                    if (tempMsg) tempMsg.remove();

                    // Додаємо справжнє повідомлення з сервера
                    appendMessage(message);
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    // Тут можна обробити помилку, наприклад,
                    // показати "не вдалося відправити" біля 'temp_' повідомлення.
                    messageInput.value = messageText; // Повертаємо текст
                });
            });

            window.Echo.join(`chat.${conversationId}`)
                  .here((users) => {
                      updateOnlineList(users);
                  })
                  .joining((user) => {
                      // Використовуємо ту ж логіку, що й у 'here'
                      if (user.id !== currentUserId) {
                          appendOnlineUser(user);
                      }
                  })
                  .leaving((user) => {
                      const userElement = document.getElementById(`user-${user.id}`);
                      if (userElement) {
                          userElement.remove();
                      }
                  })
                  .listen('.new-message', (e) => {
                      // Перевіряємо, чи це не наше власне повідомлення
                      // (на випадок, якщо сервер транслює і автору)
                      if (e.message.user_id !== currentUserId) {
                        appendMessage(e.message);
                        markMessagesAsRead();
                      }
                  })
                  .listen('.messages-read', (e) => {
                      // Оновлюємо галочки на "прочитані"
                      const unreadStatuses = document.querySelectorAll('.read-status svg[fill="#9CA3AF"]');
                      unreadStatuses.forEach(svg => {
                          svg.setAttribute('fill', '#34D399'); // Зелений колір
                      });
                  })
                  .error((error) => {
                      console.error('Connection Error:', error);
                  });
        });
    </script>
</x-app-layout>
