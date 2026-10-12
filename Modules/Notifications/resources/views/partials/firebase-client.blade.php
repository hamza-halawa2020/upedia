<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>
<script>
    (() => {
        const settings = @js([
            'apiKey' => config('services.firebase.api_key'),
            'authDomain' => config('services.firebase.auth_domain'),
            'projectId' => config('services.firebase.project_id'),
            'messagingSenderId' => config('services.firebase.messaging_sender_id'),
            'appId' => config('services.firebase.app_id'),
        ]);
        if (!['apiKey', 'projectId', 'messagingSenderId', 'appId'].every(key => settings[key])) return;
        if (!window.isSecureContext || !('serviceWorker' in navigator) || !('Notification' in window)) return;
        navigator.serviceWorker.register('/firebase-messaging-sw.js?' + new URLSearchParams(settings))
            .then(async registration => {
                if (!firebase.apps.length) firebase.initializeApp(settings);
                const messaging = firebase.messaging();
                async function enablePush() {
                    try {
                        const permission = Notification.permission === 'granted'
                            ? 'granted' : await Notification.requestPermission();
                        if (permission !== 'granted') return;
                        const token = await messaging.getToken({
                            vapidKey: @js(config('services.firebase.vapid_key')),
                            serviceWorkerRegistration: registration
                        });
                        if (!token) return;
                        const response = await fetch(@js(route('notifications.storeToken')), {
                            method: 'POST', headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ device_token: token, device_type: 'web', device_name: navigator.userAgent })
                        });
                        if (!response.ok) throw new Error('Device token registration failed.');
                    } catch {
                        console.warn('Push registration failed. Check Firebase configuration and browser permission.');
                    }
                }
                if (Notification.permission === 'granted') enablePush();
                document.querySelector('.notification-bell')?.closest('button')?.addEventListener('click', enablePush);
                messaging.onMessage(payload => {
                    const notification = window.UpediaNotificationFeed.add(payload);
                    if (notification && Notification.permission === 'granted') {
                        registration.showNotification(notification.title, {
                            body: notification.message, icon: '/assets/images/logo-icon.png',
                            tag: window.location.origin + '-' + (notification.id || Date.now()),
                            data: { action_url: notification.actionUrl }
                        });
                    }
                });
            }).catch(() => console.warn('Firebase service worker setup failed.'));
    })();
</script>