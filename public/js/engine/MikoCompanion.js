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
    this.currentAudio = null;
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

  getMissionGuide(slug) {
    const s = slug || this.missionSlug;
    const guides = {
      'toko-kue': {
        audio: '/audio/miko/guide_toko_kue.mp3',
        text: 'Di soal ini, kamu jadi kasir toko kue! Masukkan 2 donat dan beri koin kembalian seribu rupiah ke nampan kasir ya!'
      },
      'jembatan-angka': {
        audio: '/audio/miko/guide_jembatan_angka.mp3',
        text: 'Di jembatan ini ada satu papan angka yang hilang! Perhatikan lompatan angkanya, lalu pasang balok angka yang tepat!'
      },
      'kota-pola': {
        audio: '/audio/miko/guide_kota_pola.mp3',
        text: 'Lihat warna kristal lampu taman! Pasang kristal berikutnya sesuai urutan pola warna agar lampunya menyala!'
      },
      'tanaman-layu': {
        audio: '/audio/miko/guide_tanaman_layu.mp3',
        text: 'Bunga matahari ini sedang layu! Siram air dengan gembor dan buka tirai matahari sampai bunganya mekar segar!'
      },
      'misteri-bayangan': {
        audio: '/audio/miko/guide_misteri_bayangan.mp3',
        text: 'Ayo main bayangan kelinci! Geser senter maju atau mundur sampai ukuran bayangan pas dengan garis pentas!'
      },
      'perjalanan-air': {
        audio: '/audio/miko/guide_perjalanan_air.mp3',
        text: 'Bantu MIKO menyusun urutan siklus air! Pasang kartu penguapan, awan, dan hujan secara berurutan ya!'
      },
      'robot-pulang': {
        audio: '/audio/miko/guide_robot_pulang.mp3',
        text: 'Bantu Botty pulang ke stasiun pengisi baterai! Susun perintah maju dan belok agar Botty tidak menabrak batu!'
      },
      'jalan-rahasia': {
        audio: '/audio/miko/guide_jalan_rahasia.mp3',
        text: 'Ada dua jalan di depanmu! Pilih jalan yang paling aman agar petualanganmu bisa terus berlanjut!'
      },
      'robot-mengulang': {
        audio: '/audio/miko/guide_robot_mengulang.mp3',
        text: 'Gunakan balok perulangan loop untuk membuat robot melompat dan maju melewati rintangan di lintasan!'
      },
      'roket-angkasa': {
        audio: '/audio/miko/guide_roket_angkasa.mp3',
        text: 'Atur bahan bakar dan sudut luncur roket antariksa agar roket bisa meluncur pas ke stasiun luar angkasa!'
      },
      'rasi-bintang': {
        audio: '/audio/miko/guide_rasi_bintang.mp3',
        text: 'Hubungkan titik koordinat bintang di langit malam untuk membentuk rasi bintang layang-layang!'
      },
      'rover-mars': {
        audio: '/audio/miko/guide_rover_mars.mp3',
        text: 'Kendalikan Rover di planet Mars! Buat rute maju dan berbelok untuk mengambil kristal dan hindari kawah meteor!'
      }
    };
    return guides[s] || null;
  }

  resolveAudioClip(text) {
    if (!text) return null;
    const lower = text.toLowerCase();

    // 1. Mission Challenge Spoken Guides
    if (lower.includes('kasir toko kue') || lower.includes('masukkan 2 donat') || lower.includes('kembalian seribu')) {
      return '/audio/miko/guide_toko_kue.mp3';
    }
    if (lower.includes('papan angka yang hilang') || lower.includes('lompatan angkanya') || lower.includes('balok angka yang tepat')) {
      return '/audio/miko/guide_jembatan_angka.mp3';
    }
    if (lower.includes('kristal lampu taman') || lower.includes('urutan pola warna') || lower.includes('lampunya menyala')) {
      return '/audio/miko/guide_kota_pola.mp3';
    }
    if (lower.includes('bunga matahari ini sedang layu') || lower.includes('siram air dengan gembor') || lower.includes('tirai matahari')) {
      return '/audio/miko/guide_tanaman_layu.mp3';
    }
    if (lower.includes('bayangan kelinci') || lower.includes('geser senter maju') || lower.includes('garis pentas')) {
      return '/audio/miko/guide_misteri_bayangan.mp3';
    }
    if (lower.includes('siklus air') || lower.includes('kartu penguapan') || lower.includes('awan, dan hujan')) {
      return '/audio/miko/guide_perjalanan_air.mp3';
    }
    if (lower.includes('botty pulang ke stasiun') || lower.includes('pengisi baterai') || lower.includes('tidak menabrak batu')) {
      return '/audio/miko/guide_robot_pulang.mp3';
    }
    if (lower.includes('dua jalan di depanmu') || lower.includes('jalan yang paling aman')) {
      return '/audio/miko/guide_jalan_rahasia.mp3';
    }
    if (lower.includes('balok perulangan loop') || lower.includes('melompat dan maju melewati rintangan')) {
      return '/audio/miko/guide_robot_mengulang.mp3';
    }
    if (lower.includes('roket antariksa') || lower.includes('bahan bakar dan sudut luncur') || lower.includes('stasiun luar angkasa')) {
      return '/audio/miko/guide_roket_angkasa.mp3';
    }
    if (lower.includes('koordinat bintang') || lower.includes('rasi bintang layang-layang') || lower.includes('langit malam')) {
      return '/audio/miko/guide_rasi_bintang.mp3';
    }
    if (lower.includes('rover di planet mars') || lower.includes('kendalikan rover') || lower.includes('kawah meteor')) {
      return '/audio/miko/guide_rover_mars.mp3';
    }

    // 2. Cheerful Dialogues & Hints
    if (lower.includes('si robot ceria') || lower.includes('butuh bantuan') || lower.includes('miko dan aku')) {
      return '/audio/miko/cheer_1.mp3';
    }
    if (lower.includes('xp dan bintang') || lower.includes('raih bintang')) {
      return '/audio/miko/cheer_2.mp3';
    }
    if (lower.includes('sedikit demi sedikit') || lower.includes('otakmu') || lower.includes('belajar logika')) {
      return '/audio/miko/cheer_3.mp3';
    }
    if (lower.includes('dunia petualangan') || lower.includes('bertualang hari ini') || lower.includes('siap bertualang')) {
      return '/audio/miko/cheer_4.mp3';
    }
    if (lower.includes('jangan takut salah') || lower.includes('lanjutkan petualanganmu')) {
      return '/audio/miko/cheer_5.mp3';
    }
    if (lower.includes('arena tantangan') || lower.includes('selamat datang')) {
      return '/audio/miko/mission_welcome.mp3';
    }
    if (lower.includes('jangan menyerah')) {
      return '/audio/miko/mission_retry.mp3';
    }
    if (lower.includes('keberhasilanmu') || lower.includes('xp baru') || lower.includes('horeee')) {
      return '/audio/miko/mission_xp.mp3';
    }
    if (lower.includes('memecahkan tantangannya') || lower.includes('luar biasa')) {
      return '/audio/miko/mission_success.mp3';
    }
    if (lower.includes('menyiapkan petunjuk')) {
      return '/audio/miko/hint_preparing.mp3';
    }
    if (lower.includes('level 1') || lower.includes('level satu')) {
      return '/audio/miko/hint_level_1.mp3';
    }
    if (lower.includes('level 2') || lower.includes('level dua')) {
      return '/audio/miko/hint_level_2.mp3';
    }
    if (lower.includes('level 3') || lower.includes('level tiga')) {
      return '/audio/miko/hint_level_3.mp3';
    }
    if (lower.includes('halo') || lower.includes('miko siap')) {
      return '/audio/miko/greeting_default.mp3';
    }
    return null;
  }

  playMissionGuide(slug = null) {
    const s = slug || this.missionSlug;
    const guide = this.getMissionGuide(s);
    if (!guide) return;

    if (this.bubbleText) {
      this.bubbleText.innerHTML = `<strong>Panduan Misi MIKO:</strong><br>${guide.text}`;
    }
    if (this.bubble) {
      this.bubble.classList.add('active');
    }

    const guideTextEl = document.getElementById('miko-guide-text');
    if (guideTextEl) {
      guideTextEl.textContent = guide.text;
    }

    this.speak(guide.text);
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

  stopSpeaking() {
    if (this.currentAudio) {
      try {
        this.currentAudio.pause();
        this.currentAudio.currentTime = 0;
      } catch (e) {}
      this.currentAudio = null;
    }
    if (typeof window !== 'undefined' && window.speechSynthesis) {
      try { window.speechSynthesis.cancel(); } catch (e) {}
    }
    this.setSpeakingState(false);
  }

  speakBrowserTTS(text) {
    if (typeof window === 'undefined' || !window.speechSynthesis) {
      this.setSpeakingState(false);
      return;
    }

    try {
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'id-ID';

      const voice = this.getBestCuteVoice();
      if (voice) {
        utterance.voice = voice;
        if (voice.lang) utterance.lang = voice.lang;
      }

      utterance.pitch = 1.32;
      utterance.rate = 1.06;
      utterance.volume = 1.0;

      utterance.onstart = () => this.setSpeakingState(true);
      utterance.onend = () => this.setSpeakingState(false);
      utterance.onerror = () => this.setSpeakingState(false);

      window.speechSynthesis.speak(utterance);
    } catch (e) {
      this.setSpeakingState(false);
    }
  }

  speak(text) {
    if (typeof window === 'undefined') return;
    // Auto-unmute if user requested Miko to talk
    if (window.SoundFX && window.SoundFX.isMuted()) {
      window.SoundFX.toggleMute();
    }

    try {
      this.stopSpeaking();

      const clean = String(text).replace(/<[^>]*>/g, '').trim();
      if (!clean) return;
      this.lastSpokenText = clean;

      // 1. Play cute signature chime intro (pi-po!)
      if (window.SoundFX && typeof window.SoundFX.playMikoChirp === 'function') {
        window.SoundFX.playMikoChirp();
      }

      // 2. Play Natural Studio Audio Clip if matched
      const audioUrl = this.resolveAudioClip(clean);
      if (audioUrl) {
        const audio = new Audio(audioUrl);
        this.currentAudio = audio;
        this.setSpeakingState(true);

        audio.onended = () => {
          this.setSpeakingState(false);
          this.currentAudio = null;
        };
        audio.onerror = () => {
          this.currentAudio = null;
          this.speakBrowserTTS(clean);
        };

        const playPromise = audio.play();
        if (playPromise !== undefined) {
          playPromise.catch(() => {
            this.currentAudio = null;
            this.speakBrowserTTS(clean);
          });
        }
        return;
      }

      // 3. Fallback to Web Speech API
      this.speakBrowserTTS(clean);
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
