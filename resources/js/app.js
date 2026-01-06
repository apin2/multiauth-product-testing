import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || '1234567890abcdef',
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    debug: true, // Enable debug mode
});

// Listen for customer status updates
window.Echo.channel('customer-status')
    .listen('.customer.status.updated', (e) => {
        console.log('Received customer status update:', e.customer);
        updateCustomerStatus(e.customer);
    })
    .error((error) => {
        console.error('Error listening to customer-status channel:', error);
    });

// Debug connection status
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Connected to Pusher');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('Disconnected from Pusher');
});

function updateCustomerStatus(customer) {
    const statusIndicator = document.getElementById(`status-indicator-${customer.id}`);
    const statusText = document.getElementById(`status-text-${customer.id}`);
    
    if (statusIndicator && statusText) {
        if (customer.is_online) {
            statusIndicator.innerHTML = '<i class="fas fa-circle text-success" title="Online"></i>';
            statusText.textContent = 'Online';
        } else {
            statusIndicator.innerHTML = '<i class="fas fa-circle text-secondary" title="Offline"></i>';
            statusText.textContent = 'Offline';
        }
    }
}