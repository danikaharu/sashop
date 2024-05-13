<style>
    .chat-container {
        max-height: 400px;
        /* Menetapkan tinggi maksimum */
        overflow-y: auto;
        /* Munculkan scrollbar saat konten melebihi tinggi maksimum */
    }

    .chat-box {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 10px;
        width: 80%;
        /* Menggunakan 80% lebar div parent */
        position: relative;
    }

    .user-chat {
        background-color: #c1e2b3;
        align-self: flex-start;
    }

    .admin-chat {
        background-color: #d4edda;
        align-self: flex-end;
        margin-left: auto;
    }

    .chat-form {
        margin-top: 20px;
    }

    .chat-time {
        font-size: 12px;
        color: #888;
        position: absolute;
        bottom: 5px;
        right: 10px;
    }
</style>


<div class="col-lg-12 col-md-7 col-sm-12">
    <div class="order_box">
        <h2 class="mb-4">Chat {{ $user->name }}</h2>
        <div id="chat-box" class="chat-container">
            <!-- Chat messages -->
            {{-- @foreach ($msg as $item)
                @if ($item->isAdmin)
                    <div class="chat-box admin-chat">
                        {{ $item->msg }}
                        <span class="chat-time">{{ $item->date }}</span>
                    </div>
                @else
                    <div class="chat-box user-chat">
                        {{ $item->msg }}
                        <span class="chat-time">{{ $item->date }}</span>
                    </div>
                @endif
            @endforeach --}}
        </div>
        <form id="chat-form" class="chat-form" action="{{ route('chat.post', $user->id) }}" method="POST">
            @csrf <!-- CSRF Token -->
            <div class="form-group">
                <textarea class="form-control" id="message" name="msg" placeholder="Ketik pesan Anda..." rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
    </div>
</div>

<script>
    // JavaScript code
    function reloadPage() {
        location.reload(); // Reload the current page
    }

    function fetchMessages() {
        fetch('{{ route('chat.id', $user->id) }}')
            .then(response => response.json())
            .then(data => {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = ''; // Clear the chat-box content before adding new messages
                data.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-box');
                    if (message.isAdmin) {
                        messageDiv.classList.add('admin-chat');
                    } else {
                        messageDiv.classList.add('user-chat');
                    }
                    messageDiv.textContent = message.msg;
                    const chatTime = document.createElement('span');
                    chatTime.classList.add('chat-time');
                    chatTime.textContent = message.date;
                    messageDiv.appendChild(chatTime);
                    chatBox.appendChild(messageDiv);
                });

            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Load messages when the page is initially loaded
    fetchMessages();

    // Reload messages every 5 seconds
    setInterval(fetchMessages, 1000); // Adjust the interval as needed (in milliseconds)

    // Submit form using AJAX
    document.getElementById('chat-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission behavior

        const formData = new FormData(this); // Get form data
        const userId = {{ $user->id }}; // Get user ID from Blade template
        formData.append('user_id', userId); // Append user ID to form data

        fetch(this.action, {
                method: this.method,
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message sent:', data);
                fetchMessages(); // Fetch messages after successful submission
                document.getElementById('message').value = '';
            })
            .catch(error => console.error('Error sending message:', error));
    });
</script>
