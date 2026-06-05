CREATE DATABASE IF NOT EXISTS chai_adda;
USE chai_adda;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category ENUM('chai', 'snacks') NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    rating DECIMAL(2,1) DEFAULT 4.5
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('Preparing', 'Out for delivery', 'Delivered') DEFAULT 'Preparing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NULL,
    user_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    upi_id VARCHAR(100) DEFAULT 'chaiadda@okhdfcbank',
    transaction_method VARCHAR(60) NOT NULL,
    transaction_ref VARCHAR(120) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_payments_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reviews_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO products (name, price, category, image, description, rating) VALUES
('Masala Chai', 40, 'chai', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?auto=format&fit=crop&w=900&q=80', 'Classic kadak chai with cardamom, cinnamon, clove and a rich milky finish.', 4.8),
('Ginger Chai', 45, 'chai', 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=900&q=80', 'Strong chai brewed with fresh adrak for a warm and soothing sip.', 4.7),
('Green Tea', 55, 'chai', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=900&q=80', 'Light, refreshing and antioxidant-rich green tea for mindful evenings.', 4.5),
('Lemon Tea', 50, 'chai', 'https://images.unsplash.com/photo-1464306076886-da185f6a9d05?auto=format&fit=crop&w=900&q=80', 'A zesty lemon infusion with tea leaves and a hint of honey sweetness.', 4.4),
('Kulhad Chai', 60, 'chai', 'https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?auto=format&fit=crop&w=900&q=80', 'Earthy kulhad-served chai that tastes just like a station-side favourite.', 4.9),
('Samosa', 35, 'snacks', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=900&q=80', 'Crispy golden samosa with spiced potato filling and mint chutney vibes.', 4.6),
('Pakora', 45, 'snacks', 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?auto=format&fit=crop&w=900&q=80', 'Crunchy onion pakoras that pair perfectly with rainy-day chai.', 4.6),
('Biscuit', 20, 'snacks', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80', 'Buttery tea-time biscuits for dunking into every hot cup.', 4.2),
('Sandwich', 70, 'snacks', 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=900&q=80', 'Grilled veg sandwich with a spicy green chutney spread.', 4.5);
