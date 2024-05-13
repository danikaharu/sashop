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

        .card-list {
            height: 300px;
            /* Atur tinggi maksimum daftar */
            overflow-y: auto;
            /* Biarkan daftar menjadi scrollable jika lebih tinggi dari tinggi maksimum */
        }

        .card {
            border: 1px solid #ccc;
            /* Tambahkan garis tepi untuk setiap kartu */
            border-radius: 10px;
            /* Tambahkan sudut bulat untuk setiap kartu */
        }

        .card:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            /* Efek bayangan ketika kursor diarahkan ke kartu */
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

        .card-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 0.5rem;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
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
                                <button onclick="showChat({{ $item->user->id }})" class="btn btn-primary mb-3">
                                    <i class="fas fa-sync-alt"></i> <!-- Icon refresh -->
                                </button>

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
                        <div id="chat-box">
                            <!-- Konten chat akan dimuat di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
        var lastClickedUserId = null;

        function showChat(userId, reload = false) {
            // Jika reload = true dan userId tidak berubah, maka keluar dari fungsi
            if (reload && userId === lastClickedUserId) {
                return;
            }

            // Menggunakan AJAX untuk mengambil detail peserta dari server
            $.ajax({
                type: 'GET',
                url: 'detail/' + userId,
                success: function(response) {
                    // Memperbarui konten di sebelah kanan dengan detail peserta yang baru
                    $('#chat-box').html(response);
                    // Set lastClickedUserId ke userId yang baru saja di-klik
                    lastClickedUserId = userId;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Fungsi untuk memuat ulang chat
        function reloadChat() {
            showChat(lastClickedUserId, true); // Memanggil showChat dengan parameter reload=true
        }
    </script>


    <!-- /.content-wrapper -->
@endsection
