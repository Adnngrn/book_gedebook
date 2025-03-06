<?php
include 'koneksi.php';

session_start(); 
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GedeBook | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar"></div>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-100 ml-64">
            <header class="bg-white flex justify-end items-center p-6 gap-4">
                <h3>Administrator</h3><img src="" alt="icon">
            </header>

            <h2 class="text-5xl font-medium px-8 py-6">Dashboard Aplikasi GedeBook</h2>
            <section class="mt-6 grid grid-cols-4 gap-4 p-6">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
                    <p class="text-blue-500 font-semibold">Jumlah Buku</p>
                    <p class="text-lg font-bold mt-1">23 Buku</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-6 rounded shadow border-l-4 border-green-500">
                    <p class="text-green-500 font-semibold">Buku Dipinjam</p>
                    <p class="text-lg font-bold mt-1">1 Pinjaman</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-6 rounded shadow border-l-4 border-red-500">
                    <p class="text-red-500 font-semibold">Data Peminjam</p>
                    <p class="text-lg font-bold mt-1">12 Peminjam</p>
                </div>
            </section>
        </main>
    </div>

<script src="jquery.js"></script>
<script src="script.js"></script>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard GedeBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!- Sidebar -->
        <!-- <div class="w-64 bg-orange-600 text-white flex flex-col p-4">
            <div class="flex items-center space-x-2 mb-6">
                <img src="logo.png" alt="Logo" class="h-10">
                <span class="text-lg font-bold">Book GedeBook</span>
            </div>
            <nav class="flex flex-col space-y-2">
                <a href="#" class="bg-orange-700 p-2 rounded">Dashboard</a>
                <p class="text-sm mt-4">Master Buku</p>
                <a href="#" class="p-2">Data Seri Buku</a>
                <a href="#" class="p-2">Data Buku</a>
                <p class="text-sm mt-4">Master Peminjam</p>
                <a href="#" class="p-2">Data Peminjam</a>
                <p class="text-sm mt-4">Master Pinjam</p>
                <a href="#" class="p-2">Data Pinjam</a>
            </nav>
            <div class="mt-auto">
                <a href="#" class="flex items-center space-x-2 bg-red-600 p-2 rounded">
                    <span>Logout</span>
                </a>
            </div>
        </div> -->
        
        <!-- Main Content -->
        <!-- <div class="flex-1 flex flex-col"> -->
            <!-- Navbar -->
            <!-- <div class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">Dashboard Aplikasi GedeBook</h1>
                <div class="flex items-center space-x-2">
                    <span>Administrator</span>
                    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                </div>
            </div> -->
            
            <!-- Dashboard Content -->
            <!-- <div class="p-6 grid grid-cols-3 gap-4">
                <div class="bg-white p-4 shadow rounded border-t-4 border-blue-500">
                    <h2 class="text-blue-600">Jumlah Buku</h2>
                    <p class="text-xl font-bold">23 Buku</p>
                </div>
                <div class="bg-white p-4 shadow rounded border-t-4 border-green-500">
                    <h2 class="text-green-600">Buku Dipinjam</h2>
                    <p class="text-xl font-bold">1 Pinjaman</p>
                </div>
                <div class="bg-white p-4 shadow rounded border-t-4 border-red-500">
                    <h2 class="text-red-600">Data Peminjam</h2>
                    <p class="text-xl font-bold">12 Peminjam</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> -->
