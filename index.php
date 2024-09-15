<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Font Group System</title>
    <style>
        .font-row { display: flex; margin-bottom: 1rem; }
        .font-row input, .font-row select { flex: 1; padding: 0.5rem; margin-right: 0.5rem; }
        .font-row input:last-child, .font-row select:last-child { margin-right: 0; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8">Font Group System</h1>

        <!-- Font Upload Section -->
        <section class="mb-10 p-4 bg-white shadow rounded">
            <h2 class="text-2xl font-semibold mb-4">Upload Fonts</h2>
            <form id="uploadForm">
        <label for="fontUpload">
            <img src="assets/upload_page.png" alt="Choose File" class="cursor-pointer">
        </label>
        <input type="file" name="font" id="fontUpload" accept=".ttf" class="border p-2 hidden">
             </form>
        </section>

        <!-- List of Fonts Section -->
        <section class="mb-10 p-4 bg-white shadow rounded">
            <h2 class="text-2xl font-semibold mb-4">Available Fonts</h2>
            <div id="fontList"></div>
        </section>



 <!-- Font Group Form -->
    <section class="mb-10 p-4 bg-white shadow rounded">
        <h2 class="text-2xl font-semibold mb-4">Add Font Group</h2>
        <form id="fontGroupForm">
            <div class="mb-4">
                <label for="groupName" class="block text-gray-700 font-bold mb-2">Group Name:</label>
                <input type="text" id="groupName" name="groupName" class="border p-2 w-full" required>
            </div>

            <!-- Container for dynamic font rows -->
            <div id="fontRows" class="mb-4">
                <!-- Dynamic rows will be appended here -->
            </div>

            <button type="button" id="addRowBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Add Row</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Group</button>
        </form>
    </section>



<!-- Edit Font Group Section -->
<section id="editGroupSection" class="mb-10 p-4 bg-white shadow rounded hidden">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Edit Font Group</h2>
        <button type="button" id="closeEditGroupSection" class="text-red-500 text-xl rounded-full border border-red-500 w-8 h-8 flex items-center justify-center hover:border-red-950 hover:shadow-lg hover:shadow-red-500/50">X</button>

    </div>
    <form id="editFontGroupForm">
        <input type="hidden" name="group_id" id="editGroupId">
        <div class="mb-4">
            <label for="editGroupName" class="block text-lg font-medium">Group Name</label>
            <input type="text" id="editGroupName" name="group_name" class="border p-2 w-full">
        </div>
        <div id="editFontRows"></div>
        <button type="button" id="addEditFontRow" class="bg-blue-500 text-white p-2 rounded">Add Row</button>
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Update Group</button>
    </form>
</section>


    <!-- Display Groups Section -->
    <section class="mb-10 p-4 bg-white shadow rounded">
            <h2 class="text-2xl font-semibold mb-4">Font Groups</h2>
            <div id="groupList"></div>
    </section>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script  src="scripts2.js"></script>

</body>
</html>
3