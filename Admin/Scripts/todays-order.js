let offset = 0;
const limit = 10;
let loading = false;

function loadOrders() { 
    if (loading) return;
    loading = true;
    document.getElementById('loading').classList.remove('hidden');

    axios.get(`Logics/fetch-today.php?offset=${offset}`)
        .then(response => {
            const orders = response.data;
            const tableBody = document.getElementById('orders-table-body');

            orders.forEach((order, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-2 border">${offset + index + 1}</td>
                    <td class="px-4 py-2 border">${order.order_id}</td>
                    <td class="px-4 py-2 border">${order.username}</td>
                    <td class="px-4 py-2 border">${order.address}</td>
                    <td class="px-4 py-2 border">${order.productName}</td>
                    <td class="px-4 py-2 border">${order.quantity}</td>
                    <td class="px-4 py-2 border">${order.price}</td>
                    <td class="px-4 py-2 border">
                        <a href="update-order.php?id=${order.order_id}" class="text-blue-500">Details</a>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            offset += limit;
            loading = false;
            document.getElementById('loading').classList.add('hidden');
        })
        .catch(error => {
            console.error('Error loading orders:', error);
            document.getElementById('loading').textContent = 'Error loading orders.';
            loading = false;
        });
}

// Load initial orders
loadOrders();

// Infinite Scroll
window.addEventListener('scroll', () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
        loadOrders();
    }
});

// Refresh orders every 15 seconds (optional real-time update)
setInterval(() => {
    offset = 0;
    document.getElementById('orders-table-body').innerHTML = '';
    loadOrders();
}, 15000); // 15 seconds