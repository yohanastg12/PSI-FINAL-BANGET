<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>List Ticketing</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center px-4 py-8 space-y-4">

  <!-- Kontainer Tabel -->
  <div class="w-full max-w-5xl bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
    <!-- Header -->
    <div class="text-center py-6 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-t-2xl">
      <h1 class="text-3xl font-semibold tracking-wide">List Ticketing</h1>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
          <tr>
            <th class="px-6 py-4 text-left">Name</th>
            <th class="px-6 py-4 text-left">Role</th>
            <th class="px-6 py-4 text-left">Deskripsi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
          </tr>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
            <td class="px-6 py-4">–</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Tombol Keluar di Kanan -->
  <div class="w-full max-w-5xl flex justify-end">
    <a href="javascript:history.back()" class="bg-gray-700 text-white px-5 py-2 rounded hover:bg-gray-600 transition">
      Keluar
    </a>
  </div>

</body>
</html>
