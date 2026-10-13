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

  // 3b. Falling / Shooting Star Shower (Celestial Twinkle Cascade)
  playStarShower() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const pitches = [1046.50, 1318.51, 1567.98, 2093.00, 2637.02]; // C6, E6, G6, C7, E7
      const now = this.ctx.currentTime;
      pitches.forEach((freq, idx) => {
        const t = now + idx * 0.08;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, t);
        osc.frequency.exponentialRampToValueAtTime(freq * 1.08, t + 0.12);
        gain.gain.setValueAtTime(0.15, t);
        gain.gain.exponentialRampToValueAtTime(0.001, t + 0.35);
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start(t);
        osc.stop(t + 0.35);
      });
    } catch (e) {}
  }

  // 3c. Cute MIKO Robot Chirp (Playful 2-tone pi-po greeting before speaking)
  playMikoChirp() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;

      // Beep 1 (cheerful upward sine)
      const osc1 = this.ctx.createOscillator();
      const gain1 = this.ctx.createGain();
      osc1.type = 'sine';
      osc1.frequency.setValueAtTime(620, now);
      osc1.frequency.exponentialRampToValueAtTime(880, now + 0.05);
      gain1.gain.setValueAtTime(0.18, now);
      gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.055);
      osc1.connect(gain1);
      gain1.connect(this.ctx.destination);
      osc1.start(now);
      osc1.stop(now + 0.055);

      // Beep 2 (higher playful chirp)
      const osc2 = this.ctx.createOscillator();
      const gain2 = this.ctx.createGain();
      const t2 = now + 0.06;
      osc2.type = 'triangle';
      osc2.frequency.setValueAtTime(880, t2);
      osc2.frequency.exponentialRampToValueAtTime(1320, t2 + 0.07);
      gain2.gain.setValueAtTime(0.16, t2);
      gain2.gain.exponentialRampToValueAtTime(0.001, t2 + 0.075);
      osc2.connect(gain2);
      gain2.connect(this.ctx.destination);
      osc2.start(t2);
      osc2.stop(t2 + 0.075);
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

  // 5b. Metallic Coin Clink (Crisp ping)
  playCoin() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      [1760, 2637].forEach((f, i) => {
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();
        const t = now + i * 0.04;
        osc.type = 'sine';
        osc.frequency.setValueAtTime(f, t);
        gain.gain.setValueAtTime(0.18, t);
        gain.gain.exponentialRampToValueAtTime(0.001, t + 0.18);
        osc.connect(gain);
        gain.connect(this.ctx.destination);
        osc.start(t);
        osc.stop(t + 0.18);
      });
    } catch (e) {}
  }

  // 5c. Soft Donut Squish / Plop
  playDonut() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(380, now);
      osc.frequency.exponentialRampToValueAtTime(140, now + 0.12);
      gain.gain.setValueAtTime(0.24, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.12);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start(now);
      osc.stop(now + 0.12);
    } catch (e) {}
  }

  // 5d. Cash Register Bell Ding (Cha-ching!)
  playCashRegister() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const osc1 = this.ctx.createOscillator();
      const gain1 = this.ctx.createGain();
      osc1.type = 'sine';
      osc1.frequency.setValueAtTime(1318.51, now);
      gain1.gain.setValueAtTime(0.22, now);
      gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
      osc1.connect(gain1);
      gain1.connect(this.ctx.destination);
      osc1.start(now);
      osc1.stop(now + 0.3);

      const osc2 = this.ctx.createOscillator();
      const gain2 = this.ctx.createGain();
      const t2 = now + 0.08;
      osc2.type = 'sine';
      osc2.frequency.setValueAtTime(2093.00, t2);
      gain2.gain.setValueAtTime(0.25, t2);
      gain2.gain.exponentialRampToValueAtTime(0.001, t2 + 0.45);
      osc2.connect(gain2);
      gain2.connect(this.ctx.destination);
      osc2.start(t2);
      osc2.stop(t2 + 0.45);
    } catch (e) {}
  }

  // 5e. Heavy Wood / Stone Plank Thud (Bridge Block Drop)
  playWoodThud() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      
      // Low body thud
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(160, now);
      osc.frequency.exponentialRampToValueAtTime(45, now + 0.14);
      gain.gain.setValueAtTime(0.35, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.14);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start(now);
      osc.stop(now + 0.14);

      // Snap click transient
      const click = this.ctx.createOscillator();
      const clickGain = this.ctx.createGain();
      click.type = 'sine';
      click.frequency.setValueAtTime(420, now);
      click.frequency.exponentialRampToValueAtTime(80, now + 0.04);
      clickGain.gain.setValueAtTime(0.25, now);
      clickGain.gain.exponentialRampToValueAtTime(0.001, now + 0.04);
      click.connect(clickGain);
      clickGain.connect(this.ctx.destination);
      click.start(now);
      click.stop(now + 0.04);
    } catch (e) {}
  }

  // 5f. Cheerful Jump Boing (Botty Jump Crossing)
  playJumpBoing() {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;
      const osc = this.ctx.createOscillator();
      const gain = this.ctx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(240, now);
      osc.frequency.exponentialRampToValueAtTime(580, now + 0.18);
      gain.gain.setValueAtTime(0.28, now);
      gain.gain.exponentialRampToValueAtTime(0.001, now + 0.18);
      osc.connect(gain);
      gain.connect(this.ctx.destination);
      osc.start(now);
      osc.stop(now + 0.18);
    } catch (e) {}
  }

  // 5g. Magical Crystal Chime (Luminescent bell resonating)
  playCrystalChime(freq = 523.25) {
    if (this.muted) return;
    try {
      this.initCtx();
      if (!this.ctx) return;
      const now = this.ctx.currentTime;

      // Pure fundamental bell
      const osc1 = this.ctx.createOscillator();
      const gain1 = this.ctx.createGain();
      osc1.type = 'sine';
      osc1.frequency.setValueAtTime(freq, now);
      gain1.gain.setValueAtTime(0.28, now);
      gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.6);
      osc1.connect(gain1);
      gain1.connect(this.ctx.destination);
      osc1.start(now);
      osc1.stop(now + 0.6);

      // Shimmering crystalline harmonic overtone
      const osc2 = this.ctx.createOscillator();
      const gain2 = this.ctx.createGain();
      osc2.type = 'triangle';
      osc2.frequency.setValueAtTime(freq * 2.02, now);
      gain2.gain.setValueAtTime(0.12, now);
      gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.45);
      osc2.connect(gain2);
      gain2.connect(this.ctx.destination);
      osc2.start(now);
      osc2.stop(now + 0.45);
    } catch (e) {}
  }

  // 5h. Garden Melody Arpeggio Sequence
  playCrystalGardenSequence(onStep, onComplete) {
    if (this.muted) {
      if (typeof onComplete === 'function') onComplete();
      return;
    }
    const notes = [
      { name: 'red', freq: 261.63, delay: 0 },       // C4
      { name: 'yellow', freq: 329.63, delay: 420 },   // E4
      { name: 'blue', freq: 392.00, delay: 840 },     // G4
      { name: 'red', freq: 261.63, delay: 1260 },    // C4
      { name: 'yellow', freq: 329.63, delay: 1680 }   // E4
    ];

    notes.forEach((item, idx) => {
      setTimeout(() => {
        this.playCrystalChime(item.freq);
        if (typeof onStep === 'function') onStep(idx, item.name);
        if (idx === notes.length - 1) {
          setTimeout(() => {
            if (typeof onComplete === 'function') onComplete();
          }, 450);
        }
      }, item.delay);
    });
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

  // 7. Procedural Cute Cartoon Voice (Animalese / Robot Talk)
  speakRobotCartoon(text, onStart, onEnd) {
    // If user clicked or triggered Miko to talk, ensure unmuted so voice is always heard!
    if (this.muted) {
      this.muted = false;
      try { localStorage.setItem('mk_sound_muted', 'false'); } catch (e) {}
      this.updateToggleButtons();
    }
    this.initCtx();
    if (!this.ctx) {
      if (typeof onEnd === 'function') onEnd();
      return;
    }

    const startSeq = () => this.startRobotCartoonSequence(text, onStart, onEnd);

    if (this.ctx.state === 'suspended') {
      this.ctx.resume().then(startSeq).catch(() => {
        if (typeof onEnd === 'function') onEnd();
      });
      return;
    }

    startSeq();
  }

  startRobotCartoonSequence(text, onStart, onEnd) {
    this.stopRobotCartoon();

    if (typeof onStart === 'function') onStart();

    const clean = String(text).replace(/<[^>]*>/g, '').trim();
    const words = clean.split(/\s+/).filter(w => w.length > 0);
    if (words.length === 0) {
      if (typeof onEnd === 'function') onEnd();
      return;
    }

    // Convert words to energetic cartoon syllables (capped at 20 syllables for snappy delivery)
    const syllables = [];
    for (let i = 0; i < words.length && syllables.length < 20; i++) {
      const w = words[i];
      const cleaned = w.toLowerCase().replace(/[^a-z0-9!?.,]/g, '');
      const parts = cleaned.match(/[bcdfghjklmnpqrstvwxyz]*[aeiou]+[bcdfghjklmnpqrstvwxyz]*/g) || [cleaned];
      parts.forEach((p, pIdx) => {
        if (syllables.length < 20) {
          syllables.push({
            text: p,
            isEndWord: pIdx === parts.length - 1,
            isExclamation: w.includes('!'),
            isQuestion: w.includes('?'),
            isPause: w.includes(',') || w.includes('.')
          });
        }
      });
    }

    if (syllables.length === 0) {
      if (typeof onEnd === 'function') onEnd();
      return;
    }

    // Playful, cheerful electronic pentatonic scale for cute robot companion (A4 - C6)
    const robotScale = [440.00, 523.25, 587.33, 659.25, 783.99, 880.00, 987.77, 1046.50];

    let sIdx = 0;
    const playNext = () => {
      if (sIdx >= syllables.length || this.muted || !this.ctx) {
        this.stopRobotCartoon();
        if (typeof onEnd === 'function') onEnd();
        return;
      }

      const syl = syllables[sIdx];
      const now = this.ctx.currentTime;
      const stepDuration = 0.082; // ~82ms per snappy bouncy syllable

      try {
        let freq = robotScale[(sIdx * 2 + Math.floor(sIdx / 3)) % robotScale.length];
        if (syl.isExclamation) freq *= 1.22;
        if (syl.isQuestion) freq *= 1.28;

        // Primary cute voice oscillator (triangle / sine blend)
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = sIdx % 2 === 0 ? 'triangle' : 'sine';
        osc.frequency.setValueAtTime(freq, now);
        const targetFreq = syl.isQuestion ? freq * 1.30 : (syl.isExclamation ? freq * 1.18 : freq * 0.95);
        osc.frequency.exponentialRampToValueAtTime(targetFreq, now + stepDuration * 0.85);

        // Rich, clearly audible volume envelope (linear ramp up, sustained body, quick release)
        gain.gain.setValueAtTime(0.001, now);
        gain.gain.linearRampToValueAtTime(0.32, now + 0.008);
        gain.gain.setValueAtTime(0.30, now + stepDuration * 0.75);
        gain.gain.linearRampToValueAtTime(0.001, now + stepDuration);

        // Secondary harmonic overtone for cheerful electronic timbre
        const subOsc = this.ctx.createOscillator();
        const subGain = this.ctx.createGain();
        subOsc.type = 'triangle';
        subOsc.frequency.setValueAtTime(freq * 1.5, now);
        subOsc.frequency.exponentialRampToValueAtTime(targetFreq * 1.5, now + stepDuration * 0.85);

        subGain.gain.setValueAtTime(0.001, now);
        subGain.gain.linearRampToValueAtTime(0.16, now + 0.008);
        subGain.gain.setValueAtTime(0.14, now + stepDuration * 0.70);
        subGain.gain.linearRampToValueAtTime(0.001, now + stepDuration);

        osc.connect(gain);
        gain.connect(this.ctx.destination);
        subOsc.connect(subGain);
        subGain.connect(this.ctx.destination);

        osc.start(now);
        osc.stop(now + stepDuration);
        subOsc.start(now);
        subOsc.stop(now + stepDuration);
      } catch (e) {}

      sIdx++;
      let delay = stepDuration * 1000 + 12;
      if (syl.isEndWord) delay += 35;
      if (syl.isPause) delay += 90;

      this.cartoonSpeechTimer = setTimeout(playNext, delay);
    };

    playNext();
  }

  stopRobotCartoon() {
    if (this.cartoonSpeechTimer) {
      clearTimeout(this.cartoonSpeechTimer);
      this.cartoonSpeechTimer = null;
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
