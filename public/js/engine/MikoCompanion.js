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
        if (this.lastSpokenText) {
          this.speak(this.lastSpokenText);
        }
      });
    }
  }

  speak(text) {
    if (typeof window === 'undefined' || !window.speechSynthesis) return;
    if (window.SoundFX && window.SoundFX.isMuted()) return;
    try {
      window.speechSynthesis.cancel();
      const clean = String(text).replace(/<[^>]*>/g, '').trim();
      if (!clean) return;
      this.lastSpokenText = clean;

      const utterance = new SpeechSynthesisUtterance(clean);
      utterance.lang = 'id-ID';
      utterance.rate = 1.0;
      utterance.pitch = 1.25;

      const voices = window.speechSynthesis.getVoices();
      const idVoice = voices.find(v => v.lang && (v.lang.startsWith('id') || v.lang.includes('ID')));
      if (idVoice) utterance.voice = idVoice;

      window.speechSynthesis.speak(utterance);
    } catch (e) {}
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
