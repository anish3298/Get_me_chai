const CART_KEY = 'chaiadda_cart';
const CHECKOUT_KEY = 'chaiadda_checkout';

function formatCurrency(value) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0,
    }).format(value);
}

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch (error) {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartCount();
    renderCart();
}

function updateCartCount() {
    const count = getCart().reduce((sum, item) => sum + Number(item.qty || 0), 0);
    document.querySelectorAll('[data-cart-count]').forEach((badge) => {
        badge.textContent = count;
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('show'), 2200);
}

function addToCart(item) {
    const cart = getCart();
    const existing = cart.find((entry) => String(entry.id) === String(item.id));

    if (existing) {
        existing.qty += Number(item.qty || 1);
    } else {
        cart.push({
            id: String(item.id),
            name: item.name,
            price: Number(item.price),
            image: item.image,
            qty: Number(item.qty || 1),
        });
    }

    saveCart(cart);
    showToast(`${item.name} added to cart`);
}

function removeFromCart(id) {
    const cart = getCart().filter((item) => String(item.id) !== String(id));
    saveCart(cart);
    showToast('Item removed from cart');
}

function changeQty(id, delta) {
    const cart = getCart();
    const item = cart.find((entry) => String(entry.id) === String(id));
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
        removeFromCart(id);
        return;
    }

    saveCart(cart);
}

function calculateTotals(cart) {
    const subtotal = cart.reduce((sum, item) => sum + Number(item.price) * Number(item.qty), 0);
    const discount = subtotal >= 199 ? Math.round(subtotal * 0.1) : 0;
    const delivery = subtotal > 0 ? 25 : 0;
    const total = subtotal - discount + delivery;
    return { subtotal, discount, delivery, total };
}

function renderCart() {
    const cartItems = document.getElementById('cartItems');
    if (!cartItems) return;

    const cart = getCart();
    if (!cart.length) {
        cartItems.innerHTML = `
            <div class="cart-empty">
                <h3>Your cart feels a little empty ☕</h3>
                <p>Add some hot chai and tasty snacks to continue.</p>
                <a class="btn btn-primary" href="menu.php">Browse menu</a>
            </div>
        `;
    } else {
        cartItems.innerHTML = cart.map((item) => `
            <article class="cart-item">
                <img src="${item.image}" alt="${item.name}">
                <div>
                    <h4>${item.name}</h4>
                    <p class="muted">${formatCurrency(item.price)} each</p>
                    <div class="qty-box">
                        <button class="qty-btn" data-action="decrease" data-id="${item.id}" type="button">-</button>
                        <span>${item.qty}</span>
                        <button class="qty-btn" data-action="increase" data-id="${item.id}" type="button">+</button>
                    </div>
                </div>
                <div>
                    <p class="price">${formatCurrency(item.price * item.qty)}</p>
                    <button class="btn btn-outline cart-remove" data-id="${item.id}" type="button">Remove</button>
                </div>
            </article>
        `).join('');
    }

    const totals = calculateTotals(cart);
    const summarySubtotal = document.querySelector('.summary-subtotal');
    const summaryDiscount = document.querySelector('.summary-discount');
    const summaryDelivery = document.querySelector('.summary-delivery');
    const summaryTotal = document.querySelector('.summary-total');

    if (summarySubtotal) summarySubtotal.textContent = formatCurrency(totals.subtotal);
    if (summaryDiscount) summaryDiscount.textContent = `- ${formatCurrency(totals.discount)}`;
    if (summaryDelivery) summaryDelivery.textContent = formatCurrency(totals.delivery);
    if (summaryTotal) summaryTotal.textContent = formatCurrency(totals.total);
}

function initMenuFilters() {
    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.menu-card');
    const searchInput = document.getElementById('menuSearch');

    if (!buttons.length && !searchInput) return;

    function applyFilter() {
        const activeButton = document.querySelector('.filter-btn.active');
        const filter = activeButton ? activeButton.dataset.filter : 'all';
        const term = (searchInput?.value || '').trim().toLowerCase();

        cards.forEach((card) => {
            const category = card.dataset.category;
            const text = card.textContent.toLowerCase();
            const matchesFilter = filter === 'all' || filter === category;
            const matchesSearch = !term || text.includes(term);
            card.classList.toggle('hide', !(matchesFilter && matchesSearch));
        });
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            buttons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            applyFilter();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }
}

function initCheckoutForm() {
    const form = document.getElementById('checkoutForm');
    if (!form) return;

    const stored = JSON.parse(localStorage.getItem(CHECKOUT_KEY) || '{}');
    Object.entries(stored).forEach(([key, value]) => {
        const field = form.querySelector(`[name="${key}"]`);
        if (field) field.value = value;
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(form).entries());
        const phoneOk = /^[6-9]\d{9}$/.test(data.phone || '');
        const pinOk = /^\d{6}$/.test(data.pincode || '');

        if (!data.name || !data.address || !data.city || !phoneOk || !pinOk) {
            showToast('Please complete valid delivery details');
            return;
        }

        localStorage.setItem(CHECKOUT_KEY, JSON.stringify(data));
        window.location.href = 'payment.php';
    });
}

function initPaymentForm() {
    const form = document.getElementById('paymentForm');
    if (!form) return;

    const payerName = document.getElementById('payerName');
    const storedCheckout = JSON.parse(localStorage.getItem(CHECKOUT_KEY) || '{}');
    if (payerName && storedCheckout.name) {
        payerName.value = storedCheckout.name;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const cart = getCart();
        if (!cart.length) {
            showToast('Your cart is empty');
            window.location.href = 'menu.php';
            return;
        }

        const paymentMethod = form.querySelector('input[name="paymentMethod"]:checked')?.value || 'UPI';
        const transactionRef = document.getElementById('transactionRef')?.value.trim();
        const payer = payerName?.value.trim();

        if (!payer || !transactionRef) {
            showToast('Enter payer name and transaction reference');
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Confirming...';

        try {
            const response = await fetch('place_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    cart,
                    checkout: storedCheckout,
                    paymentMethod,
                    transactionRef,
                    payerName: payer,
                }),
            });

            const result = await response.json();
            if (result.success) {
                localStorage.removeItem(CART_KEY);
                localStorage.setItem('chaiadda_last_order', JSON.stringify(result));
                showToast('Payment confirmed successfully');
                window.location.href = `tracking.php?order_id=${encodeURIComponent(result.order_id)}`;
                return;
            }

            showToast(result.message || 'Unable to place order');
        } catch (error) {
            showToast('Server connection failed. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirm Payment';
        }
    });
}

function initReviews() {
    const reviewForm = document.getElementById('reviewForm');
    const reviewList = document.getElementById('reviewList');
    if (!reviewForm || !reviewList) return;

    const productId = reviewForm.dataset.productId;
    const reviewKey = `chaiadda_reviews_${productId}`;

    function renderSavedReviews() {
        const savedReviews = JSON.parse(localStorage.getItem(reviewKey) || '[]');
        const dynamicMarkup = savedReviews.map((review) => `
            <div class="review-item">
                <strong>${review.name}</strong>
                <div class="rating">${'⭐'.repeat(Number(review.rating || 5))}</div>
                <p>${review.comment}</p>
            </div>
        `).join('');

        const dynamicContainer = document.getElementById('dynamicReviews');
        if (dynamicContainer) dynamicContainer.innerHTML = dynamicMarkup;
    }

    renderSavedReviews();

    reviewForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const data = Object.fromEntries(new FormData(reviewForm).entries());

        if (!data.name || !data.comment) {
            showToast('Please add your name and review');
            return;
        }

        const savedReviews = JSON.parse(localStorage.getItem(reviewKey) || '[]');
        savedReviews.unshift(data);
        localStorage.setItem(reviewKey, JSON.stringify(savedReviews.slice(0, 6)));
        reviewForm.reset();
        renderSavedReviews();
        showToast('Thanks for your feedback!');
    });
}

function initTracking() {
    const tracking = document.getElementById('trackingSteps');
    if (!tracking) return;

    const steps = Array.from(tracking.querySelectorAll('.step'));
    const eta = document.getElementById('etaText');
    let current = 0;

    steps.forEach((step, index) => {
        if (index === 0) {
            step.classList.add('active');
        }
    });

    const messages = [
        'Your order has been received by the chai kitchen.',
        'Fresh chai is brewing right now.',
        'Rider is on the way with your hot order.',
        'Delivered fresh. Enjoy your chai!'
    ];

    const interval = setInterval(() => {
        if (current < steps.length - 1) {
            steps[current].classList.add('done');
            steps[current].classList.remove('active');
            current += 1;
            steps[current].classList.add('active');
            if (eta) eta.textContent = messages[current];
        } else {
            steps[current].classList.add('done');
            if (eta) eta.textContent = messages[current];
            clearInterval(interval);
        }
    }, 3500);
}

document.addEventListener('click', (event) => {
    const addButton = event.target.closest('.add-to-cart');
    if (addButton) {
        addToCart({
            id: addButton.dataset.id,
            name: addButton.dataset.name,
            price: addButton.dataset.price,
            image: addButton.dataset.image,
            qty: Number(addButton.dataset.qty || 1),
        });
        return;
    }

    const qtyButton = event.target.closest('.qty-btn');
    if (qtyButton && qtyButton.dataset.id) {
        const delta = qtyButton.dataset.action === 'increase' ? 1 : -1;
        changeQty(qtyButton.dataset.id, delta);
        return;
    }

    const removeButton = event.target.closest('.cart-remove');
    if (removeButton) {
        removeFromCart(removeButton.dataset.id);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    renderCart();
    initMenuFilters();
    initCheckoutForm();
    initPaymentForm();
    initReviews();
    initTracking();
});
