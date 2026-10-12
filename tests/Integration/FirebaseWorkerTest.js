async function verifyFirebaseWorker(source, evaluate = (code, globals) => {
    new Function(...Object.keys(globals), code)(...Object.values(globals));
}) {
    const callbacks = {}, shown = [], opened = [], order = [];
    let focused = 0;
    const worker = {
        location: { origin: 'https://upedia-all.test', href: 'https://upedia-all.test/firebase-messaging-sw.js?projectId=test' },
        addEventListener: (name, callback) => { order.push(name); callbacks[name] = callback; },
        skipWaiting: async () => {},
        registration: { showNotification: async (title, options) => shown.push({ title, options }) }
    };
    const firebase = {
        initializeApp() {},
        messaging: () => ({ onBackgroundMessage: callback => { callbacks.background = callback; } })
    };
    const clients = {
        claim: async () => {},
        matchAll: async () => [{ url: 'https://upedia-all.test/notifications', focus: async () => focused++ }],
        openWindow: async url => opened.push(url)
    };
    evaluate(source, { self: worker, firebase, clients, importScripts: () => order.push('import') });
    const assert = (condition, message) => { if (!condition) throw new Error(message); };
    assert(order[0] === 'notificationclick', 'Click handler must precede Firebase imports');
    await callbacks.background({ notification: { title: 'Automatically displayed' }, data: {} });
    assert(shown.length === 0, 'Notification payload must not display twice');
    await callbacks.background({ data: { title: 'Data message', message: 'Body', notification_id: 'test-id' } });
    assert(shown.length === 1 && shown[0].options.tag.endsWith('test-id'), 'Data-only message must display once with stable ID');
    let completion;
    callbacks.notificationclick({ notification: { close() {}, data: { action_url: '/notifications' } }, waitUntil: promise => completion = promise });
    await completion;
    assert(focused === 1 && opened.length === 0, 'Relative URL must focus existing page');
    callbacks.notificationclick({ notification: { close() {}, data: { action_url: 'javascript:alert(1)' } }, waitUntil: promise => completion = promise });
    await completion;
    assert(focused === 2 && opened.length === 0, 'Unsafe URL must fall back to notifications');
    return { tests: 5, passed: 5 };
}

if (typeof require === 'function' && require.main === module) {
    const fs = require('node:fs');
    const path = require('node:path');
    const source = fs.readFileSync(path.join(__dirname, '../../public/firebase-messaging-sw.js'), 'utf8');
    verifyFirebaseWorker(source).then(result => console.log(result)).catch(error => {
        console.error(error.message);
        process.exitCode = 1;
    });
}
