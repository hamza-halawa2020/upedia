(() => {
    if (window.UpediaNotificationFeed) return;
    const seen = new Set(Array.from(document.querySelectorAll('.notification-item[data-id]'))
        .map(node => node.dataset.id).filter(Boolean));

    function safeUrl(value) {
        try {
            const url = new URL(value || '/notifications', window.location.origin);
            return ['http:', 'https:'].includes(url.protocol) ? url.href : '/notifications';
        } catch {
            return '/notifications';
        }
    }

    function element(tag, className, text) {
        const node = document.createElement(tag);
        node.className = className;
        if (text !== undefined) node.textContent = text;
        return node;
    }

    function add(payload) {
        const data = {...(payload.data || {}), ...(payload.notification || {})};
        const id = String(data.notification_id || payload.notification_id || payload.id || '');
        if (id && seen.has(id)) return null;
        if (id) {
            seen.add(id);
            if (seen.size > 500) seen.delete(seen.values().next().value);
        }
        const notification = {
            id,
            title: data.title || data.notification_title || payload.title || 'New Notification',
            message: data.message || data.body || data.notification_body || payload.message || '',
            actionUrl: safeUrl(data.action_url || payload.action_url),
        };
        const count = document.getElementById('notification-count');
        if (count) {
            count.textContent = String((parseInt(count.textContent, 10) || 0) + 1);
            count.style.display = '';
        }
        const list = document.getElementById('notification-list');
        if (list) {
            if (!list.querySelector('.notification-item')) list.replaceChildren();
            const item = element('div', 'notification-item px-24 py-12 mb-2 unread-notification');
            item.dataset.id = id;
            const row = element('div', 'd-flex align-items-start justify-content-between gap-3');
            const link = element('a', 'notification-link text-black hover-bg-transparent hover-text-primary d-flex align-items-start gap-3 text-decoration-none flex-grow-1');
            link.href = notification.actionUrl;
            const content = element('div', '');
            content.append(element('h6', 'text-md fw-semibold mb-4', notification.title),
                element('p', 'mb-0 text-sm text-secondary-light', notification.message));
            link.append(content);
            row.append(link, element('span', 'text-sm text-secondary-light flex-shrink-0', 'Just now'));
            item.append(row);
            list.prepend(item);
            while (list.children.length > 20) list.lastElementChild.remove();
        }
        window.dispatchEvent(new CustomEvent('upedia:notification-received', {detail: notification}));
        return notification;
    }

    window.UpediaNotificationFeed = {add};
})();
