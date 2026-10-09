(() => {
  'use strict';
  const { animals } = window.Bicho;
  const $ = selector => document.querySelector(selector);
  let onlyFavorites = false;
  let favorites = new Set();
  try { const stored = JSON.parse(localStorage.getItem('bicho-favorites') || '[]'); if (Array.isArray(stored)) favorites = new Set(stored.filter(x => Number.isInteger(x) && x >= 1 && x <= 25)); } catch {}
  const escape = value => String(value).replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
  const fold = value => String(value).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
  function renderAnimals() {
    const query = fold($('#animal-search').value.trim());
    const filtered = animals.filter(animal => (!onlyFavorites || favorites.has(animal.group)) && fold(`${animal.name} ${String(animal.group).padStart(2,'0')} ${animal.numbers.join(' ')}`).includes(query));
    $('#animal-grid').innerHTML = filtered.map(animal => `<article class="animal-card"><button class="favorite" type="button" data-favorite="${animal.group}" aria-label="${favorites.has(animal.group) ? 'Remover' : 'Favoritar'} ${escape(animal.name)}" aria-pressed="${favorites.has(animal.group)}">${favorites.has(animal.group) ? '♥' : '♡'}</button><button class="animal-detail" type="button" data-animal="${animal.group}" aria-label="Ver dezenas de ${escape(animal.name)}"><span class="animal-group">Grupo ${String(animal.group).padStart(2,'0')}</span><span class="animal-icon" aria-hidden="true">${escape(animal.icon)}</span><span class="animal-name">${escape(animal.name)}</span><span class="animal-numbers">${animal.numbers.join(' · ')}</span></button></article>`).join('');
    $('#animal-empty').hidden = filtered.length !== 0;
    $('#favorites-only').setAttribute('aria-pressed', String(onlyFavorites));
  }

  $('#animal-search').addEventListener('input', renderAnimals);
  $('#favorites-only').addEventListener('click', () => { onlyFavorites = !onlyFavorites; renderAnimals(); });
  $('#favorite-link').addEventListener('click', () => { onlyFavorites = true; $('#animal-search').value = ''; renderAnimals(); });
  $('#animal-grid').addEventListener('click', event => {
    const favoriteButton = event.target.closest('[data-favorite]');
    if (favoriteButton) {
      const group = Number(favoriteButton.dataset.favorite);
      favorites.has(group) ? favorites.delete(group) : favorites.add(group);
      try { localStorage.setItem('bicho-favorites', JSON.stringify([...favorites])); } catch {}
      renderAnimals();
      document.querySelector(`[data-favorite="${group}"]`)?.focus();
      return;
    }
    const detail = event.target.closest('[data-animal]'); if (!detail) return;
    const animal = animals.find(item => item.group === Number(detail.dataset.animal));
    $('#dialog-content').innerHTML = `<span class="dialog-icon" aria-hidden="true">${escape(animal.icon)}</span><span class="eyebrow">GRUPO ${String(animal.group).padStart(2,'0')}</span><h2>${escape(animal.name)}</h2><div class="dialog-numbers">${animal.numbers.map(n => `<span>${n}</span>`).join('')}</div><p class="dialog-note">As duas últimas casas da milhar indicam a dezena e o grupo correspondente.</p>`;
    $('#animal-dialog').showModal();
  });
  $('#close-dialog').addEventListener('click', () => $('#animal-dialog').close());
  $('#animal-dialog').addEventListener('click', event => { const bounds = event.currentTarget.getBoundingClientRect(); if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) event.currentTarget.close(); });
  const frames = [...document.querySelectorAll('.results-widget')];
  const frameUrls = new Map(frames.map(frame => [frame, frame.src]));
  window.addEventListener('message', event => {
    // Only the provider and the exact embedded window may resize its frame.
    const frame = frames.find(item => item.contentWindow === event.source);
    if (!frame || event.origin !== new URL(frameUrls.get(frame)).origin) return;
    const widget = event.data?.ejbWidget;
    if (widget?.banca !== 'rio' || typeof widget.height !== 'number' || !Number.isFinite(widget.height) || widget.height <= 0) return;
    // The provider measures scrollHeight, which includes the iframe viewport.
    // Adding padding here would grow the frame on each resize notification.
    frame.height = String(Math.min(2400, Math.max(180, Math.ceil(widget.height))));
  });
  const reload = $('#reload-widgets');
  reload.hidden = false;
  reload.addEventListener('click', () => {
    frames.forEach(frame => { frame.src = frameUrls.get(frame); });
  });
  renderAnimals();
})();
