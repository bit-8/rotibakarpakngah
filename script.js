document.addEventListener('DOMContentLoaded', () => {
    // Set the initial cart count on page load
    updateCartCount();

    // Use event delegation for "Add to Cart" forms
    document.body.addEventListener('submit', e => {
        if (e.target.matches('.add-to-cart-form')) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            formData.append('action', 'add');

            fetch('cart_logic.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Added to cart!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    updateCartCount();
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            });
        }
    });

    // Use event delegation for cart actions on cart.php
    const cartContainer = document.getElementById('cart-container');
    if (cartContainer) {
        // For remove buttons
        cartContainer.addEventListener('click', e => {
            if (e.target.closest('.remove-btn')) {
                const button = e.target.closest('.remove-btn');
                const productId = button.dataset.id;
                updateCart('remove', productId);
            }
        });

        // For quantity inputs
        cartContainer.addEventListener('change', e => {
            if (e.target.matches('.quantity-input')) {
                const input = e.target;
                const productId = input.dataset.id;
                const quantity = input.value;
                updateCart('update', productId, quantity);
            }
        });
    }
});

/**
 * Updates the cart via AJAX.
 * @param {string} action - The action to perform (add, update, remove).
 * @param {number} productId - The product ID.
 * @param {number} [quantity=0] - The new quantity (for update actions).
 */
function updateCart(action, productId, quantity = 0) {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('product_id', productId);
    if (quantity) {
        formData.append('quantity', quantity);
    }

    fetch('cart_logic.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Reload page to reflect changes in cart. A more advanced implementation
            // might update the DOM directly, but this is simple and effective.
            window.location.reload();
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    });
}

/**
 * Fetches the current cart item count and updates the badge in the header.
 */
function updateCartCount() {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        fetch('cart_logic.php?action=count')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    cartCountElement.textContent = data.count;
                }
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
            });
    }
}
