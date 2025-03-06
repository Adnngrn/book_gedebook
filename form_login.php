<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GedeBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-[#E27C00] flex flex-col items-center  min-h-screen">
    <div class="text-center flex items-center">
        <img src="logo_perpus.png" alt="Logo" class="size-48">
        <h1 class="text-3xl font-bold text-white ml-[-25px]">Book <br> GedeBook</h1>
    </div>
    <div class="bg-white py-8 px-10 rounded shadow-md w-[400px]">
        <h2 class="text-xl font-bold text-[#E27C00]">Log In</h2>
        <form class="mt-4" method="POST" id="loginForm">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                <input type="text" id="email" name="email" placeholder="Ex: example1@gmail.com" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" placeholder="Ex: ********" class="mt-1 w-full px-4 py-2 border-b-2 border-gray-500 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <button type="submit" class="w-full bg-[#E27C00] hover:bg-orange-600 text-white font-medium py-2 px-4 rounded"> Log In  </button>
        </form>
        <a href="#" class=" text-sm text-blue-500 hover:underline">Lupa Password</a>
        
        <div class="flex items-center justify-center mt-4">
            <span class="border-t border-gray-300 flex-grow"></span>
            <span class="mx-2 text-gray-500 text-sm">Or</span>
            <span class="border-t border-gray-300 flex-grow"></span>
        </div>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="regist.html" class="text-[#E27C00] hover:underline">Sign Up</a>
            </p>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // Mencegah form dari pengiriman default

                $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log(response); // Debugging, lihat apa yang dikembalikan server
                        showToast(response.success ? 'Sukses' : 'Gagal', response.message, response.success);
                        if (response.success) {
                            setTimeout(function() {
                                window.location.href = 'dashboard.php';
                            }, 2000);
                        }
                    },      
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                        showToast('Gagal', 'Terjadi kesalahan saat menghubungi server.', false);
                    }
                });

            });

            function showToast(title, message, isSuccess) {
                $('#toastTitle').text(title);
                $('#toastMessage').text(message);
                $('#liveToast').removeClass('bg-success bg-danger');
                $('#liveToast').addClass(isSuccess ? 'bg-success' : 'bg-danger');
                $('#liveToast').addClass('text-white');
                var toast = new bootstrap.Toast($('#liveToast'));
                toast.show();

                setTimeout(function() {
                    toast.hide();
                }, 3000);
            }
        });
    </script>
</body>
</html>
