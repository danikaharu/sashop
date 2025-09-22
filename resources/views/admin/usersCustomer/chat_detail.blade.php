<style>
    .chat-container {
        max-height: 400px;
        overflow-y: auto;
    }

    .chat-box {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 10px;
        width: 80%;
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
</style>

<div class="order_box">
    <h2 class="mb-4">Chat {{ $user->name }}</h2>
    <div id="chat-box" class="chat-container" data-last-id="0">
        <!-- pesan akan di-append lewat fetchMessages -->
    </div>
    <form id="chat-form" class="chat-form" action="{{ route('chat.post', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea class="form-control" id="message" name="msg" placeholder="Ketik pesan Anda..." rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
    </form>
</div>

<script>
    document.getElementById('chat-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const userId = {{ $user->id }};
        formData.append('user_id', userId);

        fetch(this.action, {
                method: this.method,
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('message').value = '';
                fetchMessages(userId); // panggil fetchMessages dari parent
            })
            .catch(err => console.error(err));
    });
</script>
