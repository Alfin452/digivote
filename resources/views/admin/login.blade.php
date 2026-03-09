<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Login - DigiVote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4">
    <div class="max-w-md w-full bg-gray-800 rounded-3xl shadow-2xl border border-gray-700 overflow-hidden">
        <div class="p-8 text-center bg-gray-950 border-b border-gray-800">
            <h2 class="text-3xl font-black text-white tracking-widest uppercase">DigiVote</h2>
            <p class="text-gray-400 mt-2 font-medium text-sm tracking-widest uppercase">Master Control Panel</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
            <div class="mb-6 bg-red-900/50 border border-red-500/50 text-red-200 p-4 rounded-xl text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Master</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 outline-none transition-all">
                </div>

                <div class="mb-8">
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-xl bg-gray-900 border border-gray-700 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 outline-none transition-all">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-blue-900/20 text-lg uppercase tracking-wider">
                    Akses Sistem
                </button>
            </form>
        </div>
    </div>
</body>

</html>