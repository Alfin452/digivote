<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Event - DigiVote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 text-center bg-blue-600">
            <h2 class="text-3xl font-black text-white">DigiVote</h2>
            <p class="text-blue-100 mt-2 font-medium">Portal Admin Event</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin-event.login.post') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Akses</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                </div>

                <div class="mb-8">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm text-lg">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>
</body>

</html>