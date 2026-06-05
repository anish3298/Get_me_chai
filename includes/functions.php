<?php

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $price): string
{
    return '₹' . number_format($price, 0);
}

function getDefaultProducts(): array
{
    return [
        [
            'id' => 1,
            'name' => 'Masala Chai',
            'price' => 40,
            'category' => 'chai',
            'image' => 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?auto=format&fit=crop&w=900&q=80',
            'description' => 'Classic kadak chai with cardamom, cinnamon, clove and a rich milky finish.',
            'rating' => 4.8,
        ],
        [
            'id' => 2,
            'name' => 'Ginger Chai',
            'price' => 45,
            'category' => 'chai',
            'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=900&q=80',
            'description' => 'Strong chai brewed with fresh adrak for a warm and soothing sip.',
            'rating' => 4.7,
        ],
        [
            'id' => 3,
            'name' => 'Green Tea',
            'price' => 55,
            'category' => 'chai',
            'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=900&q=80',
            'description' => 'Light, refreshing and antioxidant-rich green tea for mindful evenings.',
            'rating' => 4.5,
        ],
        [
            'id' => 4,
            'name' => 'Lemon Tea',
            'price' => 50,
            'category' => 'chai',
            'image' => 'https://images.unsplash.com/photo-1464306076886-da185f6a9d05?auto=format&fit=crop&w=900&q=80',
            'description' => 'A zesty lemon infusion with tea leaves and a hint of honey sweetness.',
            'rating' => 4.4,
        ],
        [
            'id' => 5,
            'name' => 'Kulhad Chai',
            'price' => 60,
            'category' => 'chai',
            'image' => 'https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?auto=format&fit=crop&w=900&q=80',
            'description' => 'Earthy kulhad-served chai that tastes just like a station-side favourite.',
            'rating' => 4.9,
        ],
        [
            'id' => 6,
            'name' => 'Samosa',
            'price' => 35,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=900&q=80',
            'description' => 'Crispy golden samosa with spiced potato filling and mint chutney vibes.',
            'rating' => 4.6,
        ],
        [
            'id' => 7,
            'name' => 'Pakora',
            'price' => 45,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?auto=format&fit=crop&w=900&q=80',
            'description' => 'Crunchy onion pakoras that pair perfectly with rainy-day chai.',
            'rating' => 4.6,
        ],
        [
            'id' => 8,
            'name' => 'Biscuit',
            'price' => 20,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80',
            'description' => 'Buttery tea-time biscuits for dunking into every hot cup.',
            'rating' => 4.2,
        ],
        [
            'id' => 9,
            'name' => 'Sandwich',
            'price' => 70,
            'category' => 'snacks',
            'image' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=900&q=80',
            'description' => 'Grilled veg sandwich with a spicy green chutney spread.',
            'rating' => 4.5,
        ],
    ];
}

function getProducts($conn = null, ?string $category = null, ?string $search = null): array
{
    $items = [];

    if ($conn instanceof mysqli) {
        $sql = "SELECT id, name, price, category, image, description, rating FROM products WHERE 1=1";
        $params = [];
        $types = '';

        if ($category && $category !== 'all') {
            $sql .= ' AND category = ?';
            $params[] = $category;
            $types .= 's';
        }

        if ($search) {
            $sql .= ' AND (name LIKE ? OR category LIKE ? OR description LIKE ?)';
            $term = '%' . $search . '%';
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $types .= 'sss';
        }

        $sql .= ' ORDER BY category, name';
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            $stmt->close();
        }
    }

    if (empty($items)) {
        $items = getDefaultProducts();

        if ($category && $category !== 'all') {
            $items = array_filter($items, fn($item) => $item['category'] === $category);
        }

        if ($search) {
            $search = mb_strtolower($search);
            $items = array_filter($items, function ($item) use ($search) {
                return str_contains(mb_strtolower($item['name']), $search)
                    || str_contains(mb_strtolower($item['category']), $search)
                    || str_contains(mb_strtolower($item['description']), $search);
            });
        }
    }

    return array_values($items);
}

function getProductById($conn = null, int $id): ?array
{
    if ($conn instanceof mysqli) {
        $stmt = $conn->prepare('SELECT id, name, price, category, image, description, rating FROM products WHERE id = ? LIMIT 1');

        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $stmt->close();

            if ($product) {
                return $product;
            }
        }
    }

    foreach (getDefaultProducts() as $product) {
        if ((int) $product['id'] === $id) {
            return $product;
        }
    }

    return null;
}

function getOffers(): array
{
    return [
        ['title' => 'Evening Chai Offer', 'text' => 'Get 15% off on any 2 chai combos from 4 PM to 7 PM.'],
        ['title' => 'Kulhad Special', 'text' => 'Free biscuit pack with every Kulhad Chai order above ₹149.'],
        ['title' => 'Office Break Saver', 'text' => 'Flat ₹50 off on snack platters for teams of 4 or more.'],
    ];
}

function getNearbyShops(): array
{
    return [
        ['name' => 'CP Tea Corner', 'distance' => '1.2 km', 'time' => '12 mins'],
        ['name' => 'Station Kulhad Point', 'distance' => '2.8 km', 'time' => '18 mins'],
        ['name' => 'Old Delhi Chai Hub', 'distance' => '3.4 km', 'time' => '22 mins'],
    ];
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user']);
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}
