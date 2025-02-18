<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('{{ asset("assets/img/bg.jpg") }}') no-repeat center center;
            background-size: cover; /* Ubah ke "contain" jika ingin gambar tidak dipotong */
            background-attachment: fixed; /* Membuat gambar tetap saat scrolling */
        }
        .container {
            background: rgba(245, 245, 245, 0.85); /* Transparansi agar tulisan tetap terlihat */
            padding: 60px;
            text-align: center;
            border-radius: 15px;
            width: 380px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            color: black;
            margin-bottom: 30px;
        }
        .button {
            display: block;
            width: 80%;
            padding: 12px;
            margin: 15px auto;
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            transition: 0.3s;
        }
        .login {
            background-color: #00CC00;
        }
        .register {
            background-color: #0000CC;
        }
        .button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>WELCOME</h1>
        <a href="{{ route('login') }}" class="button login">Login</a>
        <a href="{{ route('register') }}" class="button register">Register</a>
    </div>

</body>
</html>
