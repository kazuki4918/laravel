<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* YouTube風ヘッダー */
        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            z-index: 1000;
        }

        .navbar-logo {
            font-size: 22px;
            font-weight: bold;
            color: #ff0000;
            /* YouTubeの赤 */
        }

        .search-box {
            width: 50%;
            max-width: 600px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px;
            border: 1px solid #ccc;
            border-radius: 25px;
        }

        .search-box button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-menu i {
            font-size: 20px;
            cursor: pointer;
        }

        .profile-pic {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        main {
            margin-top: 70px;
            /* ヘッダーの高さ分を確保 */
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- YouTube風ヘッダー -->
        <nav class="navbar navbar-custom d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <a class="navbar-brand navbar-logo" href="{{ route('posts.index') }}">
                    <i class="fab fa-youtube"></i> Sukimachi
                </a>
            </div>

            <!-- ユーザー情報とアイコン -->
            <div class="user-menu">
                @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary">ログイン</a>
                <a href="{{ route('register') }}" class="btn btn-outline-success">会員登録</a>
                @else
                <i class="fas fa-bell"></i> <!-- 通知アイコン -->
                <i class="fas fa-upload"></i> <!-- アップロードアイコン -->

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
                            alt="アイコンを設定しよう　" class="profile-pic">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}">マイページ</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @endguest
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>