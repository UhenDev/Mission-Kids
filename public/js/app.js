/**
 * MISSION KIDS — Master Application Script
 * General UI interactions, MIKO bubble toggle, sound/confetti helpers.
 */

document.addEventListener('DOMContentLoaded', () => {
  // MIKO Floating Companion Trigger Toggle
  const mikoTrigger = document.getElementById('miko-avatar-trigger');
  const mikoBubble = document.getElementById('miko-bubble');
  const mikoClose = document.getElementById('miko-bubble-close');

  if (mikoTrigger && mikoBubble) {
    mikoTrigger.addEventListener('click', () => {
      mikoBubble.classList.toggle('active');
    });
  }

  if (mikoClose && mikoBubble) {
    mikoClose.addEventListener('click', (e) => {
      e.stopPropagation();
      mikoBubble.classList.remove('active');
    });
  }

  // Click Particle Sparkle on Tactile Buttons
  document.addEventListener('pointerdown', (e) => {
    const btn = e.target.closest('.btn-kid, .card-kid, .miko-avatar-btn');
    if (!btn) return;

    // Create subtle tactile pop animation
    btn.style.transform = 'scale(0.96)';
    setTimeout(() => {
      btn.style.transform = '';
    }, 120);

    // Occasional star sparkle on button press
    if (Math.random() > 0.4 && window.Celebration) {
      window.Celebration.burst({
        x: e.clientX,
        y: e.clientY,
        count: 14
      });
    }
  });

  // Welcome Confetti on Achievements page if any unlocked
  if (window.location.search.includes('page=achievements') && window.Celebration) {
    setTimeout(() => {
      window.Celebration.burst({ count: 70 });
    }, 400);
  }
});

