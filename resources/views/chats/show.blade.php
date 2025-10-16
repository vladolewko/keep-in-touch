<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.settings') }}
        </h2>
    </x-slot>
<div class="chat-container max-w-2xl mx-auto mt-10 p-4 border rounded-lg shadow-lg flex flex-col h-[70vh]">
    <div class="participants border-b pb-2 mb-4">
        <p class="font-bold">Зараз в чаті:</p>
        <ul id="online-users" class="flex space-x-2 text-sm text-gray-600">
        </ul>
    </div>

    <div id="messages-container" class="flex-grow overflow-y-auto space-y-4 pr-4">
        @foreach($messages as $message)
            <div class="flex {{$message->user_id === auth()->id() ? 'justify-end' : 'justify-start'}}">
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-xl {{$message->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}}">
                    <p class="text-sm">{{ $message->body }}</p>
                    <p class="text-xs text-right opacity-70 mt-1">{{ $message->created_at->format('H:i') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 pt-4 border-t">
        <form id="message-form" class="flex space-x-3">
            <input type="text"
                id="message-input"
                placeholder="Type your message..."
                autocomplete="off"
                class="flex-grow border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
            <button type="submit" class="bg-blue-500 text-white rounded-full px-5 py-2 hover:bg-blue-600">
                Send
            </button>
        </form>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const conversationId = {{ $conversation->id }};
            const currentUserId = {{ auth()->id() }};
            const onlineUsersList = document.getElementById('online-users');
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');

            function updateOnlineList(users) {
                let html = '';
                const otherUsers = users.filter(user => user.id !== currentUserId);

                otherUsers.forEach(user => {
                    html += `<li id="user-${user.id}" class="px-2 py-1 bg-green-100 text-green-800 rounded-full">${user.name}</li>`;
                });
                onlineUsersList.innerHTML = html;
            }

            function appendMessage(message) {
                const isMyMessage = message.user_id === currentUserId;
                const messageHtml = `
                <div class="flex ${isMyMessage ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-xl ${isMyMessage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}">
                        <p class="text-sm">${message.body}</p>
                        <p class="text-xs text-right opacity-70 mt-1">${new Date(message.created_at).toLocaleTimeString('uk-UA', { hour: '2-digit', minute: '2-digit' })}</p>
                    </div>
                </div>
            `;
                messagesContainer.innerHTML += messageHtml;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            messageForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const messageText = messageInput.value;
                if (!messageText) return;

                fetch(`/chat/send/{{ $conversation->id }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ body: messageText })
                })
                    .then(response => response.json())
                    .then(message => {
                        appendMessage(message);
                        messageInput.value = '';
                    })
                    .catch(error => console.error('Error sending message:', error));
            });

            window.Echo.join(`chat.${conversationId}`)
                  .here((users) => {
                      updateOnlineList(users);
                  })
                  .joining((user) => {
                      if (user.id !== currentUserId) {
                          const li = document.createElement('li');
                          li.id = `user-${user.id}`;
                          li.className = 'px-2 py-1 bg-green-100 text-green-800 rounded-full';
                          li.innerText = user.name;
                          onlineUsersList.appendChild(li);
                      }
                  })
                  .leaving((user) => {
                      const userElement = document.getElementById(`user-${user.id}`);
                      if (userElement) userElement.remove();
                  })
                  .listen('.new-message', (e) => {
                      appendMessage(e.message);
                  })
                  .error((error) => {
                      console.error('Connection Error:', error);
                  });
        });
    </script>
</x-app-layout>
