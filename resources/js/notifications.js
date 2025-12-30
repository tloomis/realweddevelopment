/**
 * Browser Notifications Handler
 *
 * Handles browser push notifications for the application
 */

class NotificationManager {
    constructor() {
        this.permission = Notification.permission;
        this.enabled = false;
    }

    /**
     * Request permission for browser notifications
     */
    async requestPermission() {
        if (!('Notification' in window)) {
            console.log('This browser does not support notifications');
            return false;
        }

        if (this.permission === 'granted') {
            this.enabled = true;
            return true;
        }

        if (this.permission !== 'denied') {
            const permission = await Notification.requestPermission();
            this.permission = permission;
            this.enabled = permission === 'granted';
            return this.enabled;
        }

        return false;
    }

    /**
     * Show a notification
     */
    show(title, options = {}) {
        if (!this.enabled) {
            console.log('Notifications are not enabled');
            return;
        }

        const defaultOptions = {
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            vibrate: [200, 100, 200],
            requireInteraction: false,
            ...options
        };

        try {
            const notification = new Notification(title, defaultOptions);

            // Auto-close after 10 seconds
            setTimeout(() => notification.close(), 10000);

            // Handle click
            notification.onclick = function(event) {
                event.preventDefault();
                window.focus();
                if (options.url) {
                    window.location.href = options.url;
                }
                notification.close();
            };

            return notification;
        } catch (error) {
            console.error('Error showing notification:', error);
        }
    }

    /**
     * Show new message notification
     */
    newMessage(messageSender, messagePreview) {
        return this.show('New Message from RealWebDevelopment', {
            body: `${messageSender}: ${messagePreview}`,
            tag: 'new-message',
            icon: '/favicon.ico',
            url: window.location.href
        });
    }

    /**
     * Show new invoice notification
     */
    newInvoice(invoiceNumber, amount) {
        return this.show('New Invoice', {
            body: `Invoice ${invoiceNumber} for $${amount} has been issued`,
            tag: 'new-invoice',
            icon: '/favicon.ico',
            url: window.location.href
        });
    }

    /**
     * Show payment reminder notification
     */
    paymentReminder(invoiceNumber, daysOverdue) {
        return this.show('Payment Reminder', {
            body: `Invoice ${invoiceNumber} is ${daysOverdue} days overdue`,
            tag: 'payment-reminder',
            icon: '/favicon.ico',
            requireInteraction: true,
            url: window.location.href
        });
    }
}

// Export singleton instance
export const notificationManager = new NotificationManager();

// Make available globally
window.notificationManager = notificationManager;
