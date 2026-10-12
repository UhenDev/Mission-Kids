/**
 * MISSION KIDS — MIKO Companion Controller
 * Manages progressive scaffolding hints and MIKO emotional states.
 */

class MikoCompanion {
  constructor(missionSlug) {
    this.missionSlug = missionSlug;
    this.currentHintLevel = 1;
    this.maxHintLevel = 3;
    this.bubble = document.getElementById('miko-bubble');
    this.bubbleText = document.getElementById('miko-bubble-text');
    this.levelDisplay = document.getElementById('hint-level-display');
    this.hintIndicator = document.getElementById('miko-hint-indicator');
    this.lastSpokenText = '';

    const speakBtn = document.getElementById('miko-bubble-speak');
    if (speakBtn && typeof speakBtn.addEventListener === 'function') {
      speakBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const currentText = this.bubbleText ? this.bubbleText.textContent.trim() : '';
        const text = currentText || this.lastSpokenText;
        if (text) {
          this.speak(text);
        }
      });
    }

    if (typeof window !== 'undefined') {
      window.mikoCompanion = this;
      if (window.speechSynthesis && window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = () => {
          this.voices = window.speechSynthesis.getVoices();
        };
      }
    }
  }

  getBestCuteVoice() {
    if (typeof window === 'undefined' || !window.speechSynthesis) return null;
    const voices = window.speechSynthesis.getVoices() || [];
    if (voices.length === 0) return null;

    // 1. Natural / Google Indonesian voice (e.g. Google Bahasa Indonesia, Microsoft Gadis Online)
    const idNatural = voices.find(v => v.lang && (v.lang.startsWith('id') || v.lang.includes('ID')) && /natural|gadis|google|ardi/i.test(v.name));
    if (idNatural) return idNatural;

    // 2. Any Indonesian voice
    const anyId = voices.find(v => v.lang && (v.lang.startsWith('id') || v.lang.includes('ID') || /indonesia/i.test(v.name)));
    if (anyId) return anyId;

    // 3. Cute / friendly female voice (e.g. Zira, Jenny, Gadis, Samantha)
    const cuteFemale = voices.find(v => /gadis|zira|jenny|female|samantha|victoria|karen/i.test(v.name));
    if (cuteFemale) return cuteFemale;

    // 4. Any voice that is NOT David or Mark (exclude stiff adult male English)
    const nonDavid = voices.find(v => !/david|mark|george|richard/i.test(v.name));
    if (nonDavid) return nonDavid;

    return voices[0] || null;
  }

  setSpeakingState(isSpeaking) {
    if (typeof document === 'undefined') return;
    const avatar = document.getElementById('miko-avatar-trigger')
      || document.getElementById('miko-avatar-btn')
      || (typeof document.querySelector === 'function' ? document.querySelector('.miko-avatar-btn') : null);
    if (avatar && avatar.classList) {
      if (isSpeaking) {
        avatar.classList.add('miko-speaking');
      } else {
        avatar.classList.remove('miko-speaking');
      }
    }
  }

  speak(text) {
    if (typeof window === 'undefined') return;
    // Auto-unmute if user requested Miko to talk
    if (window.SoundFX && window.SoundFX.isMuted()) {
      window.SoundFX.toggleMute();
    }

    try {
      if (window.speechSynthesis) {
        try { window.speechSynthesis.cancel(); } catch (e) {}
      }

      const clean = String(text).replace(/<[^>]*>/g, '').trim();
      if (!clean) return;
      this.lastSpokenText = clean;

      // 1. Play cute signature chime intro (pi-po!)
      if (window.SoundFX && typeof window.SoundFX.playMikoChirp === 'function') {
        window.SoundFX.playMikoChirp();
      }

      // 2. Speak with Cute Human Voice (SpeechSynthesis)
      if (window.speechSynthesis) {
        const utterance = new SpeechSynthesisUtterance(clean);
        utterance.lang = 'id-ID';

        const voice = this.getBestCuteVoice();
        if (voice) {
          utterance.voice = voice;
          if (voice.lang) utterance.lang = voice.lang;
        }

        // Cute, cheerful, friendly human kid/mascot tone:
        // Pitch 1.32 gives high, sweet, energetic clarity
        utterance.pitch = 1.32;
        utterance.rate = 1.06;
        utterance.volume = 1.0;

        utterance.onstart = () => {
          this.setSpeakingState(true);
        };
        utterance.onend = () => {
          this.setSpeakingState(false);
        };
        utterance.onerror = () => {
          this.setSpeakingState(false);
        };

        // Short 50ms pause so the greeting chirp sounds distinct
        setTimeout(() => {
          try {
            window.speechSynthesis.speak(utterance);
          } catch (e) {
            this.setSpeakingState(false);
          }
        }, 50);
      }
    } catch (e) {
      this.setSpeakingState(false);
    }
  }

  say(message, autoOpen = true) {
    if (this.bubbleText) {
      this.bubbleText.textContent = '';
      if (typeof message === 'string') {
        // Safe check for simple emphasis wrapper
        if (message.startsWith('<em>') && message.endsWith('</em>')) {
          const em = document.createElement('em');
          em.textContent = message.slice(4, -5);
          this.bubbleText.appendChild(em);
        } else {
          this.bubbleText.textContent = message;
        }
      }
    }
    if (autoOpen && this.bubble) {
      this.bubble.classList.add('active');
    }
    this.speak(message);
  }

  renderHint(level, hintText) {
    if (!this.bubbleText) return;
    this.bubbleText.textContent = '';

    const header = document.createElement('strong');
    header.textContent = `Petunjuk MIKO (Level ${level}):`;
    this.bubbleText.appendChild(header);

    this.bubbleText.appendChild(document.createElement('br'));

    const contentSpan = document.createElement('span');
    contentSpan.className = 'miko-hint-text';
    contentSpan.textContent = hintText;
    this.bubbleText.appendChild(contentSpan);

    if (this.bubble) {
      this.bubble.classList.add('active');
    }
    this.speak(`Petunjuk level ${level}: ${hintText}`);
  }

  async requestHint(attemptCount, currentState = {}) {
    if (this.bubble) {
      this.say("<em>MIKO sedang menyiapkan petunjuk terbaik untukmu... 💭</em>", true);
    }

    try {
      const response = await fetch('?page=api&action=get_hint', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          mission_slug: this.missionSlug,
          hint_level: this.currentHintLevel,
          attempt_count: attemptCount,
          current_state: currentState
        })
      });

      const data = await response.json();
      if (data.success && data.hint_text) {
        this.renderHint(this.currentHintLevel, data.hint_text);
        
        // Progressively increment hint level up to 3
        if (this.currentHintLevel < this.maxHintLevel) {
          this.currentHintLevel++;
          if (this.levelDisplay) {
            this.levelDisplay.textContent = this.currentHintLevel;
          }
        }
      } else {
        this.say("Semangat! Amati kembali objek di layar dan coba satu per satu ya!");
      }
    } catch (err) {
      console.warn("Hint fetch failed, falling back to local guidance:", err);
      this.say("Semangat terus! Kamu pasti bisa menemukan kuncinya!");
    }
  }

  showHintBadge() {
    if (this.hintIndicator) {
      this.hintIndicator.style.display = 'block';
    }
  }

  hideHintBadge() {
    if (this.hintIndicator) {
      this.hintIndicator.style.display = 'none';
    }
  }
}

window.MikoCompanion = MikoCompanion;
