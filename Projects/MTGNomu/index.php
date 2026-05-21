<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MTG Nomu - Commander Room</title>
  <script type="module">
    // Firebase imports
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getFirestore, doc, setDoc, getDoc, updateDoc, onSnapshot } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";
    import { getAuth, signInAnonymously } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

    // ✅ Replace with your Firebase config
    const firebaseConfig = {
      apiKey: "AIzaSyBm4m-AxFT2-TDbvzEqWRJmdGtc2El89rw",
      authDomain: "mtg-nomu.firebaseapp.com",
      projectId: "mtg-nomu",
      storageBucket: "mtg-nomu.firebasestorage.app",
      messagingSenderId: "88928926906",
      appId: "1:88928926906:web:fba0615ac41ff38bad9683",
      measurementId: "G-EP48GPYE8S"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);
    const auth = getAuth(app);
    let userId = "";
    let currentRoomId = "";
    let currentPlayerSlot = "";

    signInAnonymously(auth).then(() => {
      console.log("Anon login success");
    });

    // ✅ Join room or rejoin with existing ID
    window.joinRoom = async function () {
      const roomId = document.getElementById("roomId").value.trim();
      const nickname = document.getElementById("nickname").value.trim().substring(0, 5);
      const existingId = document.getElementById("existingId").value.trim();

      if (!roomId || !nickname) {
        alert("Room ID and Nickname required");
        return;
      }

      currentRoomId = roomId;
      userId = existingId ? existingId : nickname + "_" + Math.random().toString(36).substring(2, 6);

      const roomRef = doc(db, "rooms", roomId);
      const roomSnap = await getDoc(roomRef);
      let players = {};

      if (roomSnap.exists()) {
        players = roomSnap.data().players || {};
      } else {
        await setDoc(roomRef, { players: {}, status: "waiting" });
      }

      let found = false;
      for (let i = 1; i <= 4; i++) {
        const slot = `p${i}`;
        if (players[slot] === userId) {
          currentPlayerSlot = slot;
          found = true;
          break;
        }
      }

      if (!found && !existingId) {
        for (let i = 1; i <= 4; i++) {
          const slot = `p${i}`;
          if (!players[slot]) {
            players[slot] = userId;
            currentPlayerSlot = slot;
            break;
          }
        }
        if (!currentPlayerSlot) {
          alert("Room is full.");
          return;
        }
        await updateDoc(roomRef, { players });
      } else if (!found && existingId) {
        alert("Your previous ID was not found in this room.");
        return;
      }

      document.getElementById("roomForm").style.display = "none";
      document.getElementById("playerInfo").style.display = "block";
      document.getElementById("roomDisplay").innerText = `Room: ${roomId}`;
      document.getElementById("playerIdDisplay").innerText = `You: ${userId}`;

      onSnapshot(roomRef, (docSnap) => {
        const data = docSnap.data();
        const players = data.players || {};
        const status = data.status || "waiting";

        const list = Object.values(players).map(p => `<li>${p}</li>`).join("");
        document.getElementById("playersList").innerHTML = `<ul>${list}</ul>`;
        document.getElementById("playerCount").innerText = `Players: ${Object.keys(players).length}/4`;

        let isFull = Object.keys(players).length === 4;

        if (isFull && currentPlayerSlot === "p1" && status === "waiting") {
          document.getElementById("startGameBtn").style.display = "inline-block";
        } else {
          document.getElementById("startGameBtn").style.display = "none";
        }

        if (status === "started") {
          document.getElementById("gameStatusMsg").innerHTML = "<b>🟢 Game Started!</b>";
        }
      });
    };

    // ✅ Start game (only P1 can do this)
    window.startGame = async function () {
      const roomRef = doc(db, "rooms", currentRoomId);
      await updateDoc(roomRef, { status: "started" });
    };

    // ✅ Exit room
    window.exitRoom = async function () {
      const confirmExit = confirm("Are you sure you want to exit the room?");
      if (!confirmExit) return;

      const roomRef = doc(db, "rooms", currentRoomId);
      const roomSnap = await getDoc(roomRef);
      if (roomSnap.exists()) {
        const players = roomSnap.data().players || {};
        for (let i = 1; i <= 4; i++) {
          const slot = `p${i}`;
          if (players[slot] === userId) {
            delete players[slot];
            break;
          }
        }
        await updateDoc(roomRef, { players });
      }

      location.reload();
    };
  </script>

  <style>
    body {
      font-family: sans-serif;
      padding: 20px;
    }
    #playerInfo {
      display: none;
      margin-top: 20px;
    }
    button {
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div id="roomForm">
    <h2>Join MTG Room</h2>
    <input id="roomId" placeholder="Room ID" />
    <input id="nickname" placeholder="Your Nickname (max 5 char)" maxlength="5" />
    <input id="existingId" placeholder="(Optional) Rejoin with Previous ID" />
    <button onclick="joinRoom()">Join</button>
  </div>

  <div id="playerInfo">
    <div id="roomDisplay"></div>
    <div id="playerIdDisplay"></div>
    <div id="playerCount"></div>
    <div id="playersList"></div>
    <div id="gameStatusMsg"></div>
    <button id="startGameBtn" onclick="startGame()" style="display:none;">Start Game</button>
    <button onclick="exitRoom()">Exit Room</button>
  </div>
</body>
</html>
