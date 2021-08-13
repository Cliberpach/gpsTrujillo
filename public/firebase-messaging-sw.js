importScripts('https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.10/firebase-messaging.js');
var firebaseConfig = {
    apiKey: "AIzaSyD0io-INoYVoOFi85e8FCHwYN29aaqgst0",
    authDomain: "gpstracker-5b5ef.firebaseapp.com",
    projectId: "gpstracker-5b5ef",
    storageBucket: "gpstracker-5b5ef.appspot.com",
    messagingSenderId: "475656618234",
    appId: "1:475656618234:web:8915722c982dfb40668943"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
