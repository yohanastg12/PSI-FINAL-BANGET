<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
  <div class="w-full max-w-3xl bg-white p-6 rounded-xl shadow-xl border border-gray-300">
    <!-- Judul -->
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Create Ticket</h2>

    <form action="{{ route('student.ticket.store') }}" method="POST">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Name -->
        <div>
          <label class="block text-gray-800 text-base mb-1" for="name">Name</label>
          <input class="w-full border border-gray-300 rounded-lg p-2 text-base focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" 
                 id="name" name="name" type="text" required/>
        </div>

        <!-- Role -->
        <div>
          <label class="block text-gray-800 text-base mb-1" for="role">Role</label>
          <select class="w-full border border-gray-300 rounded-lg p-2 text-base focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" 
                  id="role" name="role" required>
            <option value="" disabled selected>Pilih Role</option>
            <option value="dosen">Lecturer</option>
            <option value="mahasiswa">Students</option>
          </select>
        </div>
      </div>

      <!-- Description Full Width -->
      <div class="mt-4">
        <label class="block text-gray-800 text-base mb-1" for="description">Description</label>
        <textarea class="w-full border border-gray-300 rounded-lg p-2 text-base focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" 
                  id="description" name="description" rows="4" required></textarea>
      </div>

      <!-- Tombol -->
      <div class="mt-4 flex justify-between">
        <button type="button"
                onclick="history.back()"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">
          Back
        </button>
        <div class="flex gap-2">
          <button type="reset"
                  class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition">
            Cancel
          </button>
          <button type="submit"
                  class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
            Submit
          </button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>