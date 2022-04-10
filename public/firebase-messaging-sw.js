importScripts('https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js');
firebase.initializeApp({
    apiKey: "AIzaSyCsyzivLelJuTTP35aLoocq94hNCWwq0ZU",
    authDomain: "johnny-app-9d4c3.firebaseapp.com",
    projectId: "johnny-app-9d4c3",
    storageBucket: "johnny-app-9d4c3.appspot.com",
    messagingSenderId: "26716726425",
    appId: "1:26716726425:web:320a3001ca5663dda74408"
});
// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
if (firebase.messaging.isSupported()) {
    const messaging = firebase.messaging();
    messaging.onBackgroundMessage((payload) => {
        console.log('[firebase-messaging-sw.js] Received background message ', payload);
        // Customize notification here
        const notificationTitle = payload['data']['title'];
        const notificationOptions = {
            body: payload['data']['body'],
            // icon: '',
            // data: payload.data.redirect
        };
        return self.registration.showNotification(notificationTitle,
            notificationOptions);
    });

    self.addEventListener('notificationclick', function (event) {
        event.notification.close();
        event.waitUntil(self.clients.openWindow(event.notification.data));
    });
    messaging.usePublicVapidKey('BBMqaivadfJy3Eo1_2p-iZqck2VG44cT5PMCI5Aa2vvEwQNccRR9AW8a99KkI70dG50FM3A_KVcfwqntsSYJ7lI');
} else {
    console.log('Browser Not Supported For Messaging')
}
