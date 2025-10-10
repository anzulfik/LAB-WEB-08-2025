// ======================
// VARIABLES & CONSTANTS
// ======================
let balance = 5000;
let currentBet = 0;
let deck = [];
let playerHand = [];
let botHand = [];
let discardPile = [];
let currentPlayer = 'player';
let wildCardPending = null;
let unoTimer = null;
let unoPressed = false;
let botUnoTimer = null;

const COLORS = ['red', 'blue', 'green', 'yellow'];
const VALUES = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'skip', 'reverse', 'draw2'];
const INITIAL_CARDS = 7;
const MIN_BET = 100;
const INITIAL_BALANCE = 5000;
const CARD_BACK_IMG = 'assets/back.png';

// ===============
// DECK MANAGEMENT
// ===============
//buat dan acak deck UNO
function createDeck() {
    const newDeck = [];
    COLORS.forEach(color => {
        newDeck.push({ color, value: '0' });
        for (let i = 1; i <= 9; i++) {
            newDeck.push({ color, value: i.toString() }, { color, value: i.toString() });
        }
        ['skip', 'reverse', 'draw2'].forEach(value => {
            newDeck.push({ color, value }, { color, value });
        });
    });
    for (let i = 0; i < 4; i++) {
        newDeck.push({ color: 'wild', value: 'wild' });
        newDeck.push({ color: 'wild', value: 'draw4' });
    }
    return shuffleDeck(newDeck);
}

//acak array (deck)
function shuffleDeck(deck) {
    for (let i = deck.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [deck[i], deck[j]] = [deck[j], deck[i]];
    }
    return deck;
}

//isi ulang deck dari pile kalo habis
function replenishDeck() {
    if (deck.length > 0) return;
    const topCard = discardPile.pop();
    deck = shuffleDeck(discardPile);
    discardPile = [topCard];
    updateStatus('Deck diisi ulang dari tumpukan kartu buangan!');
}

// ===================
// GAME INITIALIZATION
// ===================
//mulai permainan setelah pasang taruhan
function startGame() {
    const bet = parseInt(document.getElementById('betInput').value);
    if (!bet || bet < MIN_BET) {
        alert(`Taruhan minimal $${MIN_BET}!`);
        return;
    }
    if (bet > balance) {
        alert('Saldo tidak cukup!');
        return;
    }
    
    if (unoTimer) clearTimeout(unoTimer);
    if (botUnoTimer) clearTimeout(botUnoTimer);
    currentBet = bet;
    hideModal('betModal');
    showElement('gameBoard');
    
    //reset state permainan
    deck = createDeck();
    playerHand = [];
    botHand = [];
    discardPile = [];
    currentPlayer = 'player';
    
    //bagi kartu
    for (let i = 0; i < INITIAL_CARDS; i++) {
        playerHand.push(deck.pop());
        botHand.push(deck.pop());
    }
    
    //letakkan kartu pertama
    let firstCard = deck.pop();
    while (firstCard.color === 'wild' || firstCard.value === 'draw4' || firstCard.value === 'draw2' || firstCard.value === 'skip' || firstCard.value === 'reverse') {
        deck.push(firstCard);
        firstCard = deck.pop();
    }
    discardPile.push(firstCard);
    
    renderGame();
    updateStatus('Permainan Dimulai!');
    
    //jika kartu pertama adalah kartu aksi
    if (['skip', 'reverse', 'draw2'].includes(firstCard.value)) {
        setTimeout(() => executeCardAction(firstCard, 'player'), 1000);
    }
}

// ==============
// RENDERING & UI
// ==============
//render seluruh state game ke UI
function renderGame() {
    updateBalance();
    renderHand(playerHand, 'playerHand', playCard);
    renderHand(botHand, 'botHand', null);
    renderDiscardPile();
    updateCardCounts();
    checkUnoButton();
}

//render kartu di tangan pemain atau bot
function renderHand(hand, elementId, onClickCallback) {
    const handEl = document.getElementById(elementId);
    handEl.innerHTML = '';
    hand.forEach((card, index) => {
        const cardEl = onClickCallback ? 
            createCardElement(card, () => onClickCallback(index)) : 
            createCardBackElement();
        handEl.appendChild(cardEl);
    });
}

//render kartu teratas di discard pile
function renderDiscardPile() {
    const discardPileEl = document.getElementById('discardPile');
    discardPileEl.innerHTML = '';
    if (discardPile.length > 0) {
        const topCard = discardPile[discardPile.length - 1];
        discardPileEl.appendChild(createCardElement(topCard));
    }
}

//buat elemen DOM untuk sebuah kartu
function createCardElement(card, onClick = null) {
    const cardEl = document.createElement('div');
    cardEl.className = 'card';
    if (onClick) cardEl.onclick = onClick;
    const img = document.createElement('img');
    img.src = getCardImagePath(card);
    img.alt = `${card.value} ${card.color}`;
    cardEl.appendChild(img);
    return cardEl;
}

//Membuat elemen DOM untuk belakang kartu
function createCardBackElement() {
    const cardBack = document.createElement('div');
    cardBack.className = 'card-back';
    const img = document.createElement('img');
    img.src = CARD_BACK_IMG;
    img.alt = 'Card Back';
    cardBack.appendChild(img);
    return cardBack;
}

// ===============
// PLAYER ACTIONS
// ===============
//Aksi saat pemain memainkan kartu
function playCard(index) {
    if (currentPlayer !== 'player') return;

    const card = playerHand[index];
    const topCard = discardPile[discardPile.length - 1];

    if (card.value === 'draw4' && playerHand.some(c => canPlayCard(c, topCard) && c.value !== 'draw4')) {
        updateStatus('Wild +4 hanya bisa jika tidak ada kartu lain!');
        return;
    }
    if (!canPlayCard(card, topCard)) {
        updateStatus('Kartu tidak cocok!');
        return;
    }

    // Mainkan kartu
    playerHand.splice(index, 1);
    discardPile.push(card);
    resetUnoState();

    if (playerHand.length === 0) {
        endGame(true);
        return;
    }
    
    if (playerHand.length === 1) {
        unoTimer = setTimeout(() => {
            if (!unoPressed) {
                updateStatus('Lupa panggil UNO! Penalti +2 kartu.');
                drawCards(playerHand, 2);
                renderGame();
            }
        }, 5000);
    }

    renderGame();

    if (card.color === 'wild') {
        wildCardPending = card;
        showModal('colorModal');
    } else {
        executeCardAction(card, 'player');
    }
}

//Aksi saat pemain mengambil kartu
function drawCard() {
    if (currentPlayer !== 'player') return;
    replenishDeck();
    drawCards(playerHand, 1);
    resetUnoState();
    updateStatus('Anda ambil 1 kartu. Giliran Bot.');
    renderGame();
    switchTurn('bot');
}

//Aksi pemilihan warna untuk kartu Wild
function selectColor(color) {
    hideModal('colorModal');
    if (!wildCardPending) return;

    const card = wildCardPending;
    discardPile[discardPile.length - 1] = { ...card, color };
    wildCardPending = null;

    updateStatus(`Anda memilih warna ${color}.`);
    renderGame();
    setTimeout(() => executeCardAction(card, 'player'), 800);
}

// ======
// BOT AI
// ======
//logic untuk giliran Bot
function botTurn() {
    updateStatus('Bot sedang berpikir...');
    setTimeout(() => {
        const topCard = discardPile[discardPile.length - 1];
        const playableCards = botHand
            .map((card, index) => ({ card, index }))
            .filter(({ card }) => canPlayCard(card, topCard));

        const legalPlayable = playableCards.filter(({card}) => {
            if (card.value !== 'draw4') return true;
            return !botHand.some(c => canPlayCard(c, topCard) && c.value !== 'draw4');
        });

        if (legalPlayable.length > 0) {
            const { card, index } = legalPlayable[Math.floor(Math.random() * legalPlayable.length)];
            botHand.splice(index, 1);
            let finalCard = card;

            if (card.color === 'wild') {
                const chosenColor = COLORS[Math.floor(Math.random() * COLORS.length)];
                finalCard = { ...card, color: chosenColor };
                updateStatus(`Bot main ${card.value} & pilih ${chosenColor}.`);
            } else {
                updateStatus(`Bot memainkan ${card.value} ${card.color}.`);
            }

            discardPile.push(finalCard);

            if (botHand.length === 0) {
                renderGame();
                endGame(false);
                return;
            }

            if (botHand.length === 1) {
                showElement('callUnoOnBotBtn');
                botUnoTimer = setTimeout(() => {
                    updateStatus('🤖 Bot: UNO!');
                    hideElement('callUnoOnBotBtn');
                    botUnoTimer = null;
                }, 2000);
            }

            renderGame();
            executeCardAction(card, 'bot');
        } else {
            replenishDeck();
            drawCards(botHand, 1);
            updateStatus('Bot ambil 1 kartu. Giliran Anda!');
            renderGame();
            switchTurn('player');
        }
    }, 1500);
}

//Panggil UNO pada Bot
function callUnoOnBot() {
    if (botUnoTimer) {
        clearTimeout(botUnoTimer);
        botUnoTimer = null;

        updateStatus('Anda berhasil! Bot kena penalti +2 kartu.');
        drawCards(botHand, 2);
        hideElement('callUnoOnBotBtn');
        renderGame();
    }
}

// ====================
// CARD LOGIC & ACTIONS
// ====================
//Mengeksekusi efek kartu aksi (Skip, Reverse, Draw).
function executeCardAction(card, playedBy) {
    const opponent = playedBy === 'player' ? 'bot' : 'player';
    const opponentHand = opponent === 'bot' ? botHand : playerHand;
    let takeAnotherTurn = false;

    switch (card.value) {
        case 'skip':
        case 'reverse':
            updateStatus(`Giliran ${opponent} dilewati!`);
            takeAnotherTurn = true;
            break;
        case 'draw2':
            drawCards(opponentHand, 2);
            updateStatus(`${opponent} ambil 2 kartu!`);
            takeAnotherTurn = true;
            break;
        case 'draw4':
            drawCards(opponentHand, 4);
            updateStatus(`${opponent} ambil 4 kartu!`);
            takeAnotherTurn = true;
            break;
    }
    
    renderGame();

    if (takeAnotherTurn) {
        setTimeout(() => {
            updateStatus('Giliran Anda lagi!');
            if (playedBy === 'bot') botTurn();
            else currentPlayer = 'player';
        }, 1500);
    } else {
        switchTurn(opponent);
    }
}

//Mengganti giliran pemain
function switchTurn(nextPlayer) {
    currentPlayer = nextPlayer;
    if (nextPlayer === 'bot') {
        setTimeout(botTurn, 1000);
    } else {
        updateStatus('Giliran Anda!');
    }
}

//Logika validasi apakah kartu bisa dimainkan
function canPlayCard(card, topCard) {
    return card.color === 'wild' || card.color === topCard.color || card.value === topCard.value;
}

// ==========
// UNO SYSTEM
// ==========
//Menampilkan tombol UNO jika kartu pemain sisa 1
function checkUnoButton() {
    const unoBtn = document.getElementById('unoBtn');
    unoBtn.style.display = (playerHand.length === 1 && !unoPressed) ? 'inline-block' : 'none';
}

//batalkan efek penalty saat pemain menekan tombol UNO
function callUno() {
    if (playerHand.length === 1 && !unoPressed) {
        unoPressed = true;
        clearTimeout(unoTimer);
        document.getElementById('unoBtn').style.display = 'none';
        updateStatus('UNO! Anda tinggal 1 kartu!');
    }
}

//Mereset status UNO
function resetUnoState() {
    unoPressed = false;
    if (unoTimer) clearTimeout(unoTimer);
}

// ====================
// GAME END & UTILITIES
// ====================
//akhiri ronde dan menampilkan hasilnya
function endGame(playerWon) {
    if (playerWon) {
        balance += currentBet;
        setElementText('gameOverTitle', 'Anda Menang!');
        setElementText('gameOverMessage', `Anda memenangkan $${currentBet}. Saldo baru: $${balance}`);
    } else {
        balance -= currentBet;
        setElementText('gameOverTitle', 'Anda Kalah!');
        setElementText('gameOverMessage', `Anda kehilangan $${currentBet}. Saldo: $${balance}`);
    }

    if (balance <= 0) {
        setElementText('gameOverTitle', 'Game Over!');
        setElementText('gameOverMessage', 'Saldo Anda habis! Main lagi untuk reset.');
    }
    
    updateBalance();
    showModal('gameOverModal');
}

//eset game untuk ronde baru
function resetGame() {
    hideModal('gameOverModal');
    if (balance <= 0) balance = INITIAL_BALANCE;
    hideElement('gameBoard');
    showModal('betModal');
    document.getElementById('betInput').value = '';
    updateBalance();
}

//untuk mengambil beberapa kartu
function drawCards(hand, count) {
    for (let i = 0; i < count; i++) {
        replenishDeck();
        if (deck.length > 0) hand.push(deck.pop());
    }
}

//fungsi untuk mendapatkan path card
function getCardImagePath(card) {
    if (card.color === 'wild') {
        return card.value === 'draw4' ? 'assets/wild_draw4.png' : 'assets/wild.png';
    }
    return `assets/${card.value}_${card.color}.png`;
}

// helper DOM Functions
function updateBalance() {
    setElementText('balance', balance);
    setElementText('modalBalance', balance);
}
function updateCardCounts() {
    setElementText('playerCardCount', playerHand.length);
    setElementText('botCardCount', botHand.length);
}
function updateStatus(message) {
    document.getElementById('statusMessage').textContent = message; 
    console.log(message);
}
function setElementText(id, text) {
    document.getElementById(id).textContent = text;
}

function showElement(id) {
    document.getElementById(id).style.display = 'block'; 
}

function hideElement(id) {
    document.getElementById(id).style.display = 'none';
}

function showModal(id) {
    document.getElementById(id).classList.add('active');
}
function hideModal(id) {
    document.getElementById(id).classList.remove('active');
}

document.addEventListener('DOMContentLoaded', () => {
    updateBalance();
});