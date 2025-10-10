const COLORS = ['blue','green','red','yellow'];
const NUMBERS = ['0','1','2','3','4','5','6','7','8','9'];
const ACTIONS = ['skip','reverse','plus2'];
const WILDS = [{type:'wild',file:'wild.png'},{type:'wild4',file:'plus_4.png'}];

let state = {
  deck: [], discard: [], playerHand: [], botHand: [],
  turn: 'player', balance: 5000, bet: 100,
  gameActive: false, playerSaidUno: false, botSaidUno: false,
  playerUnoTimer: null, botUnoTimer: null,
  pendingPlay: null, activeColor: null
};

const el = {};
document.querySelectorAll('[id]').forEach(e => el[e.id] = e);
el.colorButtons = document.querySelectorAll('.color-btn');

function log(msg){
  const t = new Date().toLocaleTimeString();
  el.log.innerHTML = `<div>[${t}] ${msg}</div>` + el.log.innerHTML;
}
function shuffle(a){ for(let i=a.length-1;i>0;i--){ const j=Math.floor(Math.random()*(i+1)); [a[i],a[j]]=[a[j],a[i]] } return a; }
const isWildCard = (card) => card.type === 'wild' || card.type === 'wild4';
const getTopCard = () => state.discard[state.discard.length-1];
const cardText = (c) => c ? `${c.color} ${c.value}`.toUpperCase() : '-';

function buildDeck(){
  const d = [];
  COLORS.forEach(color => {
    NUMBERS.forEach(n => d.push({id:`${color}_${n}`, color, type:'number', value:n, img:`./${color}_${n}.png`}));
    ACTIONS.forEach(a => d.push({id:`${color}_${a}`, color, type:'action', value:a, img:`./${color}_${a}.png`}));
  });
  WILDS.forEach(w => d.push({id:w.type, color:'black', type:w.type, value:w.type==='wild4'? 'WILD':'+4', img:`./${w.file}`}));
  return shuffle(d);
}

function startRound(){
  const betVal = parseInt(el.bet.value) || 0;
  if(betVal < 100){ return alert('Taruhan minimal $100'); }
  if(betVal > state.balance){ return alert('Taruhan melebihi saldo'); }

  Object.assign(state, {
    bet: betVal, deck: buildDeck(), discard: [], playerHand: [], botHand: [],
    playerSaidUno: false, botSaidUno: false, pendingPlay: null, activeColor: null,
    gameActive: true, turn: 'player'
  });

  for(let i=0; i<7; i++){
    state.playerHand.push(state.deck.pop());
    state.botHand.push(state.deck.pop());
  }

  let topCard = state.deck.pop();
  while(topCard && topCard.type === 'wild4'){
    state.deck.unshift(topCard);
    shuffle(state.deck);
    topCard = state.deck.pop();
  }
  if (topCard) state.discard.push(topCard);

  if (topCard) {
    if (isWildCard(topCard)) {
      state.activeColor = COLORS[Math.floor(Math.random()*COLORS.length)];
      log(`Kartu awal WILD. Warna aktif default: ${state.activeColor.toUpperCase()}.`);
    } else {
      state.activeColor = topCard.color;
    }
  }

  log(`Ronde dimulai. Taruhan $${state.bet}. Kartu teratas: ${cardText(getTopCard())}`);
  render();
}


function render(){
  el.balance.textContent = state.balance;
  el.deckCount.textContent = state.deck.length;
  el.botCount.textContent = state.botHand.length;
  el.playerUno.textContent = state.playerSaidUno ? 'UNO!' : '-';
  el.botUno.textContent = state.botSaidUno ? 'UNO!' : '-';

  const top = getTopCard();

  el.discard.innerHTML = top ? `<div class="card"><img src="${top.img}" alt="${top.id}" onerror="this.outerHTML='<div style=&quot;padding:8px&quot; class=&quot;muted&quot;>${cardText(top)}</div>'"></div>` : '<div class="muted">-</div>';


  el.activeColor.textContent = state.activeColor ? state.activeColor.toUpperCase() : '-';
  el.colorBadge.style.display = state.activeColor ? 'inline-block' : 'none';
  if(state.activeColor) el.colorBadge.style.background = state.activeColor;

  el.playerHand.innerHTML = '';
  state.playerHand.forEach((c, i) => {
    const node = document.createElement('div');
    node.className = 'card';
    node.innerHTML = `<img src="${c.img}" alt="${c.id}" onerror="this.outerHTML='<div style=&quot;padding:8px&quot; class=&quot;muted&quot;>${cardText(c)}</div>'">`;
    node.onclick = () => playerClickCard(i);
    el.playerHand.appendChild(node);
  });
}


function isPlayable(card, top){
  if(!card || !top) return true;
  const active = state.activeColor || top.color;
  return isWildCard(card) || card.color === active || card.value === top.value;
}

function wild4Allowed(hand, top){
  return !hand.some(c => c.type !== 'wild4' && isPlayable(c, top));
}

function handlePlay(who, idx, chosenColor = null){
    const hand = who === 'player' ? state.playerHand : state.botHand;
    const card = hand[idx];

    
    if (isWildCard(card) && !chosenColor) {
        if (who === 'player') {
            state.pendingPlay = { who, idx };
            el.colorChooser.style.display = 'flex';
        } else {
            const color = chooseColorForHand(state.botHand);
            playCard(who, idx, color);
        }
        return;
    }
    playCard(who, idx, chosenColor);
}

function playCard(who, idx, chosenColor){
  const hand = who === 'player' ? state.playerHand : state.botHand;
  const card = hand.splice(idx,1)[0];

  state.activeColor = isWildCard(card) ? chosenColor : card.color;
  state.discard.push(card);

  log(`${who === 'player' ? 'Anda' : 'Bot'} membuang ${cardText(card)}${chosenColor ? ` (warna ${chosenColor.toUpperCase()})` : ''}.`);
  processCardEffect(card, who);

  if (state.playerHand.length === 1) startPlayerUnoTimer();
  if (state.botHand.length === 1) startBotUnoTimer();
  
  render();

  if (hand.length === 0) return roundEnd(who);
  if (state.turn === 'bot') setTimeout(botTurn, 700);
}

function processCardEffect(card, playedBy){
  const opponent = playedBy === 'player' ? 'bot' : 'player';
  let nextTurn = opponent;

  switch (card.value) {
    case 'skip':
    case 'reverse': 
      log(`${card.value.toUpperCase()} - giliran ${opponent} dilewati.`);
      nextTurn = playedBy;
      break;
    case 'plus2':
      drawTo(opponent, 2);
      log(`${opponent === 'player' ? 'Anda' : 'Bot'} menarik 2 kartu.`);
      nextTurn = playedBy;
      break;
  }
  if (card.type === 'wild4') {
    drawTo(opponent, 4);
    log(`${opponent === 'player' ? 'Anda' : 'Bot'} menarik 4 kartu.`);
    nextTurn = playedBy;
  }
  state.turn = nextTurn;
}

function drawTo(target, n){
  const hand = target === 'player' ? state.playerHand : state.botHand;
  for(let i=0; i<n; i++){
    ensureDeck();
    if(state.deck.length > 0) hand.push(state.deck.pop());
  }
  render();
}

function ensureDeck(){
  if(state.deck.length === 0 && state.discard.length > 1){
    const top = state.discard.pop();
    state.deck = shuffle(state.discard);
    state.discard = [top];
    log('Deck habis — reshuffle dari discard.');
  }
}

function playerClickCard(i){
  if(!state.gameActive || state.turn !== 'player') return;
  const card = state.playerHand[i];
  const top = getTopCard();

  if(card.type === 'wild4' && !wild4Allowed(state.playerHand, top)){
    return alert('Wild+4 hanya boleh jika tidak ada kartu lain yang bisa dimainkan.');
  }
  if(!isPlayable(card, top)){
    return alert('Kartu tidak cocok.');
  }
  handlePlay('player', i);
}

function botTurn(){
  if(!state.gameActive || state.turn !== 'bot') return;
  log('Giliran Bot...');
  const top = getTopCard();
  
  const playableIndex = state.botHand.findIndex(card => {
    if (card.type === 'wild4') return wild4Allowed(state.botHand, top);
    return isPlayable(card, top);
  });

  if (playableIndex !== -1) {
    handlePlay('bot', playableIndex);
  } else {
    ensureDeck();
    if(state.deck.length > 0) {
        const drawnCard = state.deck.pop();
        state.botHand.push(drawnCard);
        log('Bot mengambil 1 kartu.');
        if (isPlayable(drawnCard, top)) {
            handlePlay('bot', state.botHand.length - 1);
            return;
        }
    } else {
        log('Deck kosong, bot tidak bisa mengambil.');
    }
    state.turn = 'player';
    render();
  }
}

function chooseColorForHand(hand){
  const counts = {red:0, green:0, blue:0, yellow:0};
  hand.forEach(c => { if(counts[c.color] !== undefined) counts[c.color]++; });
  return Object.keys(counts).reduce((a, b) => counts[a] > counts[b] ? a : b);
}

function startPlayerUnoTimer(){
  clearTimeout(state.playerUnoTimer);
  state.playerSaidUno = false;
  el.unoBtn.style.display = 'inline-block';
  el.playerUno.textContent = '-';
  state.playerUnoTimer = setTimeout(() => {
    if(!state.playerSaidUno && state.playerHand.length === 1){
      drawTo('player', 2);
      log('Anda lupa menekan UNO — penalti +2.');
    }
  }, 5000); 
}

function startBotUnoTimer(){
  clearTimeout(state.botUnoTimer);
  state.botSaidUno = false;
  el.botUno.textContent = '-';
  state.botUnoTimer = setTimeout(() => {
    if(Math.random() < 0.8){
      state.botSaidUno = true;
      el.botUno.textContent = 'UNO!';
      log('Bot menekan UNO.');
    } else {
      log('Bot lupa menekan UNO.');
    }
  }, 1200);
}

function roundEnd(winner){
  state.gameActive = false;
  const didPlayerWin = winner === 'player';
  const amount = didPlayerWin ? state.bet : -state.bet;
  state.balance += amount;
  
  alert(`Anda ${didPlayerWin ? 'MENANG' : 'KALAH'}! ${didPlayerWin ? '+' : '-'}$${state.bet}`);
  log(`${didPlayerWin ? 'MENANG' : 'KALAH'} ronde. Saldo: $${state.balance}`);
  
  if (state.balance <= 0) {
    alert('Saldo habis. Game over — saldo direset ke $5000.');
    state.balance = 5000;
  }
  render();
}

el.startBtn.addEventListener('click', startRound);

el.resetBtn.addEventListener('click', () => {
  if (confirm('Reset game & saldo ke awal?')) {
    Object.assign(state, { balance: 5000, gameActive: false, deck: [], discard: [], playerHand: [], botHand: [] });
    el.log.innerHTML = '';
    render();
    log('Game direset. Saldo: $5000');
  }
});

el.drawBtn.addEventListener('click', () => {
  if (!state.gameActive || state.turn !== 'player') return;
  ensureDeck();
  if (state.deck.length === 0) return alert('Deck kosong.');

  const drawnCard = state.deck.pop();
  state.playerHand.push(drawnCard);
  log('Anda mengambil 1 kartu.');
  render();

  if (isPlayable(drawnCard, getTopCard())) {
    setTimeout(() => {
      if (confirm('Kartu yang diambil bisa dimainkan. Mainkan sekarang?')) {
        playerClickCard(state.playerHand.length - 1);
      } else {
        state.turn = 'bot';
        setTimeout(botTurn, 700);
      }
    }, 120);
  } else {
    state.turn = 'bot';
    setTimeout(botTurn, 700);
  }
});

el.passBtn.addEventListener('click', () => {
  if (state.gameActive && state.turn === 'player') {
    state.turn = 'bot';
    log('Anda melewatkan giliran.');
    setTimeout(botTurn, 700);
  }
});

el.unoBtn.addEventListener('click', () => {
  if (state.playerHand.length !== 1) return alert('Hanya boleh saat tinggal 1 kartu.');
  state.playerSaidUno = true;
  el.playerUno.textContent = 'UNO!';
  clearTimeout(state.playerUnoTimer);
  el.unoBtn.style.display = 'none';
  log('Anda menekan UNO.');
});

el.callBotUno.addEventListener('click', () => {
  if (state.botHand.length === 1 && !state.botSaidUno) {
    drawTo('bot', 2);
    log('Anda memanggil UNO pada Bot — Bot kena penalti +2!');
  } else {
    log('Panggilan UNO tidak valid.');
  }
});

el.colorButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    const color = btn.dataset.color;
    el.colorChooser.style.display = 'none';
    if(state.pendingPlay) {
      const { who, idx } = state.pendingPlay;
      playCard(who, idx, color);
      state.pendingPlay = null;
    }
  });
});

el.cancelChoose.addEventListener('click', () => {
    el.colorChooser.style.display = 'none';
    state.pendingPlay = null;
});

el.showRules.addEventListener('click', () => {
  alert(`Aturan Ringkas:\n1. Cocokkan kartu di tangan dengan kartu teratas berdasarkan warna atau simbol.\n2. Jika tidak bisa, ambil satu kartu dari deck.\n3. Kartu Aksi: Skip (lewati giliran), Reverse (lewati), +2 (lawan ambil 2).\n4. Kartu Wild: Pilih warna baru. Wild+4: Lawan ambil 4 & Anda pilih warna (hanya boleh jika tidak ada kartu lain).\n5. Jika kartu sisa 1, tekan tombol UNO atau kena penalti +2 kartu.`);
});


render();
log('UNO siap. Klik "Mulai Ronde".');