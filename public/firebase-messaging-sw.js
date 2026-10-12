importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

const firebaseConfig = Object.fromEntries(new URL(self.location.href).searchParams.entries());

firebase.initializeApp({
    apiKey: firebaseConfig.apiKey || '',
    authDomain: firebaseConfig.authDomain || '',
    projectId: firebaseConfig.projectId || '',
    messagingSenderId: firebaseConfig.messagingSenderId || '',
    appId: firebaseConfig.appId || '',
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
    console.log('[Firebase SW] background payload received', payload);

    const data = payload.data || {};
    const title =
        payload.notification?.title ||
        data.title ||
        data.notification_title ||
        'New Notification';
    const body =
        payload.notification?.body ||
        data.body ||
        data.message ||
        data.notification_body ||
        '';
    const actionUrl = data.action_url || '/notifications';
    const notificationTag = self.location.origin + '-' + (data.notification_id || Date.now());

    const options = {
        body: body,
        icon: '/assets/images/logo-icon.png',
        badge: '/assets/images/logo-icon.png',
        tag: notificationTag,
        renotify: true,
        data: {
            ...data,
            action_url: actionUrl,
        },
    };

    console.log('[Firebase SW] showing background notification', {
        title: title,
        body: body,
        actionUrl: actionUrl,
        tag: notificationTag,
    });

    return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const actionUrl = event.notification.data?.action_url || '/notifications';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (const client of clientList) {
                if (client.url === actionUrl && 'focus' in client) {
                    return client.focus();
                }
            }

            return clients.openWindow(actionUrl);
        })
    );
});
