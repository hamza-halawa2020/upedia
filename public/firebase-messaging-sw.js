const notificationUrl = value => {
    try {
        const url = new URL(value || '/notifications', self.location.origin);
        return ['https:', 'http:'].includes(url.protocol) ? url.href : self.location.origin + '/notifications';
    } catch {
        return self.location.origin + '/notifications';
    }
};

self.addEventListener('notificationclick', event => {
    event.notification.close();
    const actionUrl = notificationUrl(event.notification.data?.action_url);
    event.waitUntil(clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
        const client = clientList.find(item => item.url === actionUrl && 'focus' in item);
        return client ? client.focus() : clients.openWindow(actionUrl);
    }));
});

self.addEventListener('install', event => event.waitUntil(self.skipWaiting()));
self.addEventListener('activate', event => event.waitUntil(clients.claim()));

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
    // FCM already displays notification payloads; only data-only messages need a display here.
    if (payload.notification) return;

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
    const actionUrl = notificationUrl(data.action_url);
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

    return self.registration.showNotification(title, options);
});
