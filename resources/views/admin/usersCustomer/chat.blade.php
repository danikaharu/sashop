@extends('layouts.main')
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
            margin-left: auto;
        }

        .chat-time {
            font-size: 12px;
            color: #888;
            position: absolute;
            bottom: 5px;
            right: 10px;
        }

        .card-list {
            height: 300px;
            overflow-y: auto;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chat Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="checkout_area section_gap">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 user-column">
                        <h2 class="mb-4">Daftar Chat</h2>
                        <div class="card-list">
                            @foreach ($msg as $item)
                                <div class="card mb-3" style="cursor: pointer;" onclick="showChat({{ $item->user->id }})">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->user->name }}</h5>
                                        <p class="card-text">Pesan: {{ $item->msg }}</p>
                                        <p class="card-text">Date: {{ $item->date }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-8 chat-column">
                        <div id="chat-box-detail"><!-- chat detail load here --></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        var lastClickedUserId = null;
        var fetchInterval = null;

        function showChat(userId) {
            if (userId === lastClickedUserId) return;

            // hentikan polling lama
            if (fetchInterval) clearInterval(fetchInterval);

            $.ajax({
                type: 'GET',
                url: '/admin/detail/' + userId,
                success: function(response) {
                    $('#chat-box-detail').html(response);
                    lastClickedUserId = userId;

                    // mulai polling utk user ini
                    startPolling(userId);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function startPolling(userId) {
            fetchMessages(userId); // ambil pesan pertama
            fetchInterval = setInterval(function() {
                fetchMessages(userId);
            }, 3000);
        }

        function fetchMessages(userId) {
            let chatBox = $('#chat-box-detail').find('#chat-box');
            let lastId = chatBox.data('last-id') || 0;

            fetch('/admin/chat/' + userId + '/messages?last_id=' + lastId)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(msg => {
                            const div = document.createElement('div');
                            div.classList.add('chat-box');
                            div.classList.add(msg.isAdmin ? 'admin-chat' : 'user-chat');
                            div.textContent = msg.msg;

                            const time = document.createElement('span');
                            time.classList.add('chat-time');
                            time.textContent = msg.date;
                            div.appendChild(time);

                            chatBox.append(div);
                            chatBox.data('last-id', msg.id);
                        });
                        chatBox.scrollTop(chatBox.prop("scrollHeight"));
                    }
                })
                .catch(err => console.error(err));
        }
    </script>
@endsection
