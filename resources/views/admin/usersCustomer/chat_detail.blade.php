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


<div class="col-lg-12 col-md-7 col-sm-12">
    <div class="order_box">
        <h2 class="mb-4">Chat {{$user->name}}</h2>
        <div id="chat-box" class="chat-container">
            <!-- Contoh pesan -->
            @foreach ($msg as $item)
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
            @endforeach


            <!-- Akhir contoh pesan -->
        </div>
        @auth
            <form id="chat-form" class="chat-form" action="{{ route('chat.post', $user->id) }}" method="POST">
                @csrf <!-- Token CSRF untuk keamanan form Laravel -->
                <div class="form-group">
                    <textarea class="form-control" id="message" name="msg" placeholder="Ketik pesan Anda..." rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
            </form>
        @endauth

    </div>
</div>
