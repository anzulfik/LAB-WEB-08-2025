document.addEventListener('DOMContentLoaded', () => {    
    let state = {}; 
   
    const valueSymbols = {
        'SKIP': '🚫',
        'REV': '🔄',
        '+2': '+2',
        'WILD': '🎨',
        '+4': '+4'
    };

    const elements = {
        controlPanel: document.getElementById('control-panel'),
        colorPickerModal: document.getElementById('color-picker-modal'),
        unoAlert: document.getElementById('uno-alert'),
        balance: document.getElementById('balance'),
        gameMessages: document.getElementById('game-messages'),
        botHandDisplay: document.getElementById('bot-hand-display'),
        botCardCount: document.getElementById('bot-card-count'),
        playerHandDisplay: document.getElementById('player-hand-display'),
        playerCardCount: document.getElementById('player-card-count'),
        topCardContainer: document.getElementById('top-card-container'),
        deckPile: document.getElementById('deck-pile'),
        betInput: document.getElementById('bet-input'),
        startRoundBtn: document.getElementById('start-round-btn'),
        passTurnBtn: document.getElementById('pass-turn-btn'),
        unoBtn: document.getElementById('uno-btn'),
        callUnoBtn: document.getElementById('call-uno-btn'),
        colorOptions: document.querySelector('.color-options'),
    };

    function getCardImageUrl(card) {
        let color = card.color.toLowerCase();
        let value = card.value.toUpperCase();

        if (value === 'WILD') return 'assets/cards/wild.png';
        if (value === '+4') return 'assets/cards/plus_4.png';

        value = value.replace('+', 'plus').toLowerCase();
        return `assets/cards/${color}_${value}.png`;
    }

    function saveBalance() {
        localStorage.setItem('unoBalance', state.b+alance.toString());
    }
    function initializeGame() {
        state = {
            balance: localStorage.getItem('unoBalance') ? parseInt(localStorage.getItem('unoBalance')) : 5000,
            deck: [],
            playerHand: [],
            botHand: [],
            discardPile: [],
            turn: 'player',
            gameInProgress: false,
            activeColor: null,
            unoCallTimer: null,
            playerUnoCalled: false,
            botUnoCalled: false, 
            bet: 0, 
        };
        logMessage({ text: 'Klik "Mulai Ronde" untuk bermain.' });
        updateUI();
    }

    function startRound() {
        const bet = parseInt(elements.betInput.value); 
        if (isNaN(bet) || bet < 100) {
            alert('Taruhan minimal $100');
            return;
        }
        if (bet > state.balance) {
            alert('Saldo tidak mencukupi!');
            return;
        }
        
        state.bet = bet;
        state.gameInProgress = true;
        state.deck = createDeck();
        shuffle(state.deck); 
        state.playerHand = dealCards(7);
        state.botHand = dealCards(7);
        state.discardPile = []; 
        state.playerUnoCalled = false;
        state.botUnoCalled = false;

        let firstCard; 
        do {
            if (state.deck.length === 0) {
                state.deck = createDeck();
                shuffle(state.deck);
            }
            firstCard = state.deck.pop();
        } while (firstCard.color === 'black'); 
        
        state.discardPile.push(firstCard);
        state.activeColor = firstCard.color;
        state.turn = 'player';
        logMessage({ text: `Ronde dimulai. Taruhan $${state.bet}. Giliran Anda.` });
        updateUI();
    }

    function createDeck() {
        const colors = ['red', 'yellow', 'green', 'blue'];
        let deck = [];
        for (const color of colors) {
            deck.push({ color, value: '0' }); 
            for (let i = 1; i < 10; i++) {
                deck.push({ color, value: i.toString() });
                deck.push({ color, value: i.toString() });
            }
            ['SKIP', 'REV', '+2'].forEach(type => {
                deck.push({ color, value: type });
                deck.push({ color, value: type });
            });
        }
        for (let i = 0; i < 4; i++) { //kartu hitam
            deck.push({ color: 'black', value: 'WILD' });
            deck.push({ color: 'black', value: '+4' });
        }
        return deck;
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) { 
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]]; 
        }
    }

    function dealCards(num) { 
        let hand = [];
        for (let i = 0; i < num; i++) { 
            if(state.deck.length === 0) refillDeck(); 
            hand.push(state.deck.pop());
        }
        return hand;
    }

    function isCardPlayable(card) {
        const topCard = state.discardPile[state.discardPile.length - 1]; 
        return card.color === 'black' || card.color === state.activeColor || card.value === topCard.value;
    }

    function playCard(cardIndex, playedBy) {
        const hand = (playedBy === 'player') ? state.playerHand : state.botHand;
        if (state.turn !== playedBy || !state.gameInProgress) return; 

        const card = hand[cardIndex]; 
        if (!isCardPlayable(card)) {
            if(playedBy === 'player') alert('Kartu tidak cocok!');
            return;
        }

        hand.splice(cardIndex, 1); 
        state.discardPile.push(card);
        state.activeColor = card.color;

        // Reset UNO timer dan status
        clearTimeout(state.unoCallTimer); 
        elements.unoAlert.style.display = 'none';
        state.playerUnoCalled = false;
        state.botUnoCalled = false; 

        // Cek kondisi UNO / Kemenangan
        if (hand.length === 1) {
            if (playedBy === 'player') startUnoTimer(playedBy);
            else { 
                // Bot memiliki 50% kemungkinan untuk memanggil uno otomatis
                if (Math.random() < 0.5) {
                    state.botUnoCalled = true;
                    logMessage({ text: 'BOT: UNO!' });
                }
            }
        }
        
        // Cek Kemenangan
        if (hand.length === 0) {
            endRound(playedBy);
            return;
        }

        handleCardEffect(card, playedBy); 
    }

    function handleCardEffect(card, playedBy) {
        const nextTurnPlayer = playedBy === 'player' ? 'bot' : 'player';
        const playerName = playedBy === 'player' ? 'Anda' : 'Bot'; 
        const nextPlayerName = nextTurnPlayer === 'player' ? 'Anda' : 'Bot';

        if (card.color === 'black') {
            if (playedBy === 'player') {
                logMessage({ text: `Anda memainkan. <br>Pilih warna...`, card: card });
                elements.colorPickerModal.style.display = 'flex'; 
            } else { 
                state.activeColor = getBestColorForBot();
                let message = `Bot memainkan <span style="font-weight:700;">${card.value}</span> dan memilih warna <span style="font-weight:700;">${state.activeColor.toUpperCase()}</span>.`;
                
                let next = nextTurnPlayer;
                if (card.value === '+4') {
                    applyDraw(4, 'player');
                    message += `<br>Anda mengambil 4 kartu. Giliran Bot lagi.`;
                    next = playedBy; 
                } else {
                    message += `<br>Giliran Anda.`;
                }
                
                logMessage({ text: message, card: card });
                setTimeout(() => switchTurn(next), 1000); 
            }
        }   else { 
            let next = nextTurnPlayer;
            let message = `${playerName} memainkan <span style="font-weight:700;">${card.value}</span>.`;

            if (card.value === '+2') {
                applyDraw(2, nextTurnPlayer);
                message += `<br>${nextPlayerName} mengambil 2 kartu. Giliran ${playerName} lagi.`;
                next = playedBy; 
            } else if (card.value === 'SKIP' || card.value === 'REV') {
                message += `<br>Giliran ${nextPlayerName} dilewati. Giliran ${playerName} lagi.`;
                next = playedBy; 
            } else {
                message += `<br>Giliran ${nextPlayerName}.`;
            }

            logMessage({ text: message, card: card });

            setTimeout(() => {
                switchTurn(next);
            }, 800);
        }
        updateUI();
    }

    function applyDraw(count, targetPlayer) { 
        const hand = targetPlayer === 'player' ? state.playerHand : state.botHand;
        for(let i=0; i<count; i++) {
            if (state.deck.length === 0) refillDeck();
            hand.push(state.deck.pop()); 
        }
    }

    function switchTurn(nextPlayer) { 
        state.turn = nextPlayer;
        updateUI();
        if (state.turn === 'bot') {
            setTimeout(botTurn, 1500); 
        }
    }

    function botTurn() {
        const playableCards = state.botHand.map((card, index) => ({card, index})).filter(item => isCardPlayable(item.card)); //Baris ini mengubah setiap kartu milik bot menjadi objek baru yang menyimpan
        
        // Cek kondisi menang dulu sebelum bermain
        if (state.botHand.length === 0) {
            endRound('bot');
            return;
        }

        if (playableCards.length > 0) {
            const choice = playableCards[0]; 
            playCard(choice.index, 'bot');
        } else {
            if (state.deck.length === 0) refillDeck();
            const drawnCard = state.deck.pop();
            state.botHand.push(drawnCard); 
            logMessage({ text: 'Bot mengambil kartu.' });
            updateUI();

            if (isCardPlayable(drawnCard)) {
                 const newIndex = state.botHand.length - 1;
                 setTimeout(() => playCard(newIndex, 'bot'), 500);
            } else {
                 setTimeout(() => switchTurn('player'), 500);
            }
        }
    }

    function startUnoTimer(player) {
        if(player !== 'player') return;
        let timeLeft = 5;
        state.playerUnoCalled = false;
        elements.unoAlert.textContent = `UNO! Anda harus mengatakan UNO! Waktu tersisa: ${timeLeft}`;
        elements.unoAlert.style.display = 'block';
        
        if (state.unoCallTimer) clearInterval(state.unoCallTimer); 
        
        state.unoCallTimer = setInterval(() => {
            timeLeft--; 
            elements.unoAlert.textContent = `UNO! Anda harus mengatakan UNO! Waktu tersisa: ${timeLeft}`;
            if (timeLeft <= 0) { 
                clearInterval(state.unoCallTimer);
                elements.unoAlert.style.display = 'none';
                if (!state.playerUnoCalled) { 
                    alert('Terlambat! Anda tidak memanggil UNO. Penalti +2 kartu.');
                    applyDraw(2, 'player');
                    updateUI();
                }
            }
        }, 1000);
    }

    function refillDeck() {
        const top = state.discardPile.pop();
        state.deck = state.discardPile.map(card => card); 
        state.discardPile = [top];
        shuffle(state.deck);
    }

    function getBestColorForBot() { 
        const colorCount = {red:0, yellow:0, green:0, blue:0};
        state.botHand.forEach(c => { 
            if(c.color !== 'black') colorCount[c.color]++;
        });
        return Object.keys(colorCount).reduce((a, b) => colorCount[a] > colorCount[b] ? a : b);
    }

    function logMessage({ text, card = null }) {
        if (!text) return;
        
        elements.gameMessages.innerHTML = '';

        const logEntry = document.createElement('div'); 
        logEntry.className = 'log-entry'; 

        let html = `<span>${text}</span>`; 
        if (card) {
            const symbol = valueSymbols[card.value] || card.value;
            const cardColor = card.color === 'black' ? state.activeColor : card.color; 
            const isSymbolClass = valueSymbols[card.value] ? 'is-symbol' : '';
            const miniCardHTML = `<div class="mini-card ${cardColor} ${isSymbolClass}">${symbol}</div>`;
            html = `${miniCardHTML} ${html}`;
        }
        
        logEntry.innerHTML = html;
        elements.gameMessages.appendChild(logEntry); 
    }
    
    // LOGIKA END ROUND (DIPERBAIKI SALDO KEMENANGAN
    function endRound(winner) {
        if (!state.gameInProgress) return;
        
        state.gameInProgress = false;
        clearTimeout(state.unoCallTimer);
        elements.unoAlert.style.display = 'none';

        const playerWon = winner === 'player';
        const amount = state.bet;
        
        if (playerWon) {
            state.balance += amount;
            alert(`Anda MENANG ronde ini! Saldo bertambah +$${amount}`);
            logMessage({ text: `Anda MENANG! Saldo bertambah +$${amount} 🏆` }); 
        } else {
            state.balance -= amount;
            alert(`Anda KALAH ronde ini. Saldo berkurang -$${amount}`);
            logMessage({ text: `Anda KALAH! Saldo berkurang -$${amount} 😥` }); 
        }
        
        saveBalance(); 
        updateUI();   
        
        setTimeout(() => {
            initializeGame(); 
        }, 2000); 
    }

    function updateUI() {
        elements.balance.textContent = `$${state.balance}`; //saldo
        elements.startRoundBtn.disabled = state.gameInProgress;
        elements.passTurnBtn.disabled = !state.gameInProgress || state.turn !== 'player';
        elements.unoBtn.disabled = !state.gameInProgress || state.playerHand.length !== 1;
        elements.callUnoBtn.disabled = !state.gameInProgress || state.turn !== 'player';

        renderHand(state.playerHand, elements.playerHandDisplay, true);//Menampilkan ulang kartu
        renderHand(state.botHand, elements.botHandDisplay, false);
        elements.playerCardCount.textContent = state.playerHand.length;
        elements.botCardCount.textContent = state.botHand.length;

        elements.deckPile.innerHTML = `<img src="assets/cards/card_back.png" class="card-img" alt="Deck">`;

        elements.topCardContainer.innerHTML = '';
        if (state.discardPile.length > 0) {
            const topCard = state.discardPile[state.discardPile.length - 1];
            const displayCard = { ...topCard };
            if (topCard.color === 'black') {
                displayCard.color = state.activeColor || 'black';
            }
            const cardEl = createCardElement(displayCard, true);
            elements.topCardContainer.appendChild(cardEl);
        }
    }

    function renderHand(hand, container, isPlayer) { 
        container.innerHTML = ''; 
        hand.forEach((card, index) => {
            const el = isPlayer ? createCardElement(card, false, index) : createCardBackElement();
            if(isPlayer && isCardPlayable(card) && state.turn === 'player') {
                el.classList.add('playable');
            }
            container.appendChild(el); 
        });
    }

    function createCardElement(card, isTopCard, index) { 
        const el = document.createElement('div');
        el.className = `card ${card.color}`;
        el.dataset.index = index;
        const imgSrc = getCardImageUrl(card);
        el.innerHTML = `<img class="card-img" src="${imgSrc}" alt="${card.color} ${card.value}" onerror="this.style.display='none'">`;

        if(!isTopCard) {
            el.addEventListener('click', () => playCard(parseInt(el.dataset.index), 'player')); 
        }
        return el;
    }

    function createCardBackElement() { 
        const el = document.createElement('div');
        el.className = 'card-back';
        el.innerHTML = `<img class="card-img" src="assets/cards/card_back.png" alt="UNO card back">`;
        return el;
    }
    // EVENT LISTENERS (DIPERBAIKI SALDO UNO & DRAW)
    elements.startRoundBtn.addEventListener('click', startRound);
    
    elements.deckPile.addEventListener('click', () => {
        if (state.turn === 'player' && state.gameInProgress) {
            const canPlay = state.playerHand.some(isCardPlayable);
            
            // Player hanya bisa draw jika TIDAK ADA kartu yang bisa dimainkan (Aturan Umum)
            if (canPlay) {
                alert('Anda masih punya kartu yang bisa dimainkan! Anda harus memainkan kartu atau melewati giliran.');
                return;
            }
            
            if (state.deck.length === 0) refillDeck();
            const drawnCard = state.deck.pop();
            state.playerHand.push(drawnCard);
            logMessage({ text: 'Anda mengambil 1 kartu.' });
            
            // Cek dan Switch Turn
            if (isCardPlayable(drawnCard)) {
                 logMessage({ text: 'Kartu yang ditarik bisa dimainkan. Giliran Anda.' });
            } else {
                 logMessage({ text: 'Tidak ada kartu yang bisa dimainkan. Giliran Bot.' });
                 switchTurn('bot');
            }
            updateUI();
        }
    });

    elements.passTurnBtn.addEventListener('click', () => {
        if(state.turn === 'player' && state.gameInProgress) {
            const canPlay = state.playerHand.some(isCardPlayable);
            if (canPlay) {
                alert('Anda masih punya kartu yang bisa dimainkan! Anda tidak dapat melewati giliran.');
                return;
            }
            logMessage({ text: 'Anda melewati giliran.' });
            switchTurn('bot');
        }
    });
    
    // --- TOMBOL UNO (BONUS SALDO $100) ---
    elements.unoBtn.addEventListener('click', () => {
        if (state.playerHand.length === 1 && state.unoCallTimer && !state.playerUnoCalled) {
            state.playerUnoCalled = true;
            clearInterval(state.unoCallTimer);
            elements.unoAlert.style.display = 'none';
            
            state.balance += 100; // BONUS SALDO
            saveBalance();
            
            logMessage({ text: 'ANDA: UNO! Saldo bertambah +$100.' });
            updateUI(); 
        } else if (state.playerHand.length !== 1) {
            alert('Anda hanya bisa menekan UNO saat kartu Anda tinggal 1.');
        }
    });

    // --- TOMBOL CALL UNO (BONUS SALDO $100 & PENALTI) ---
    elements.callUnoBtn.addEventListener('click', () => {
        if (state.turn === 'player' && state.botHand.length === 1 && !state.botUnoCalled) {
            
            applyDraw(2, 'bot'); // PENALTI 2 KARTU UNTUK BOT
            
            state.balance += 100; // BONUS SALDO
            saveBalance();
            
            logMessage({ text: `Anda memanggil UNO pada Bot yang lupa! Bot kena penalti +2 kartu. Bonus +$100!` });
            updateUI();
        } else {
            logMessage({ text: 'Bot tidak lupa UNO atau tidak tinggal 1 kartu. Tidak ada efek.' });
        }
    });
    
    elements.colorOptions.addEventListener('click', (e) => {
        if(e.target.matches('.color-btn')) { 
            const color = e.target.dataset.color;
            const wildCard = state.discardPile[state.discardPile.length - 1];
            state.activeColor = color;
            
            elements.colorPickerModal.style.display = 'none';
            
            let nextPlayer = 'bot';
            let message = `Anda memilih warna <span style="font-weight:700;">${color.toUpperCase()}</span>.`;
            
            if (wildCard.value === '+4') {
                applyDraw(4, 'bot');
                message += `<br>Bot mengambil 4 kartu. Giliran Anda lagi.`;
                nextPlayer = 'player'; 
            } else { 
                message += `<br>Giliran Bot.`;
            }

            logMessage({ text: message });
            switchTurn(nextPlayer);
        }
    });

    initializeGame();
});