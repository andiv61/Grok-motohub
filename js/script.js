function loadProducts() {
    axios.get('products.php?action=list')
        .then(response => {
            const table = document.getElementById('products-table');
            if (table) {
                table.innerHTML = '';
                response.data.forEach(product => {
                    const row = `<tr>
                        <td>${product.name}</td>
                        <td>${product.article}</td>
                        <td>${product.retail_price}</td>
                        <td>${product.stock}</td>
                        <td><button onclick="deleteProduct(${product.id})" class="btn btn-danger btn-sm">Удалить</button></td>
                    </tr>`;
                    table.innerHTML += row;
                });
            }
        });
}

function deleteProduct(id) {
    axios.post('products.php?action=delete', { id })
        .then(() => loadProducts());
}

function loadOrders() {
    axios.get('orders.php?action=list')
        .then(response => {
            const table = document.getElementById('orders-table');
            if (table) {
                table.innerHTML = '';
                response.data.forEach(order => {
                    axios.get(`products.php?action=get&id=${order.product_id}`)
                        .then(product => {
                            const row = `<tr>
                                <td>${order.id}</td>
                                <td>${order.customer_name}</td>
                                <td>${product.data.name}</td>
                                <td>${order.quantity}</td>
                                <td>${order.status}</td>
                            </tr>`;
                            table.innerHTML += row;
                        });
                });
            }
        });
}

function updateSalesChart() {
    axios.get('analytics.php?action=sales')
        .then(response => {
            const ctx = document.getElementById('salesChart');
            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Мопеды', 'Скутеры', 'Мотоциклы', 'Шлемы'],
                        datasets: [{
                            label: 'Продажи (шт.)',
                            data: response.data,
                            backgroundColor: ['#007bff', '#28a745', '#dc3545', '#ffc107'],
                            borderColor: ['#0056b3', '#218838', '#c82333', '#e0a800'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    loadOrders();
    updateSalesChart();
});