/**
 * MISSION KIDS — Web Audio API Synthesizer (SoundEffects)
 * Ultra-lightweight, zero-asset, kid-friendly sound effects.
 */

class SoundEffects {
  constructor() {
    this.ctx = null;
    this.muted = localStorage.getItem('mk_sound_muted') === 'true';
    this.bgmRunning = false;
    this.bgmTimer = null;
    this.bgmStep = 0;
  }

  initCtx() {
    if (!this.ctx) {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      if (AudioContext) {
        this.ctx = new AudioContext();
      }
    }
    if (this.ctx && this.ctx.state === 'suspended') {
      this.ctx.resume();
    }
  }

  isMuted() {
    return this.muted;
  }

  toggleMute() {
    this.muted = !this.muted;
    localStorage.setItem('mk_sound_muted', this.muted);
    this.updateToggleButtons();
    if (!this.muted) {
      this.playTap();
      if (window.CURRENT_MISSION) {
        this.startBgm();
      }
    } else {
      this.stopBgm();
    }
    return this.muted;
  }

  updateToggleButtons() {
    document.querySelectorAll('.sound-toggle-btn').forEach(btn => {
      btn.innerHTML = this.muted ? '🔇 <span class="sound-label">Bisu</span>' : '🔊 <span class="sound-label">Suara</span>';
      btn.title = this.muted ? 'Nyalakan Suara Ceria' : 'Matikan Suara';
    });
    document.querySelectorAll('.btn-mission-bgm').forEach(btn => {
      btn.innerHTML = this.bgmRunning ? '🎵 Musik: Nyala' : '🔇 Musik: Mati';
    });
  }

  // 1. Playful Button Tap (Cute Bubble Pop)
  playTap() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      const now = this.ctx.currentTime;

      osc.type = 'sine';
      osc.frequency.setValueAtTime(450, now);
      osc.frequency.exponentialRampToValueAtTime(850, now + 0.08);

      gain.gain.setValueAtTime(0.2, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);

      osc.connect(gain);
      gain.connect(this.ctx.destination);

      osc.start(now);
      osc.stop(now + 0.08);
    } catch (e) {
      // Audio autoplay policy fallback
    }
  }

  // 2. Correct Answer / Mission Success (Happy Arpeggio C5 -> E5 -> G5 -> C6)
  playSuccess() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
      const now = this.ctx.currentTime;

      notes.forEach((freq, idx) => {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        const startTime = now + idx * 0.09;

        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, startTime);

        gain.gain.setValueAtTime(0, startTime);
        gain.gain.linearRampToValueAtTime(0.25, startTime + 0.02);
        gain.gain.exponentialRampToValueAtTime(0.001, startTime + 0.35);

        osc.connect(gain);
        gain.connect(this.ctx.destination);

        osc.start(startTime);
        osc.stop(startTime + 0.35);
      });
    } catch (e) {}
  }

  // 3. Magical Star Chime (Sparkling Shimmer)
  playStar(delaySec = 0) {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime + delaySec;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(987.77, now); // B5
      osc.frequency.exponentialRampToValueAtTime(1318.51, now + 0.2); // E6

      gain.gain.setValueAtTime(0.22, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.45);

      osc.connect(gain);
      gain.connect(this.ctx.destination);

      osc.start(now);
      osc.stop(now + 0.45);
    } catch (e) {}
  }

  // 4. Mission Complete Fanfare
  playCelebration() {
    if (this.muted) return;
    this.playSuccess();
    setTimeout(() => this.playStar(0), 400);
    setTimeout(() => this.playStar(0), 700);
    setTimeout(() => this.playStar(0), 1000);
  }

  // 5. Mild Boing / Retry Sound (Encouraging tone)
  playWobble() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      const now = this.ctx.currentTime;

      osc.type = 'sine';
      osc.frequency.setValueAtTime(320, now);
      osc.frequency.linearRampToValueAtTime(240, now + 0.15);

      gain.gain.setValueAtTime(0.2, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.2);

      osc.connect(gain);
      gain.connect(this.ctx.destination);

      osc.start(now);
      osc.stop(now + 0.2);
    } catch (e) {}
  }

  // 6. Mission Playful Procedural BGM (Background Music)
  startBgm() {
    if (this.muted || this.bgmRunning) return;
    this.initCtx();
    if (!this.ctx) return;
    this.bgmRunning = true;
    this.bgmStep = 0;
    this.updateToggleButtons();

    // Cheerful Pentatonic Playful Notes (Frequency in Hz)
    const melody = [
      523.25, 659.25, 783.99, 1046.50, // C5, E5, G5, C6
      880.00, 783.99, 659.25, 783.99,  // A5, G5, E5, G5
      587.33, 659.25, 783.99, 880.00,  // D5, E5, G5, A5
      1046.50, 783.99, 659.25, 523.25  // C6, G5, E5, C5
    ];

    const bass = [
      130.81, 130.81, 130.81, 130.81, // C3
      174.61, 174.61, 174.61, 174.61, // F3
      196.00, 196.00, 196.00, 196.00, // G3
      130.81, 130.81, 196.00, 130.81  // C3, C3, G3, C3
    ];

    const stepDuration = 0.32; // ~94 BPM cheerful gentle tempo

    const playNextStep = () => {
      if (!this.bgmRunning || this.muted || !this.ctx) return;

      const now = this.ctx.currentTime;
      const freq = melody[this.bgmStep % melody.length];
      const bassFreq = bass[this.bgmStep % bass.length];

      try {
        // Treble Chime (Soft Marimba / Music Box tone)
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, now);

        gain.gain.setValueAtTime(0, now);
        gain.gain.linearRampToValueAtTime(0.04, now + 0.015);
        gain.gain.exponentialRampToValueAtTime(0.0005, now + stepDuration * 0.95);

        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start(now);
        osc.stop(now + stepDuration);

        // Soft Bass accompaniment every 4 beats
        if (this.bgmStep % 4 === 0) {
          const bassOsc = this.ctx.createOscillator();
          const bassGain = this.ctx.createGain();
          bassOsc.type = 'triangle';
          bassOsc.frequency.setValueAtTime(bassFreq, now);

          bassGain.gain.setValueAtTime(0, now);
          bassGain.gain.linearRampToValueAtTime(0.03, now + 0.02);
          bassGain.gain.exponentialRampToValueAtTime(0.0005, now + stepDuration * 1.8);

          bassOsc.connect(bassGain);
          bassGain.connect(this.ctx.destination);
          bassOsc.start(now);
          bassOsc.stop(now + stepDuration * 1.8);
        }
      } catch (e) {}

      this.bgmStep++;
      this.bgmTimer = setTimeout(playNextStep, stepDuration * 1000);
    };

    playNextStep();
  }

  stopBgm() {
    this.bgmRunning = false;
    if (this.bgmTimer) {
      clearTimeout(this.bgmTimer);
      this.bgmTimer = null;
    }
    this.updateToggleButtons();
  }

  toggleBgm() {
    if (this.bgmRunning) {
      this.stopBgm();
      return false;
    } else {
      this.startBgm();
      return true;
    }
  }
}

// Global Singleton
window.SoundFX = new SoundEffects();

document.addEventListener('DOMContentLoaded', () => {
  window.SoundFX.updateToggleButtons();

  // Attach tap sound automatically to tactile buttons
  document.addEventListener('click', (e) => {
    const target = e.target.closest('.btn-kid, .sound-toggle-btn, .avatar-radio, .step-node');
    if (target) {
      window.SoundFX.playTap();
    }
  });
});
