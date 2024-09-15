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