/**
 * MISSION KIDS — Master Application Script
 * Interactive Kid Experience Engine
 * Tactile sound cues, living avatar reactions, MIKO interactions, confetti bursts.
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. MIKO Floating Companion Trigger & Speech Cycling
  const mikoTrigger = document.getElementById('miko-avatar-trigger');
  const mikoBubble = document.getElementById('miko-bubble');
  const mikoClose = document.getElementById('miko-bubble-close');
  const mikoText = document.getElementById('miko-bubble-text');

  // Ensure Miko Companion instance is available globally
  if (!window.mikoCompanion && typeof window.MikoCompanion === 'function') {
    window.mikoCompanion = new window.MikoCompanion('app');
  }

  const mikoCheerPhrases = [
    "Halo Sahabat Cilik! Aku MIKO si robot ceria! Kalau butuh bantuan di dalam misi, klik aku ya! 💡",
    "Tahukah kamu? Setiap misi yang berhasil diselesaikan memberimu XP dan bintang baru! ⭐",
    "Belajar sedikit demi sedikit setiap hari membuat otakmu semakin hebat dan cerdas! 🧠✨",
    "Ayo pilih salah satu dunia petualangan dan selesaikan tantangannya hari ini! 🚀",
    "Kamu hebat! Jangan takut salah, karena dari salah kita bisa belajar hal baru! 🌟"
  ];
  let mikoPhraseIdx = 0;

  if (mikoTrigger && mikoBubble) {
    mikoTrigger.addEventListener('click', () => {
      const isOpening = !mikoBubble.classList.contains('active');
      mikoBubble.classList.toggle('active');

      if (isOpening) {
        if (window.SoundFX && window.SoundFX.isMuted()) {
          window.SoundFX.toggleMute();
        } else if (window.SoundFX) {
          window.SoundFX.playTap();
        }

        let spokenText = '';
        if (mikoText) {
          if (!mikoBubble.dataset.openedOnce) {
            mikoBubble.dataset.openedOnce = 'true';
            spokenText = mikoText.textContent.trim();
          } else {
            mikoPhraseIdx = (mikoPhraseIdx + 1) % mikoCheerPhrases.length;
            mikoText.textContent = mikoCheerPhrases[mikoPhraseIdx];
            spokenText = mikoCheerPhrases[mikoPhraseIdx];
          }
        }
        if (window.Celebration) {
          const rect = mikoTrigger.getBoundingClientRect();
          window.Celebration.burst({
            x: rect.left + rect.width / 2,
            y: rect.top,
            count: 16
          });
        }
        // Speak out loud with cute human voice whenever MIKO is clicked!
        if (spokenText) {
          const companion = window.mikoCompanion || (window.CURRENT_MISSION_ENGINE && window.CURRENT_MISSION_ENGINE.companion);
          if (companion && typeof companion.speak === 'function') {
            companion.speak(spokenText);
          }
        }
      } else {
        // Stop speech when closing bubble
        if (window.speechSynthesis) {
          try { window.speechSynthesis.cancel(); } catch (e) {}
        }
      }
    });
  }

  if (mikoClose && mikoBubble) {
    mikoClose.addEventListener('click', (e) => {
      e.stopPropagation();
      mikoBubble.classList.remove('active');
      if (window.speechSynthesis) {
        try { window.speechSynthesis.cancel(); } catch (e) {}
      }
      if (window.SoundFX) window.SoundFX.playTap();
    });
  }

  // 2. Interactive Living Avatar in Dashboard Hero
  const heroAvatar = document.getElementById('hero-avatar-disc');
  const avatarBubble = document.getElementById('avatar-speech-bubble');

  const avatarGreetings = [
    "Hore! Siap bertualang hari ini! 🚀",
    "Ayo selesaikan misi dan raih bintang! ⭐",
    "Belajar logika itu seru banget! ✨",
    "Kamu hebat! Ayo lanjutkan petualanganmu! 🌟",
    "MIKO dan aku siap membantumu! 🤖"
  ];
  let avatarQuoteTimer = null;

  if (heroAvatar) {
    heroAvatar.addEventListener('click', (e) => {
      e.stopPropagation();
      // Audio cue
      if (window.SoundFX) window.SoundFX.playStar();

      // Fun Wiggle / Jelly Animation
      heroAvatar.style.animation = 'none';
      void heroAvatar.offsetWidth; // trigger reflow
      heroAvatar.style.animation = 'wiggleJoy 500ms ease';

      // Confetti Sparkle
      if (window.Celebration) {
        const rect = heroAvatar.getBoundingClientRect();
        window.Celebration.burst({
          x: rect.left + rect.width / 2,
          y: rect.top + rect.height / 2,
          count: 22
        });
      }

      // Speech bubble reaction
      if (avatarBubble) {
        const randomQuote = avatarGreetings[Math.floor(Math.random() * avatarGreetings.length)];
        avatarBubble.textContent = randomQuote;
        avatarBubble.style.display = 'block';

        if (avatarQuoteTimer) clearTimeout(avatarQuoteTimer);
        avatarQuoteTimer = setTimeout(() => {
          avatarBubble.style.display = 'none';
        }, 2600);
      }
    });
  }

  // 3. Interactive Dashboard XP Widget & Navbar XP Pill
  const xpWidget = document.querySelector('.dashboard-xp-widget');
  const navXpPill = document.querySelector('.xp-tracker-pill');

  [xpWidget, navXpPill].forEach(el => {
    if (!el) return;
    el.addEventListener('click', (e) => {
      if (window.SoundFX) window.SoundFX.playStar();
      if (window.Celebration) {
        const rect = el.getBoundingClientRect();
        window.Celebration.burst({
          x: rect.left + rect.width / 2,
          y: rect.top + rect.height / 2,
          count: 18
        });
      }
    });
  });

  // 4. Interactive Skill Progress Chips
  document.querySelectorAll('.skill-chip-box').forEach(chip => {
    chip.addEventListener('click', (e) => {
      if (window.SoundFX) window.SoundFX.playTap();
      const rect = chip.getBoundingClientRect();
      if (window.Celebration && Math.random() > 0.3) {
        window.Celebration.burst({
          x: rect.left + rect.width / 2,
          y: rect.top + rect.height / 2,
          count: 12
        });
      }
    });
  });

  // 5. Tactile Click & Particle Feedback on Buttons & Interactive Cards
  document.addEventListener('pointerdown', (e) => {
    const btn = e.target.closest('.btn-kid, .card-kid, .world-card, .miko-avatar-btn');
    if (!btn) return;

    btn.style.transform = 'scale(0.96)';
    setTimeout(() => {
      btn.style.transform = '';
    }, 120);

    // Star sparkle on button press
    if (Math.random() > 0.5 && window.Celebration) {
      window.Celebration.burst({
        x: e.clientX,
        y: e.clientY,
        count: 12
      });
    }
  });

  // 6. Welcome Confetti on Achievements page if any unlocked
  if (window.location.search.includes('page=achievements') && window.Celebration) {
    setTimeout(() => {
      window.Celebration.burst({ count: 70 });
      if (window.SoundFX) window.SoundFX.playCelebration();
    }, 400);
  }
});


