let playerHand = [];
let botHand = [];
let deck = [];
let discardPile = [];
let currentPlayer = "player";
let saldo = 5000;
let taruhan = 0;
let skipNextTurn = false;
let playerJustDrew = false;
let totalGames = 0;
let winStreak = 0;
let loseStreak = 0;
let playerUNO = false;
let botUNO = false;
let unoTimer = null;
let countdownInterval = null;

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

function recycleDeck() {
  if (deck.length === 0 && discardPile.length > 1) {
    const top = discardPile.pop();
    deck = shuffle(discardPile.slice());
    discardPile = [top];
  }
}

function drawFromDeck(count = 1) {
  const drawn = [];
  for (let i = 0; i < count; i++) {
    if (deck.length === 0) recycleDeck();
    if (deck.length === 0) break; 
    drawn.push(deck.pop());
  }
  return drawn;
}

function showMessage(msg, duration = 2000, color = "red") {
  const existing = document.getElementById("messagePopup");
  if (existing) existing.remove();

  const popup = document.createElement("div");
  popup.id = "messagePopup";
  popup.className = `fixed bottom-20 left-1/2 -translate-x-1/2 px-8 py-3 rounded-2xl text-white font-bold text-lg shadow-lg backdrop-blur-md border border-white/20 transform transition-all duration-500 opacity-0 scale-90 z-50`;

  const colorMap = {
    red: "bg-gradient-to-r from-red-400/40 to-red-700/40 shadow-[0_0_20px_rgba(239,68,68,0.5)]",
    green: "bg-gradient-to-r from-green-400/40 to-green-700/40 shadow-[0_0_20px_rgba(74,222,128,0.5)]",
    blue: "bg-gradient-to-r from-blue-400/40 to-blue-700/40 shadow-[0_0_20px_rgba(59,130,246,0.5)]",
    yellow: "bg-gradient-to-r from-yellow-400/40 to-yellow-700/40 shadow-[0_0_20px_rgba(250,204,21,0.5)]",
    gray: "bg-gradient-to-r from-gray-400/30 to-gray-700/30 shadow-[0_0_20px_rgba(156,163,175,0.5)]",
  };

  popup.classList.add(...colorMap[color].split(" "));
  popup.innerText = msg;

  document.body.appendChild(popup);

  setTimeout(() => {
    popup.classList.remove("opacity-0", "scale-90");
    popup.classList.add("opacity-100", "scale-100");
  }, 50);

  setTimeout(() => {
    popup.classList.remove("opacity-100", "scale-100");
    popup.classList.add("opacity-0", "scale-90");
    setTimeout(() => popup.remove(), 400);
  }, duration);
}

function generateDeck() {
  const colors = ["red", "yellow", "green", "blue"];
  const deck = [];

  colors.forEach(color => {
    for (let i = 0; i <= 9; i++) deck.push({ type: "number", value: i, color });
    ["skip", "reverse", "draw2"].forEach(action =>
      deck.push({ type: "action", value: action, color })
    );
  });

  for (let i = 0; i < 4; i++) {
    deck.push({ type: "wild", value: "wild" });
    deck.push({ type: "wild", value: "draw4" });
  }

  return shuffle(deck);
}

function startGame() {
  taruhan = parseInt(document.getElementById("taruhan").value);
  if (isNaN(taruhan) || taruhan < 100 || taruhan > saldo) {
    showCenterPopup("Taruhan minimal 100 dan maksimal saldo anda!");
    return;
  }

  deck = generateDeck();
  playerHand = deck.splice(0, 7);
  botHand = deck.splice(0, 7);

  let firstCard;
  do {
    firstCard = deck.pop();
  } while (firstCard.type !== "number");
  discardPile = [firstCard];

  currentPlayer = "player";
  playerUNO = false;
  botUNO = false;

  updateUI();
}

function canPlay(card, topCard, hand) {
  if (card.type === "wild" && card.value === "draw4") {
    const hasOtherPlayable = hand.some(
      c =>
        c !== card &&
        (c.color === topCard.color || c.value === topCard.value || c.type === "wild" && c.value === "wild")
    );
    if (hasOtherPlayable) return false;
  }

  return (
    card.color === topCard.color ||
    card.value === topCard.value ||
    card.type === "wild"
  );
}

function botTriggerUNO() {
  if (window.botUnoTimeout) {
    clearTimeout(window.botUnoTimeout);
    window.botUnoTimeout = null;
  }

  window.botUnoTimeout = setTimeout(() => {
    if (!botUNO && botHand.length === 1) {
      botUNO = true;
      showCenterPopup("Bot memanggil UNO!", "red", 1400);
    }
    window.botUnoTimeout = null;
    updateUI();
  }, 2000);
}

function playCard(cardIndex, player = "player") {
  let hand = player === "player" ? playerHand : botHand;
  const card = hand[cardIndex];
  const topCard = discardPile[discardPile.length - 1] || null;

  if (!card) return;
  if (!canPlay(card, topCard, hand)) {
    if (player === "player") showMessage("Kartu tidak bisa dimainkan!");
    return;
  }

  delete card.justDrawn;

  hand.splice(cardIndex, 1);
  discardPile.push(card);

  if (hand.length === 1 && player === "bot") {
    botTriggerUNO();
  } else if (hand.length === 1 && player === "player") {
    showUNOButton();
  }

  if (card.type === "action") {
    if (card.value === "skip" || card.value === "reverse") {
      skipNextTurn = true;
    } else if (card.value === "draw2") {
      recycleDeck();
      const draw = drawFromDeck(2);
      if (player === "player") botHand.push(...draw);
      else playerHand.push(...draw);
      skipNextTurn = true;
    }
  } else if (card.type === "wild") {
    if (card.value === "draw4") {
      recycleDeck();
      const draw = drawFromDeck(4);
      if (player === "player") botHand.push(...draw);
      else playerHand.push(...draw);
      skipNextTurn = true;
    }

    if (player === "player") {
      updateUI();
      showColorPicker(card);
      return;
    } else {
      const colors = ["red", "yellow", "green", "blue"];
      card.color = colors[Math.floor(Math.random() * colors.length)];
    }
  }
    if (player === "player") {
    showGameStatus({ player, action: "playCard", card });
  } else {
    showGameStatus({ player, action: "playCard", card });
  }

  checkWin();

  if (playerHand.length > 0 && botHand.length > 0) {
    currentPlayer = player === "player" ? "bot" : "player";

    if (skipNextTurn) {
      skipNextTurn = false;
      currentPlayer = player; 
      showGameStatus({ player, action: "skip" });
    }

    updateUI();

    if (currentPlayer === "bot") {
      setTimeout(botTurn, 800);
    }
  }
}

function showColorPicker(card) {
  const existing = document.getElementById("colorPickerBox");
  if (existing) existing.remove();

  const picker = document.createElement("div");
  picker.id = "colorPickerBox";
  picker.className = `fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex gap-4 justify-center items-center px-6 py-5 rounded-3xl bg-white/15 backdrop-blur-xl border border-white/30 shadow-[0_0_25px_rgba(255,255,255,0.2)] scale-0 transition-transform duration-300 z-50`;

  const colors = [
    { name: "red", class: "bg-gradient-to-br from-red-500 to-red-700" },
    { name: "yellow", class: "bg-gradient-to-br from-yellow-300 to-yellow-500" },
    { name: "green", class: "bg-gradient-to-br from-green-500 to-green-700" },
    { name: "blue", class: "bg-gradient-to-br from-blue-500 to-blue-700" },
  ];

  colors.forEach(c => {
    const btn = document.createElement("button");
    btn.className = `w-16 h-16 rounded-2xl ${c.class} shadow-lg border-2 border-white/40 hover:scale-110 hover:shadow-xl transition-all duration-200`;
    btn.setAttribute("data-color", c.name);
    picker.appendChild(btn);

      btn.onclick = () => {
      card.color = c.name;
      showGameStatus({ player: "player", action: "chooseColor", color: c.name });
      picker.remove();
      continueAfterWildCard();
    };
  });

  document.body.appendChild(picker);

  setTimeout(() => {
    picker.classList.remove("scale-0");
    picker.classList.add("scale-100");
  }, 50);
}

function showGameStatus({player, action, card, color}) {
  const container = document.getElementById("colorStatusContainer");
  if (!container) return;

  const msg = document.createElement("div");
  msg.className = "bg-black/40 text-white font-bold px-4 py-2 rounded-xl text-lg flex items-center mt-12 gap-2 opacity-0 transition-all duration-300";

  const playerName = player === "player" ? "Player" : "Bot";
  let text = "";

  switch(action) {
    case "chooseColor":
      text = `${playerName} memilih warna: <span class="font-bold" style="color:${color}">${color}</span>`;
      break;
    case "playCard":
      text = `${playerName} menurunkan kartu: <span class="font-bold">${card.value} ${card.color || ""}</span>`;
      break;
    case "skip":
      text = `${playerName} skip giliran`;
      break;
    case "drawCard":
      text = `${playerName} menarik kartu`;
      break;
    default:
      text = `${playerName} melakukan aksi: ${action}`;
  }

  msg.innerHTML = text;
  container.appendChild(msg);

  setTimeout(() => { msg.style.opacity = 1; }, 50);
  setTimeout(() => {
    msg.style.opacity = 0;
    setTimeout(() => msg.remove(), 300);
  }, 2000);
}

function showCenterPopup(msg, color = "green", duration = 2000) {
  const existing = document.getElementById("centerPopup");
  if (existing) existing.remove();

  const popup = document.createElement("div");
  popup.id = "centerPopup";
  popup.className = `fixed inset-0 flex items-center justify-center z-50 pointer-events-none`;

  const colorMap = {
    green: "from-green-400/30 to-green-700/30 shadow-[0_0_25px_rgba(74,222,128,0.5)]",
    red: "from-red-400/30 to-red-700/30 shadow-[0_0_25px_rgba(239,68,68,0.5)]",
    yellow: "from-yellow-400/30 to-yellow-700/30 shadow-[0_0_25px_rgba(250,204,21,0.5)]",
    blue: "from-blue-400/30 to-blue-700/30 shadow-[0_0_25px_rgba(96,165,250,0.5)]",
  };

  const colorStyle = colorMap[color] || colorMap.green;

  popup.innerHTML = `<div class="px-10 py-6 rounded-3xl text-3xl font-extrabold text-white bg-gradient-to-br ${colorStyle} backdrop-blur-lg border border-white/20 shadow-xl scale-0 transform transition-all duration-500 tracking-wide"> ${msg}
    </div>`;

  document.body.appendChild(popup);

  const box = popup.firstElementChild;
  setTimeout(() => {
    box.classList.remove("scale-0");
    box.classList.add("scale-100");
  }, 50);

  setTimeout(() => {
    box.classList.remove("scale-100");
    box.classList.add("scale-0");
    setTimeout(() => popup.remove(), 500);
  }, duration);
}

function checkWin() {
  if (playerHand.length === 0) {
    saldo += taruhan;
    updateUI();
    showCenterPopup("Anda Menang!", "green", 2500);

    winStreak++;
    loseStreak = 0;
    totalGames++;
    checkAchievement("win");

    setTimeout(() => {
      resetGame();
    }, 2500);
  } 
  else if (botHand.length === 0) {
    saldo -= taruhan;
    updateUI();
    showCenterPopup("Bot Menang!", "red", 2500);

    loseStreak++;
    winStreak = 0;
    totalGames++;
    checkAchievement("lose");

    if (saldo <= 0) {
      setTimeout(() => showCenterPopup("Game Over!", "red", 3000), 100);
      saldo = 5000;
      updateUI();
    }
    setTimeout(() => {
      resetGame();
    }, 2500);
  }
}

function continueAfterWildCard() {
  checkWin();

  if (playerHand.length > 0 && botHand.length > 0) {
    if (skipNextTurn) {
      skipNextTurn = false;
      updateUI();
      if (currentPlayer === "bot") setTimeout(botTurn, 1000);
    } else {
      currentPlayer = currentPlayer === "player" ? "bot" : "player";
      updateUI();
      if (currentPlayer === "bot") setTimeout(botTurn, 1000);
    }
  }
}

function botTurn() {
  recycleDeck();

  if (!botHand || botHand.length === 0) {
    currentPlayer = "player";
    updateUI();
    return;
  }

  const topCard = discardPile[discardPile.length - 1] || null;
  let playableIndex = -1;

  for (let i = 0; i < botHand.length; i++) {
    const card = botHand[i];
    if (canPlay(card, topCard, botHand)) {
      playableIndex = i;
      break;
    }
  }

  if (playableIndex !== -1) {
    playCard(playableIndex, "bot");
    return;
  }

  const drawn = drawFromDeck(1);
  if (drawn.length === 0) {
    showCenterPopup("⚠️ Kartu habis! Kartu akan di-shuffle.", "yellow", 2000);
    recycleDeck();
    
    const redrawn = drawFromDeck(1);

  botHand.push(...redrawn);
  updateUI();

  const newCard = botHand[botHand.length - 1];
  if (canPlay(newCard, topCard, botHand)) {
    setTimeout(() => playCard(botHand.length - 1, "bot"), 800);
  } else {
    currentPlayer = "player";
    updateUI();
  }
  return;
  }

  botHand.push(...drawn);
  updateUI();

  const newCard = botHand[botHand.length - 1];
  if (canPlay(newCard, topCard, botHand)) {
    setTimeout(() => playCard(botHand.length - 1, "bot"), 800);
  } else {
    currentPlayer = "player";
    updateUI();
  }
}

function drawCard(player, endTurn = false) {
  recycleDeck();
  let drawn = drawFromDeck(1);

  if (drawn.length === 0) {
    showCenterPopup("⚠️ Kartu habis! kartu akan di-shuffle", "yellow", 2000);
    recycleDeck();

    drawn = drawFromDeck(1); 
  }

  const card = drawn[0];

  if (player === "player") {
    card.justDrawn = true;
    playerHand.push(card);
    updateUI();

    const topCard = discardPile[discardPile.length - 1] || null;
    playerJustDrew = true;

    if (canPlay(card, topCard, playerHand)) {
      showMessage("Kamu boleh menurunkan kartu yang baru diambil atau tekan 'Lewati'.", 3500);
    } else {
      showMessage("Kartu tidak bisa dimainkan. Tekan 'Lewati' untuk mengakhiri giliran.", 3000);
    }
    return;

  } else {
    botHand.push(card);
    updateUI();

    if (player === "player") {
      showGameStatus({ player, action: "drawCard" });
    } else {
      showGameStatus({ player, action: "drawCard" });
    }

    if (endTurn) {
      currentPlayer = "player";
      updateUI();
    }
  }
}

function skipTurn() {
  showGameStatus({ player: "player", action: "skip" });
  currentPlayer = "bot";
  updateUI();
  setTimeout(botTurn, 1000);
}

function resetGame() {
  if (window.botUnoTimeout) {
    clearTimeout(window.botUnoTimeout);
    window.botUnoTimeout = null;
  }
  if (countdownInterval) {
    clearInterval(countdownInterval);
    countdownInterval = null;
  }
  if (unoTimer) {
    clearTimeout(unoTimer);
    unoTimer = null;
  }

  deck = [];
  discardPile = [];
  playerHand = [];
  botHand = [];
  currentPlayer = "player";
  playerUNO = false;
  botUNO = false;

  updateUI();
}

function showUNOButton() {
  playerUNO = false;
  clearTimeout(unoTimer);
  if (countdownInterval) clearInterval(countdownInterval);
  if (playerUNO) return;

  const overlay = document.createElement("div");
  overlay.id = "unoCountdownOverlay";
  overlay.className = `fixed inset-0 flex items-center justify-center z-[9999] pointer-events-none`;

  const countdownNum = document.createElement("div");
  countdownNum.id = "countdownNumber";
  countdownNum.className = `text-[160px] font-extrabold text-blue-950 drop-shadow-lg animate-pulse select-none`;
  countdownNum.textContent = "5";

  overlay.appendChild(countdownNum);
  document.body.appendChild(overlay);

  let countdown = 5;
  countdownInterval = setInterval(() => {
    countdown--;
    if (countdownNum) countdownNum.textContent = countdown;

    if (countdown <= 0) {
      clearInterval(countdownInterval);
      overlay.remove();
      if (!playerUNO && playerHand.length === 1) {
        showCenterPopup("⚠️ Anda lupa UNO! Tambah 2 kartu.", "yellow", 2500);
        recycleDeck();
        playerHand.push(...deck.splice(0, 2));
        updateUI();
      }
    }
  }, 1000);
}

function callUNO() {
  if (playerHand.length === 1 && !playerUNO) {
    playerUNO = true;
    showCenterPopup("UNO!", "blue", 2000);

    clearInterval(countdownInterval);
    const overlay = document.getElementById("unoCountdownOverlay");
    if (overlay) overlay.remove();
    return;
  }

  if (botHand.length === 1 && !botUNO && window.botUnoTimeout) {
    clearTimeout(window.botUnoTimeout);
    window.botUnoTimeout = null;

    showCenterPopup("Bot lupa panggil UNO!", "red", 2000);
    recycleDeck();
    const draws = drawFromDeck(2);
    botHand.push(...draws);

    botUNO = false;

    updateUI();
    return;
  }
}

let achievements = {
  first_win: false,
  first_lose: false,
  three_win: false,
  three_lose: false,
};

function unlockAchievement(key, msg) {
  if (!achievements[key]) {
    achievements[key] = true;
    updateAchievementPanel();
    showAchievement(msg);
  }
}

function checkAchievement(result) {
  if (totalGames === 1 && result === "win")
    unlockAchievement("Ibu Kamu Pasti Bangga", "Ibu Kamu Pasti Bangga");
  if (totalGames === 1 && result === "lose")
    unlockAchievement("Skill Issue", "Skill Issue");
  if (winStreak === 3) unlockAchievement("Sepuh UNO", "Sepuh UNO");
  if (loseStreak === 3) unlockAchievement("Beban Kelompok", "Beban Kelompok");
}

function updateAchievementPanel() {
  const list = document.getElementById("achievementList");
  list.innerHTML = "";
  for (const key in achievements) {
    if (achievements[key]) {
      const li = document.createElement("li");
      li.className = "text-yellow-300 font-bold";
      li.textContent = key.replace(/_/g, " ");
      list.appendChild(li);
    }
  }
}

function showAchievement(msg) {
  const box = document.getElementById("achievementBox");
  if (!box) return;

  const toast = document.createElement("div");
  toast.className = `flex items-center gap-2 px-5 py-3 mb-2 rounded-2xl text-yellow-200 font-semibold text-base shadow-lg backdrop-blur-md border border-yellow-300/30 bg-gradient-to-r from-yellow-400/30 to-yellow-600/30
                    shadow-[0_0_20px_rgba(250,204,21,0.3)] transform transition-all duration-500 opacity-0 translate-x-10`;

  toast.innerHTML = `🏆 <span>${msg}</span>`;
  box.appendChild(toast);

  setTimeout(() => {
    toast.classList.remove("opacity-0", "translate-x-10");
    toast.classList.add("opacity-100", "translate-x-0");
  }, 50);

  setTimeout(() => {
    toast.classList.remove("opacity-100", "translate-x-0");
    toast.classList.add("opacity-0", "translate-x-10");
    setTimeout(() => toast.remove(), 500);
  }, 3500);
}

function renderCard(card, index, owner) {
  const clickable = owner === "player" ? `onclick="playCard(${index}, 'player')"` : "";

  let imgSrc = "asset/back-card.png"; 

  if (owner !== "bot" && card && card.type) {
    if (card.type === "wild") {
      imgSrc = card.value === "draw4" ? "asset/card-+4-wild.png" : "asset/card-wild.png";
    } else {
      imgSrc = `asset/card-${card.value}-${card.color}.png`;
    }
  }

  if (owner === "player") {
  return `
    <div class="relative inline-block -ml-16 first:ml-0 transition-transform duration-300 hover:-translate-y-5 hover:scale-100 hover:z-50" style="z-index: ${index + 10};">
      <img ${clickable} src="${imgSrc}" alt="${card ? card.value : 'back'}" class="w-[120px] h-[120px] rounded-xl object-contain select-none cursor-pointer">
    </div>
  `;
}

  if (owner === "bot") {
    const spacing = 40; 
    const totalCards = botHand.length;
    const offset = index - (totalCards - 1) / 2;
    const translateX = offset * spacing;

    return `
      <div class="absolute transition-all duration-200" style="left: 50%; transform: translateX(calc(-50% + ${translateX}px)); z-index: ${index};">
        <img src="asset/back-card.png" class="w-[100px] h-[100px] rounded-lg object-contain select-none">
      </div>
    `;
  }

  const rotation = (Math.random() - 0.5) * 25;
  const translateX = (Math.random() - 0.5) * 15;
  const translateY = (Math.random() - 0.5) * 15;

  return `
    <div class="absolute" style="transform: rotate(${rotation}deg) translateX(${translateX}px) translateY(${translateY}px); z-index: ${index};">
      <img src="${imgSrc}" alt="${card ? card.value : 'back'}" class="w-[120px] h-[120px] rounded-xl object-contain select-none">
    </div>
  `;
}

function updateButtons() {
  const unoBtn = document.getElementById("unoButton");
  const skipBtn = document.getElementById("skipButton");
  const callBtn = document.getElementById("callUNOButton");

  callBtn.disabled = !(botHand.length === 1 && !botUNO);
  unoBtn.disabled = playerHand.length !== 1;
  skipBtn.disabled = !(currentPlayer === "player" && playerHand[playerHand.length - 1]?.justDrawn);
}

function updateUI() {
  document.getElementById("playerHand").innerHTML = playerHand
    .map((c, i) => renderCard(c, i, "player"))
    .join("");
  
  const discardHTML = discardPile.slice(-5).map((c, i) => renderCard(c, i, "discard")).join("");
  document.getElementById("discardPile").innerHTML = discardHTML;
  
  document.getElementById("botHand").innerHTML = botHand
    .map((c, i) => renderCard(c, i, "bot"))
    .join("");
  
  document.getElementById("saldo").innerText = `$${saldo}`;

  updateAchievementPanel();
  updateButtons();
}

window.addEventListener("DOMContentLoaded", () => {
  const unoBtn = document.getElementById("unoButton");
  const skipBtn = document.getElementById("skipButton");
  const callBtn = document.getElementById("callUNOButton");
  const drawPile = document.getElementById("drawPile");
  const playerArea = document.getElementById("playerHand");
  const botArea = document.getElementById("botHand");
  const controlArea = document.getElementById("controlButtons");

  if (playerArea) playerArea.style.marginTop = "40px";
  if (botArea) botArea.style.marginBottom = "40px";
  if (controlArea) controlArea.style.marginTop = "30px";

  unoBtn.onclick = () => callUNO();

  skipBtn.onclick = () => {
    if (currentPlayer === "player") {
      playerHand.forEach(c => delete c.justDrawn);
      skipTurn();
    }
  };
  
  callBtn.onclick = () => callUNO();

  drawPile.onclick = () => {
    if (currentPlayer === "player") {
      drawCard("player", false);
    }
  };
});