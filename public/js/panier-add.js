document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();

    function attachEventListeners() {
        document.querySelectorAll('.cart-update-form .increase').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Empêcher le comportement par défaut
                const form = this.closest('.cart-update-form');
                const id = parseInt(form.dataset.id, 10); // Convertir l'ID en entier
                if (!isNaN(id)) {
                    updateCart(id, 'increase');
                }
            });
        });

        document.querySelectorAll('.cart-update-form .decrease').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Empêcher le comportement par défaut
                const form = this.closest('.cart-update-form');
                const id = parseInt(form.dataset.id, 10); // Convertir l'ID en entier
                if (!isNaN(id)) {
                    updateCart(id, 'decrease');
                }
            });
        });

        document.querySelectorAll('.cart-remove-form .remove').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Empêcher le comportement par défaut
                const form = this.closest('.cart-remove-form');
                const id = parseInt(form.dataset.id, 10); // Convertir l'ID en entier
                if (!isNaN(id)) {
                    removeFromCart(id);
                }
            });
        });
    }

    function updateCart(id, action) {
        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ action: action })
        })
        .then(response => response.json())
        .then(data => {
            // Mettre à jour l'interface utilisateur avec les nouvelles données du panier
            updateCartUI(data);
        });
    }

    function removeFromCart(id) {
        fetch(`/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Mettre à jour l'interface utilisateur avec les nouvelles données du panier
            updateCartUI(data);
        });
    }

    function updateCartUI(data) {
        // Mettre à jour les éléments du panier dans le DOM
        const cartItemsContainer = document.querySelector('#cart-items');
        cartItemsContainer.innerHTML = ''; // Vider le conteneur des éléments du panier
        data.items.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('d-flex', 'justify-content-start', 'cart-item');
            cartItem.innerHTML = `
                <div>
                    <img src="${item.product.image}" alt="${item.product.nom}">
                </div>
                <div>
                    <div>
                        <h4>${item.product.prix}</h4>
                        <p>${item.product.nom}</p>
                        <span>${item.product.poids}</span> <span>${item.product.prix / item.product.poids}/kg</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <form class="cart-update-form" data-id="${item.product.id}" method="post">
                            <button type="button" class="decrease">-</button>
                            <span>${item.quantity}</span>
                            <button type="button" class="increase">+</button>
                        </form>
                        <form class="cart-remove-form" data-id="${item.product.id}" method="post">
                            <button type="button" class="remove">Supprimer</button>
                        </form>
                    </div>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });

        // Mettre à jour le total
        const totalElement = document.querySelector('.total h2');
        if (totalElement) {
            totalElement.textContent = `Total : ${data.total} €`;
        }

        // Réattacher les événements aux nouveaux éléments
        attachEventListeners();
    }
});