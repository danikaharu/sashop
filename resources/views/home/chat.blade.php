@extends('layouts.homelayout')
@section('content')
    <style>
        .chat-container {
            height: 400px;
            overflow-y: scroll;
        }

        .chat-box {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%;
            position: relative;
        }

        .user-chat {
            background-color: #c1e2b3;

            align-self: flex-start;
        }

        .admin-chat {
            background-color: #d4edda;

            align-self: flex-end;
            /* Memindahkan pesan admin ke sebelah kanan */
            margin-left: auto;
            /* Menempatkan pesan admin ke kanan */
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

    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Chat Admin</h2>
                    </div>
                    <div class="page_link">
                        <a href="index.html">Home</a>
                        <a href="checkout.html">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-12 col-md-7 col-sm-12">
                        <div class="order_box">
                            <h2 class="mb-4">Chat Kamu</h2>
                            <button onclick="reloadPage()" class="btn btn-primary mb-3">
                                <i class="fas fa-sync-alt"></i> <!-- Refresh Icon -->
                            </button>
                            <div id="chat-box" class="chat-container">
                                <!-- Container to display messages -->
                            </div>
                            @auth
                                <form id="chat-form" class="chat-form" action="{{ route('chat.post', Auth::user()->id) }}" method="POST">
                                    @csrf <!-- CSRF Token -->
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" name="msg" placeholder="Ketik pesan Anda..." rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="send-message">Kirim Pesan</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function reloadPage() {
            location.reload(); // Reload the current page
        }

        function fetchMessages() {
            fetch('/chat-user')
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
        setInterval(fetchMessages, 1000);

        document.getElementById('chat-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this); // Collect form data
            const userId = {{ Auth::user()->id }}; // Get the ID of the logged-in user
            formData.append('user_id', userId); // Add the user ID to the form data

            fetch('{{ route('chat.post', Auth::user()->id) }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message sent:', data);
                // Fetch and display messages after sending a new message
                fetchMessages();
                document.getElementById('message').value = '';
            })
            .catch(error => console.error('Error sending message:', error));
        });
    </script>

    <!--================End Checkout Area =================-->
@endsection
