CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    google_id VARCHAR(255) NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    role ENUM('admin', 'player') DEFAULT 'player',
    saldo_real DECIMAL(15,2) DEFAULT 0.00,
    saldo_demo DECIMAL(15,2) DEFAULT 100000.00,
    last_claim_demo DATE NULL,
    scatter_chance DECIMAL(5,2) DEFAULT 5.00,
    last_active DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE app_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_name VARCHAR(100) DEFAULT 'Slot Fa Fa Fa',
    app_logo VARCHAR(255) DEFAULT 'default_logo.png',
    slot_background VARCHAR(255) DEFAULT 'default_bg.jpg'
);

CREATE TABLE slot_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    point_value INT DEFAULT 0,
    is_scatter TINYINT(1) DEFAULT 0
);

CREATE TABLE audio_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    audio_type VARCHAR(50) NOT NULL,
    file_path VARCHAR(255) NOT NULL
);

CREATE TABLE admin_banks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_name VARCHAR(50) NOT NULL,
    account_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(50) NOT NULL,
    is_active TINYINT(1) DEFAULT 1
);

CREATE TABLE player_banks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bank_name VARCHAR(50) NOT NULL,
    account_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('topup', 'withdraw') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    admin_bank_id INT NULL,
    player_bank_id INT NULL,
    proof_image VARCHAR(255) NULL,
    status ENUM('pending', 'proses', 'selesai', 'batal') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_bank_id) REFERENCES admin_banks(id) ON DELETE SET NULL,
    FOREIGN KEY (player_bank_id) REFERENCES player_banks(id) ON DELETE SET NULL
);

INSERT INTO app_settings (app_name, app_logo, slot_background) VALUES 
('Slot Mania CI4', 'logo.png', 'bg_slot.jpg');

INSERT INTO slot_items (item_name, image_path, point_value, is_scatter) VALUES
('Kakek Merah', 'kakek_merah.png', 1000, 0),
('Koin Emas', 'koin.png', 500, 0),
('Bambu', 'bambu.png', 200, 0),
('Petasan', 'petasan.png', 100, 0),
('Scatter', 'scatter.png', 0, 1);

INSERT INTO audio_settings (audio_type, file_path) VALUES
('bgm', 'bgm.mp3'),
('spin', 'spin.mp3'),
('jackpot', 'jackpot.mp3'),
('tension', 'tension.mp3');