# Font Group System

## Overview

The Font Group System is a one-page web application that allows users to upload fonts, create font groups, and manage these groups. This project is built using Core PHP for the backend, JavaScript (jQuery) for the frontend, and utilizes AJAX for seamless interactions without page reloads.

## Features

1. Font Upload:
   - Upload TTF font files
   - Automatic upload on file selection (no submit button)

2. Font List:
   - Display all uploaded fonts
   - Preview fonts with example text
   - Delete individual fonts

3. Font Group Creation:
   - Create groups with multiple fonts
   - Dynamic row addition for font selection
   - Minimum of two fonts required per group

4. Font Group Management:
   - List all created font groups
   - Edit existing font groups
   - Delete font groups

## Technologies Used

- Backend: Core PHP (OOP)
- Frontend: HTML, CSS, JavaScript (jQuery)
- Database: MySQL
- CSS Framework: Tailwind CSS
- Server: XAMPP

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/your-username/font-group-system.git
   ```

2. Move the project folder to your XAMPP's `htdocs` directory.

3. Start your XAMPP server and ensure Apache and MySQL are running.

4. Create a new database named `fontdb` in phpMyAdmin.

5. Run the following SQL commands in your `fontdb` database to set up the necessary tables:

   ```sql
   -- Database name=fontdb

   CREATE TABLE fonts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       font_name VARCHAR(255),
       font_path VARCHAR(255)
   );

   CREATE TABLE fonts_group (
       id INT AUTO_INCREMENT PRIMARY KEY,
       group_name VARCHAR(255) NOT NULL
   );

   CREATE TABLE fonts_group_fonts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       group_id INT,
       font_id INT,
       name VARCHAR(255),
       FOREIGN KEY (group_id) REFERENCES fonts_group(id),
       FOREIGN KEY (font_id) REFERENCES fonts(id)
   );
   ```

6. Open your web browser and navigate to `http://localhost/FontManagementSystem` (adjust the path if necessary).

## Usage

1. **Upload Fonts**: Use the file input at the top of the page to upload TTF font files.
2. **View Fonts**: Uploaded fonts will be displayed in a list with preview text.
3. **Create Font Group**: Use the form to create a new font group. Click "Add Row" to add more fonts to the group.
4. **Manage Groups**: View all created groups in the list. Use the "Edit" and "Delete" buttons to manage existing groups.

## SOLID Principles Implementation

This project adheres to SOLID principles:

- **Single Responsibility**: Each class (Font, FontGroup) has a single, well-defined purpose.
- **Open/Closed**: The system is open for extension (e.g., adding new font types) but closed for modification.
- **Liskov Substitution**: Subtypes can be used interchangeably (if applicable).
- **Interface Segregation**: Interfaces are specific to client needs (if interfaces are used).
- **Dependency Inversion**: High-level modules don't depend on low-level modules. Both depend on abstractions.

## Error Handling

The system includes comprehensive error handling for various scenarios, including:
- Invalid file types during upload
- Database connection issues
- Invalid data submissions

## Future Improvements

- Implement user authentication
- Add pagination for large font and group lists
- Enhance font preview capabilities
- Implement font categorization

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available under the [MIT License](LICENSE).
