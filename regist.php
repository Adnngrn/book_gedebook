<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GedeBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#E27C00] flex flex-col items-center  min-h-screen">
    <div class="text-center flex items-center">
        <img src="logo_perpus.png" alt="Logo" class="size-48">
        <h1 class="text-3xl font-bold text-white ml-[-25px]">Book <br> GedeBook</h1>
    </div>
    <div class="bg-white p-8 rounded shadow-md w-[400px]">
        <h2 class="text-xl font-bold text-[#E27C00]">Sign Up</h2>
        <form class="mt-4">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="username" placeholder="Ex: luciusking" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                <input type="text" id="username" placeholder="Ex: luciusking" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" placeholder="Ex: ********" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" placeholder="Ex: ********" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <button type="submit" class="w-full bg-[#E27C00] hover:bg-orange-600 text-white font-medium py-2 px-4 rounded"> Sign Up  </button>
        </form>
        
        <div class="flex items-center justify-center mt-4">
            <span class="border-t border-gray-300 flex-grow"></span>
            <span class="mx-2 text-gray-500 text-sm">Or</span>
            <span class="border-t border-gray-300 flex-grow"></span>
        </div>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? <a href="login.html" class="text-[#E27C00] hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</body>
</html>
