<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background-color: #F5F5F5;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #0000FF;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>REGISTER</h2>

        @if($errors->any())
            <p style="color: red;">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit" class="btn">Register</button>
        </form>
    </div>

</body>
</html>
