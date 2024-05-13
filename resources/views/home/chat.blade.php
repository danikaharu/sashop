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
                                <i class="fas fa-sync-alt"></i> <!-- Icon refresh -->
                            </button>
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
                                <form id="chat-form" class="chat-form" action="{{ route('chat.post', Auth::user()->id) }}"
                                    method="POST">
                                    @csrf <!-- Token CSRF untuk keamanan form Laravel -->
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" name="msg" placeholder="Ketik pesan Anda..." rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
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
            location.reload(); // Memuat ulang halaman saat ini
        }
    </script>

    <!--================End Checkout Area =================-->
@endsection
