@auth
    @if(config('broadcasting.default') === 'reverb' && config('broadcasting.connections.reverb.key'))
        <script src="{{ asset('assets/js/lib/pusher.min.js') }}"></script>
        <script>
            (() => {
                if (window.UpediaRealtime || !window.Pusher) return;
                const settings = @js([
                    'key' => config('broadcasting.connections.reverb.key'),
                    'host' => config('broadcasting.connections.reverb.options.host'),
                    'port' => (int) config('broadcasting.connections.reverb.options.port'),
                    'tls' => config('broadcasting.connections.reverb.options.scheme') === 'https',
                    'channel' => 'private-App.Models.User.' . auth()->id(),
                ]);
                if (location.protocol === 'https:' && !settings.tls) {
                    console.warn('Realtime requires WSS on an HTTPS page. Configure Reverb TLS before subscribing.');
                    return;
                }
                const client = new Pusher(settings.key, {
                    cluster: 'mt1', wsHost: settings.host, wsPort: settings.port, wssPort: settings.port,
                    forceTLS: settings.tls, enabledTransports: ['ws', 'wss'], disableStats: true,
                    channelAuthorization: {
                        endpoint: '/broadcasting/auth', transport: 'ajax',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }
                });
                const channel = client.subscribe(settings.channel);
                channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', payload => {
                    window.UpediaNotificationFeed.add(payload);
                });
                channel.bind('pusher:subscription_succeeded', () => {
                    window.dispatchEvent(new CustomEvent('upedia:realtime-ready'));
                });
                channel.bind('pusher:subscription_error', () => console.warn('Realtime channel authorization failed.'));
                client.connection.bind('error', () => console.warn('Realtime connection failed. Check Reverb.'));
                window.UpediaRealtime = client;
                window.addEventListener('pagehide', () => client.disconnect());
            })();
        </script>
    @endif
@endauth