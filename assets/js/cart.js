// Mechanicus Cart System - Client-side cart functionality
// This file should be included on all pages that need cart functionality

// Cart utility functions
window.MechaCart = {
    // Get cart from localStorage
    getCart: function() {
        const cart = localStorage.getItem('mechaCart');
        return cart ? JSON.parse(cart) : {};
    },

    // Save cart to localStorage
    saveCart: function(cart) {
        localStorage.setItem('mechaCart', JSON.stringify(cart));
        this.updateAllCartDisplays();
    },

    // Add item to cart
    addToCart: function(productId, quantity = 1) {
        const cart = this.getCart();
        
        // You can extend this with product data if needed
        if (cart[productId]) {
            cart[productId].quantity += quantity;
        } else {
            cart[productId] = {
                quantity: quantity,
                // Product data will be filled by the page that knows the products
                product: null
            };
        }

        this.saveCart(cart);
        return true;
    },

    // Remove item from cart
    removeFromCart: function(productId) {
        const cart = this.getCart();
        if (cart[productId]) {
            delete cart[productId];
            this.saveCart(cart);
        }
    },

    // Update quantity
    updateQuantity: function(productId, quantity) {
        const cart = this.getCart();
        if (quantity <= 0) {
            this.removeFromCart(productId);
        } else if (cart[productId]) {
            cart[productId].quantity = quantity;
            this.saveCart(cart);
        }
    },

    // Get cart totals
    getCartTotals: function(products = null) {
        const cart = this.getCart();
        let totalItems = 0;
        let totalPrice = 0;

        for (const [productId, item] of Object.entries(cart)) {
            totalItems += item.quantity;
            
            // Calculate price if products data is available
            if (products && products[productId]) {
                totalPrice += products[productId].price * item.quantity;
            } else if (item.product && item.product.price) {
                totalPrice += item.product.price * item.quantity;
            }
        }

        return {
            totalItems: totalItems,
            totalPrice: totalPrice,
            formattedPrice: '₱' + totalPrice.toFixed(2)
        };
    },

    // Clear cart
    clearCart: function() {
        localStorage.removeItem('mechaCart');
        this.updateAllCartDisplays();
    },

    // Update cart displays across the page
    updateAllCartDisplays: function() {
        // Update cart link in header
        const cartLink = document.getElementById('cart-link');
        if (cartLink) {
            const totals = this.getCartTotals();
            cartLink.innerHTML = `Sacred Cart: ${totals.formattedPrice} (${totals.totalItems})`;
        }

        // Update any other cart displays
        const cartCount = document.getElementById('cart-count');
        const cartTotal = document.getElementById('cart-total');
        
        if (cartCount || cartTotal) {
            const totals = this.getCartTotals();
            if (cartCount) cartCount.textContent = totals.totalItems;
            if (cartTotal) cartTotal.textContent = totals.formattedPrice;
        }

        // Trigger custom event for pages that need to update their displays
        document.dispatchEvent(new CustomEvent('cartUpdated', { 
            detail: { cart: this.getCart(), totals: this.getCartTotals() }
        }));
    },

    // Initialize cart display when page loads
    init: function() {
        this.updateAllCartDisplays();
    }
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    MechaCart.init();
});
