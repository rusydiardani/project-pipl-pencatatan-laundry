<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md p-8">
            <h1 class="text-2xl font-bold mb-6">Login</h1>
            
            @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2">Username</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded">
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
