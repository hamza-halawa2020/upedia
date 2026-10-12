<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>
<script>
    (() => {
        const status = window.UpediaPushStatus = { state: 'initializing', code: null, received: 0 };
        const fail = (state, error) => {
            status.state = state;
            status.code = String(error?.code || error?.name || 'unknown');
            console.warn('Firebase push:', status.state, status.code);
        };
        const settings = @js([
            'apiKey' => config('services.firebase.api_key'),
            'authDomain' => config('services.firebase.auth_domain'),
            'projectId' => config('services.firebase.project_id'),
            'messagingSenderId' => config('services.firebase.messaging_sender_id'),
            'appId' => config('services.firebase.app_id'),
        ]);
        if (!['apiKey', 'projectId', 'messagingSenderId', 'appId'].every(key => settings[key])) {
            fail('missing-configuration'); return;
        }
        if (!window.isSecureContext || !('serviceWorker' in navigator) || !('Notification' in window)) {
            fail('unsupported-context'); return;
        }
        navigator.serviceWorker.register('/firebase-messaging-sw.js?' + new URLSearchParams(settings))
            .then(async registration => {
                status.state = 'worker-registered';
                if (!firebase.apps.length) firebase.initializeApp(settings);
                const messaging = firebase.messaging();
                async function enablePush() {
                    try {
                        const permission = Notification.permission === 'granted'
                            ? 'granted' : await Notification.requestPermission();
                        if (permission !== 'granted') { status.state = 'permission-' + permission; return; }
                        const token = await messaging.getToken({
                            vapidKey: @js(config('services.firebase.vapid_key')),
                            serviceWorkerRegistration: registration
                        });
                        if (!token) { fail('missing-token'); return; }
                        const response = await fetch(@js(route('notifications.storeToken')), {
                            method: 'POST', headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ device_token: token, device_type: 'web', device_name: navigator.userAgent })
                        });
                        if (!response.ok) {
                            fail('token-save-failed', { code: 'http-' + response.status }); return;
                        }
                        status.state = 'ready';
                        status.code = null;
                    } catch (error) {
                        fail('registration-failed', error);
                    }
                }
                if (Notification.permission === 'granted') enablePush();
                document.querySelector('.notification-bell')?.closest('button')?.addEventListener('click', enablePush);
                messaging.onMessage(payload => {
                    status.received++;
                    const notification = window.UpediaNotificationFeed.add(payload);
                    if (notification && Notification.permission === 'granted') {
                        registration.showNotification(notification.title, {
                            body: notification.message, icon: '/assets/images/logo-icon.png',
                            tag: window.location.origin + '-' + (notification.id || Date.now()),
                            data: { action_url: notification.actionUrl }
                        });
                    }
                });
            }).catch(error => fail('worker-setup-failed', error));
    })();
</script>
