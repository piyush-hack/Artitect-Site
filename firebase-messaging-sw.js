// Scripts for firebase and firebase messaging
// Save this in Main Folder of your site
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing the generated config
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
    apiKey: "AIzaSyCktiqUfuf-_ysXjNtnnovjaDU1EzALeC4",
    authDomain: "notifications-bf0be.firebaseapp.com",
    projectId: "notifications-bf0be",
    storageBucket: "notifications-bf0be.appspot.com",
    messagingSenderId: "645834914244",
    appId: "1:645834914244:web:4730656c0debe8eb4bcc91",
    measurementId: "G-Z0G54WWBJF",
};

firebase.initializeApp(firebaseConfig);

// Retrieve firebase messaging
const messaging = firebase.messaging();

// messaging.onMessage((payload) => {
//   console.log('Message received. ', payload);
//   // ...
// });

messaging.onMessage((payload) => {
  console.log('Message received. ', payload);
  // ...
});

messaging.onBackgroundMessage(function(payload) {
  console.log('Received background message ', payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
  };

  self.registration.showNotification(notificationTitle,
    notificationOptions);
});