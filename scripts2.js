$(document).ready(function() {
    let fontSelectOptions = '';
    let editfontSelectOptions = '';
    let rowCount = 0;
    let editRowCount = 0;

    // =====================
    // Font Management
    // =====================

    /**
     * Loads font options for dropdowns
     * Fetches fonts from the server and populates global font select options
     */
    function loadFontOptions() {
        $.ajax({
            url: 'api/get_fonts.php',
            type: 'GET',
            success: function(response) {
                let fonts = JSON.parse(response);
                fontSelectOptions = getFontSelectOptions(fonts);
                editfontSelectOptions = getEditfontSelectOptions(fonts);
            }
        });
    }

    /**
     * Loads and displays all fonts
     * Fetches fonts from the server and renders them in the font list
     */
    function loadFonts() {
        $.ajax({
            url: 'api/get_fonts.php',
            type: 'GET',
            success: function(response) {
                let fonts = JSON.parse(response);
                let fontListHTML = generateFontListHTML(fonts);
                $('#fontList').html(fontListHTML);
                updateFontSelects(fonts);
                addDeleteFontListeners();
            }
        });
    }

    /**
     * Generates HTML for the font list
     * @param {Array} fonts - Array of font objects
     * @returns {string} HTML string for the font list
     */
    function generateFontListHTML(fonts) {
        let html = getFontListHeader();
    
        fonts.forEach(font => {
            html += generateFontListRowHTML(font);
        });
    
        html += '</tbody></table>';
        return html;
    }
    
    /**
     * Updates font select dropdowns
     * @param {Array} fonts - Array of font objects
     */
    function updateFontSelects(fonts) {
        let fontSelectHTML = fonts.map(font => `<option value="${font.id}">${font.font_name}</option>`).join('');
        $('.fontSelect').html(fontSelectHTML);
    }

    /**
     * Adds event listeners for font delete buttons
     */
    function addDeleteFontListeners() {
        $('.delete-font').on('click', function() {
            let fontId = $(this).data('font-id');
            deleteFont(fontId);
        });
    }

    /**
     * Deletes a font
     * @param {number} fontId - ID of the font to delete
     */
    function deleteFont(fontId) {
        $.ajax({
            url: 'api/delete_font.php',
            type: 'POST',
            data: { id: fontId },
            success: function(response) {
                let result = JSON.parse(response);
                alert(result.success || result.error);
                loadFontOptions();
                loadFonts();
                loadGroups();
            },
            error: function() {
                alert('An error occurred while deleting the font. Please try again.');
            }
        });
    }

    // =====================
    // Font Group Management
    // =====================

    /**
     * Loads and displays all font groups
     */
    function loadGroups() {
        $.ajax({
            url: 'api/get_groups.php',
            type: 'GET',
            success: function(response) {
                let groups = JSON.parse(response);
                let groupListHTML = generateGroupListHTML(groups);
                $('#groupList').html(groupListHTML);
            }
        });
    }

    /**
     * Generates HTML for the group list
     * @param {Array} groups - Array of group objects
     * @returns {string} HTML string for the group list
     */
    function generateGroupListHTML(groups) {
        let html = getHeader();
        groups.forEach(group => {
            html += getGenerateGroupListHtml(group);

           
        });

        html += '</tbody></table>';
        return html;
    }

    /**
     * Adds a new font row to the create group form
     */
    function addFontRow() {
        rowCount++;
        const newRow = generateFontRowHtml(rowCount, fontSelectOptions);
        $('#fontRows').append(newRow);
    }

    /**
     * Adds a new font row to the edit group form
     */
    function addEditFontRow() {
        editRowCount++;
        const newRow = getAddEditFontRow(editRowCount,editfontSelectOptions);
        $('#editFontRows').append(newRow);
    }

    /**
     * Populates the edit form with group data
     * @param {Object} groupData - Data of the group to edit
     */
    function populateEditForm(groupData) {
        $('#editGroupId').val(groupData.group.id);
        $('#editGroupName').val(groupData.group.group_name);
        $('#editFontRows').empty();

        groupData.fonts.forEach((font) => {
            $('#editFontRows').append(generateEditFontRow(font, groupData.all_fonts, editRowCount));
            editRowCount++;
        });

        $('#editGroupSection').removeClass('hidden');
    }

    // =====================
    // Event Listeners
    // =====================

    // Add new row when 'Add Row' button is clicked
    $('#addRowBtn').click(addFontRow);

    // Add new font row in the Edit section
    $('#addEditFontRow').click(addEditFontRow);

    // Remove row when 'Remove' button is clicked
    $(document).on('click', '.removeRowBtn', function() {
        $(this).parent('.fontRow').remove();
    });

    // Handle create font group form submission
    $('#fontGroupForm').submit(function(event) {
        event.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: 'api/create_font_group.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                let result = JSON.parse(response);
                alert(result.success || result.error);
                if (result.success) {
                    $('#fontGroupForm')[0].reset();
                    $('#fontRows').empty();
                    addFontRow();
                    loadGroups();
                }
            }
        });
    });

    // Handle edit font group form submission
    $('#editFontGroupForm').submit(function(event) {
        event.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: 'api/update_font_group.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                let result = JSON.parse(response);
                alert(result.success || result.error);
                if (result.success) {
                    $('#editGroupSection').addClass('hidden');
                    loadGroups();
                }
            }
        });
    });

    // Handle font upload
    $('#fontUpload').on('change', function() {
        var formData = new FormData();
        formData.append('font', this.files[0]);
        $.ajax({
            url: 'api/upload_font.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let result = JSON.parse(response);
                alert(result.success || result.error);
                loadFontOptions();
                loadFonts();
            }
        });
    });

    // Handle delete group button click
    $(document).on('click', '.deleteGroupBtn', function() {
        let groupId = $(this).data('groupid');
        $.ajax({
            url: 'api/delete_group.php',
            type: 'POST',
            data: { id: groupId },
            success: function(response) {
                let result = JSON.parse(response);
                alert(result.success || result.error);
                loadGroups();
            }
        });
    });

    // Handle edit group button click
    $(document).on('click', '.editGroupBtn', function() {
        const groupId = $(this).data('groupid');
        $.ajax({
            url: 'api/get_group_details.php',
            type: 'GET',
            data: { group_id: groupId },
            success: function(response) {
                let groupData = JSON.parse(response);
                populateEditForm(groupData);
            }
        });
    });

    

    $('#closeEditGroupSection').on('click', function() {
        $('#editFontGroupForm')[0].reset();
        $('#editGroupSection').addClass('hidden');
    });

    // =====================
    // Utility Functions
    // =====================

    const getFontSelectOptions = (fonts) => fonts.map(font => `<option value="${font.id}">${font.font_name}</option>`).join('');

    const getEditfontSelectOptions = (fonts) => fonts.map(font => `<option value="${font.id}">${font.font_name}</option>`).join('');

    const generateFontRowHtml = (rowId, fontSelectOptions) => `
        <div class="fontRow mb-4" id="row-${rowId}">
            <input type="text" name="fontName[]" placeholder="Font Name" class="border p-2 mr-2" required>
            <select name="fontSelect[]" class="border p-2 fontSelect" required>
                <option value="">Select a font</option>
                ${fontSelectOptions}
            </select>
            <button type="button" class="removeRowBtn bg-red-500 text-white px-2 py-1 ml-2 rounded">Remove</button>
        </div>
    `;

    const getHeader = () => `
        <table class="w-full" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Fonts</th>
                    <th class="text-center">Count</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
    `;

    const getAddEditFontRow = (editRowCount,editfontSelectOptions)=>`
            <div class="fontRow mb-4" id="row-${editRowCount}">
                <input type="text" name="fontName[]" placeholder="Font Name" class="border p-2 mr-2" required>
                <select name="fontSelect[]" class="border p-2 fontSelect" required>
                    <option value="">Select a font</option>
                    ${editfontSelectOptions}
                </select>
                <button type="button" class="removeRowBtn bg-red-500 text-white px-2 py-1 ml-2 rounded">Remove</button>
            </div>
        `;

    const  getGenerateGroupListHtml = (group) =>   `
    <tr style="border-bottom: 1px solid #ccc;">
        <td class="font-semibold">${group.group_name}</td>
        <td>
            <ul class="list-disc list-inside">
                ${group.fonts.map(font => `<li>${font.name}</li>`).join('')}
            </ul>
        </td>
        <td class="text-center">${group.font_count}</td>
        <td class="text-center">
            <button class="bg-red-500 text-white p-2 m-1 rounded deleteGroupBtn" data-groupid="${group.id}">Delete</button>
            <button class="bg-blue-500 text-white p-2 m-1 rounded editGroupBtn" data-groupid="${group.id}">Edit</button>
        </td>
    </tr>
`;


const generateEditFontRow = (font, allFonts, rowCount)=>  `
        <div class="fontRow mb-4" data-row="${rowCount}">
            <input type="text" name="font_names[]" value="${font.name}" class="border p-2">
            <select name="font_ids[]" class="border p-2 fontSelect">
                ${allFonts.map(f => `<option value="${f.id}" ${f.id === font.id ? 'selected' : ''}>${f.font_name}</option>`).join('')}
            </select>
            <button type="button" class="removeRowBtn bg-red-500 text-white px-2 py-1 ml-2 rounded">Remove</button>
        </div>
    `;


    const generateFontListRowHTML = (font)=> {
        let fontId = `font_${font.font_name.replace('.ttf', '')}`;
        return `
            <style>
                @font-face {
                    font-family: '${fontId}';
                    src: url('/FontGroupSystem/${font.font_path}');
                }
                .${fontId} {
                    font-family: '${fontId}';
                }
            </style>
            <tr class="mb-4" style="border-bottom: 1px solid #ccc;">
                <td class="font-semibold">${font.font_name}</td>
                <td class="${fontId}">TEXT</td>
                <td>
                    <button class="delete-font hover:text-red-700 text-red-500 font-bold py-1 px-2" data-font-id="${font.id}">
                        Delete
                    </button>
                </td>
            </tr>
        `;
    }
    
    const getFontListHeader = ()=>`
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">Font Name</th>
                        <th class="text-left">Example Text</th>
                        <th class="text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
        `;
    // =====================
    // Initialization
    // =====================

    loadFontOptions();
    addFontRow();
    loadGroups();
    loadFonts();
});