/**
 * MISSION KIDS — MIKO Companion Controller
 * Manages progressive scaffolding hints and MIKO emotional states.
 */

// Shared Central MIKO Voice Configuration - Suara Miko Laki-laki Ramah, Ceria, & Bersemangat
if (typeof window !== 'undefined') {
  window.MIKO_VOICE_CONFIG = {
    gender: 'male',
    character: 'cute-boy-robot',
    lang: 'id-ID',
    pitch: 1.25,   // Karakter suara AI Miko lucu laki-laki / boy mascot ceria
    rate: 1.05,    // Kecepatan bicara lincah dan bersahabat
    volume: 1.0,

    getBestVoice: function() {
      if (typeof window === 'undefined' || !window.speechSynthesis) return null;
      const voices = window.speechSynthesis.getVoices() || [];
      if (voices.length === 0) return null;

      // 1. Prioritas Utama: Suara Pria Indonesia (Microsoft Ardi Online Natural, Microsoft Andika, Dimas, Jajang)
      const idMale = voices.find(v => {
        const isId = v.lang && (v.lang.startsWith('id') || v.lang.includes('ID') || /indonesia/i.test(v.name));
        return isId && /ardi|andika|dimas|jajang|male|pria|laki/i.test(v.name);
      });
      if (idMale) return idMale;

      // 2. Prioritas Kedua: Suara Bahasa Indonesia Alami (Google Bahasa Indonesia / Gadis dengan pitch maskot anak laki-laki lucu)
      const idVoice = voices.find(v => v.lang && (v.lang.startsWith('id') || v.lang.includes('ID') || /indonesia/i.test(v.name)));
      if (idVoice) return idVoice;

      // 3. Suara apa pun yang cocok dengan bahasa Indonesia
      const idAny = voices.find(v => v.lang && v.lang.toLowerCase().includes('id'));
      if (idAny) return idAny;

      return voices[0] || null;
    },
    // Alias for backward compatibility
    getBestCuteVoice: function() {
      return this.getBestVoice();
    }
  };

  // Pre-warm SpeechSynthesis voices immediately
  if (window.speechSynthesis) {
    try {
      window.speechSynthesis.getVoices();
      if (window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = function() {
          try { window.speechSynthesis.getVoices(); } catch (e) {}
        };
      }
    } catch (e) {}
  }
}

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
    this.currentResponseText = '';
    this.activeResponseId = 0;

    const speakBtn = document.getElementById('miko-bubble-speak');
    if (speakBtn && typeof speakBtn.addEventListener === 'function') {
      speakBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const currentText = this.bubbleText ? this.bubbleText.textContent.trim() : '';
        const text = currentText || this.currentResponseText || this.lastSpokenText;
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

  normalizeVerbatim(str) {
    return String(str || '')
      .replace(/<[^>]*>/g, ' ')
      .toLowerCase()
      .replace(/[^\p{L}\p{N}\s]/gu, ' ')
      .replace(/\s+/g, ' ')
      .trim();
  }

  /**
   * Resolves a pre-recorded audio clip ONLY IF the text is a 100% exact verbatim match.
   * Never hijack dynamic hints or custom AI text with generic audio clips!
   */
  resolveAudioClip(text) {
    if (!text) return null;
    // Studio audio clips in /audio/miko are 100% natural id-ID-ArdiNeural Indonesian cute boy mascot
    const cleanNorm = this.normalizeVerbatim(text);

    // Exact verbatim dictionary of studio-recorded clips (Microsoft id-ID-ArdiNeural)
    const EXACT_MAP = {
      // 1. Mission Challenge Guides
      'di soal ini kamu jadi kasir toko kue masukkan 2 donat dan beri koin kembalian seribu rupiah ke nampan kasir ya': '/audio/miko/guide_toko_kue.mp3',
      'di soal ini kamu jadi kasir toko kue masukkan dua donat dan beri koin kembalian seribu rupiah ke nampan kasir ya': '/audio/miko/guide_toko_kue.mp3',
      'di jembatan ini ada satu papan angka yang hilang perhatikan lompatan angkanya lalu pasang balok angka yang tepat': '/audio/miko/guide_jembatan_angka.mp3',
      'lihat warna kristal lampu taman pasang kristal berikutnya sesuai urutan pola warna agar lampunya menyala': '/audio/miko/guide_kota_pola.mp3',
      'bunga matahari ini sedang layu siram air dengan gembor dan buka tirai matahari sampai bunganya mekar segar': '/audio/miko/guide_tanaman_layu.mp3',
      'ayo main bayangan kelinci geser senter maju atau mundur sampai ukuran bayangan pas dengan garis pentas': '/audio/miko/guide_misteri_bayangan.mp3',
      'bantu miko menyusun urutan siklus air pasang kartu penguapan awan dan hujan secara berurutan ya': '/audio/miko/guide_perjalanan_air.mp3',
      'bantu botty pulang ke stasiun pengisi baterai susun perintah maju dan belok agar botty tidak menabrak batu': '/audio/miko/guide_robot_pulang.mp3',
      'ada dua jalan di depanmu pilih jalan yang paling aman agar petualanganmu bisa terus berlanjut': '/audio/miko/guide_jalan_rahasia.mp3',
      'gunakan balok perulangan loop untuk membuat robot melompat dan maju melewati rintangan di lintasan': '/audio/miko/guide_robot_mengulang.mp3',
      'atur bahan bakar dan sudut luncur roket antariksa agar roket bisa meluncur pas ke stasiun luar angkasa': '/audio/miko/guide_roket_angkasa.mp3',
      'hubungkan titik koordinat bintang di langit malam untuk membentuk rasi bintang layang layang': '/audio/miko/guide_rasi_bintang.mp3',
      'kendalikan rover di planet mars buat rute maju dan berbelok untuk mengambil kristal dan hindari kawah meteor': '/audio/miko/guide_rover_mars.mp3',

      // 2. Exact Cheer & Default Phrases
      'halo sahabat cilik aku miko si robot ceria kalau butuh bantuan di dalam misi klik aku ya': '/audio/miko/cheer_1.mp3',
      'tahukah kamu setiap misi yang berhasil diselesaikan memberimu xp dan bintang baru': '/audio/miko/cheer_2.mp3',
      'belajar sedikit demi sedikit setiap hari membuat otakmu semakin hebat dan cerdas': '/audio/miko/cheer_3.mp3',
      'ayo pilih salah satu dunia petualangan dan selesaikan tantangannya hari ini': '/audio/miko/cheer_4.mp3',
      'kamu hebat jangan takut salah karena dari salah kita bisa belajar hal baru': '/audio/miko/cheer_5.mp3',
      'halo sahabat cilik aku miko teman belajarmu di setiap petualangan ayo jelajahi empat dunia seru di mission kids dan kumpulkan banyak bintang': '/audio/miko/greeting_default.mp3',
      'miko sedang menyiapkan petunjuk terbaik untukmu': '/audio/miko/hint_preparing.mp3',
      'tenang miko punya petunjuk level satu untukmu coba amati polanya sekali lagi': '/audio/miko/hint_level_1.mp3',
      'petunjuk level dua perhatikan baik baik langkah sebelumnya dan susun strategimu': '/audio/miko/hint_level_2.mp3',
      'petunjuk level tiga ini langkah kuncinya pasang bagian yang tepat untuk menyelesaikannya': '/audio/miko/hint_level_3.mp3',
      'selamat datang di arena tantangan petualangan': '/audio/miko/mission_welcome.mp3',
      'jangan menyerah coba sekali lagi ya': '/audio/miko/mission_retry.mp3',
      'horeee kamu mendapatkan xp dan bintang baru': '/audio/miko/mission_xp.mp3',
      'horeee selamat atas keberhasilanmu kamu mendapatkan xp dan bintang baru': '/audio/miko/reward_congrats.mp3',
      'horeee selamat atas keberhasilanmu kamu mendapatkan xp baru': '/audio/miko/reward_congrats.mp3',
      'luar biasa kamu berhasil memecahkan tantangannya': '/audio/miko/mission_success.mp3',

      // 3. Landing Page Topics
      'ada empat dunia menakjubkan di mission kids number city pulau matematika discovery lab ilmu alam thinking lab logika teka teki dan space odyssey roket antariksa': '/audio/miko/topic_worlds.mp3',
      'belajar sedikit demi sedikit setiap hari membuat otakmu semakin hebat dan cerdas jangan takut salah karena dari salah kita bisa belajar hal baru': '/audio/miko/topic_tips.mp3',
      'kamu adalah kapten cilik yang hebat dan pemberani kumpulkan bintang selesaikan misi dan raih prestasi terbaikmu bersama miko': '/audio/miko/topic_cheer.mp3',

      // 4. Dashboard Hero Avatar Greetings
      'hore siap bertualang hari ini': '/audio/miko/avatar_greeting_1.mp3',
      'ayo selesaikan misi dan raih bintang': '/audio/miko/avatar_greeting_2.mp3',
      'belajar logika itu seru banget': '/audio/miko/avatar_greeting_3.mp3',
      'kamu hebat ayo lanjutkan petualanganmu': '/audio/miko/avatar_greeting_4.mp3',
      'miko dan aku siap membantumu': '/audio/miko/avatar_greeting_5.mp3',

      // 5. Global Floating Companion Default
      'halo sahabat cilik miko siap menemanimu bereksplorasi kalau butuh bantuan di dalam misi klik tombol petunjuk ya': '/audio/miko/greeting_companion.mp3'
    };

    return EXACT_MAP[cleanNorm] || null;
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

    this.currentResponseText = guide.text;
    this.speak(guide.text);
  }

  getBestCuteVoice() {
    return (window.MIKO_VOICE_CONFIG && typeof window.MIKO_VOICE_CONFIG.getBestVoice === 'function')
      ? window.MIKO_VOICE_CONFIG.getBestVoice()
      : null;
  }

  setSpeakingState(isSpeaking) {
    if (typeof document === 'undefined') return;
    const avatar = document.getElementById('miko-avatar-trigger')
      || document.getElementById('miko-avatar-btn')
      || (typeof document.querySelector === 'function' ? document.querySelector('.miko-avatar-btn') : null);
    if (avatar && avatar.classList) {
      if (isSpeaking) {
        avatar.classList.add('miko-speaking');
        avatar.setAttribute('aria-pressed', 'true');
      } else {
        avatar.classList.remove('miko-speaking');
        avatar.setAttribute('aria-pressed', 'false');
      }
    }
  }

  stopSpeaking() {
    this.activeResponseId++;
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

  speakBrowserTTS(text, responseId = null) {
    if (typeof window === 'undefined' || !window.speechSynthesis) {
      this.setSpeakingState(false);
      return;
    }

    const myId = responseId || this.activeResponseId;

    try {
      window.speechSynthesis.cancel();
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'id-ID';

      const voice = this.getBestCuteVoice();
      if (voice) {
        utterance.voice = voice;
        if (voice.lang && (voice.lang.startsWith('id') || voice.lang.includes('ID'))) {
          utterance.lang = voice.lang;
        }
      }

      // Karakter Suara AI Miko Lucu Laki-Laki & Bahasa Indonesia:
      // - Jika Microsoft Ardi (suara pria asli): pitch 1.16 memberi nada anak laki-laki ceria & bersemangat
      // - Jika Google Bahasa Indonesia: pitch 1.25 memberi nada maskot anak laki-laki lucu (cute anime boy robot)
      const isArdiMale = voice && /ardi|andika|male|pria|laki/i.test(voice.name);
      utterance.pitch = isArdiMale ? 1.16 : 1.25;
      utterance.rate = (window.MIKO_VOICE_CONFIG && window.MIKO_VOICE_CONFIG.rate !== undefined) ? window.MIKO_VOICE_CONFIG.rate : 1.05;
      utterance.volume = 1.0;

      utterance.onstart = () => {
        if (this.activeResponseId === myId) {
          this.setSpeakingState(true);
        }
      };
      utterance.onend = () => {
        if (this.activeResponseId === myId) {
          this.setSpeakingState(false);
        }
      };
      utterance.onerror = () => {
        if (this.activeResponseId === myId) {
          this.setSpeakingState(false);
        }
      };

      window.speechSynthesis.speak(utterance);
    } catch (e) {
      this.setSpeakingState(false);
    }
  }

  speak(text) {
    if (typeof window === 'undefined') return;
    const myId = ++this.activeResponseId;

    // Auto-unmute if user requested Miko to talk
    if (window.SoundFX && window.SoundFX.isMuted()) {
      window.SoundFX.toggleMute();
    }

    try {
      this.stopSpeaking();
      // Re-assign myId after stopSpeaking() incremented activeResponseId
      this.activeResponseId = myId;

      const clean = String(text).replace(/<[^>]*>/g, '').trim();
      if (!clean) return;
      this.lastSpokenText = clean;
      this.currentResponseText = clean;

      // 1. Play Natural Studio Audio Clip ONLY if 100% exact verbatim match (0ms latency)
      const audioUrl = this.resolveAudioClip(clean);
      if (audioUrl) {
        this.playAudioClip(audioUrl, clean, myId);
        return;
      }

      // 2. Play Dynamic Neural TTS via backend (id-ID-ArdiNeural) with Web Speech fallback
      this.fetchAndPlayDynamicTts(clean, myId);
    } catch (e) {
      this.setSpeakingState(false);
    }
  }

  playAudioClip(audioUrl, clean, myId) {
    try {
      const cacheBustedUrl = audioUrl + (audioUrl.includes('?') ? '&' : '?') + 'v=5.1';
      const audio = new Audio(cacheBustedUrl);
      this.currentAudio = audio;
      this.setSpeakingState(true);

      audio.onended = () => {
        if (this.activeResponseId === myId) {
          this.setSpeakingState(false);
          this.currentAudio = null;
        }
      };
      audio.onerror = () => {
        if (this.activeResponseId === myId) {
          this.currentAudio = null;
          this.speakBrowserTTS(clean, myId);
        }
      };

      const playPromise = audio.play();
      if (playPromise !== undefined) {
        playPromise.catch(() => {
          if (this.activeResponseId === myId) {
            this.currentAudio = null;
            this.speakBrowserTTS(clean, myId);
          }
        });
      }
    } catch (e) {
      if (this.activeResponseId === myId) {
        this.speakBrowserTTS(clean, myId);
      }
    }
  }

  fetchAndPlayDynamicTts(clean, myId) {
    if (typeof window === 'undefined' || typeof fetch !== 'function') {
      this.speakBrowserTTS(clean, myId);
      return;
    }

    const controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
    const timeoutId = controller ? setTimeout(() => controller.abort(), 7000) : null;

    fetch('?page=api&action=miko_tts', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ text: clean }),
      signal: controller ? controller.signal : undefined
    })
      .then(res => res.json())
      .then(data => {
        if (timeoutId) clearTimeout(timeoutId);
        if (this.activeResponseId !== myId) return;
        if (data && data.success && data.audio_url) {
          this.playAudioClip(data.audio_url, clean, myId);
        } else {
          this.speakBrowserTTS(clean, myId);
        }
      })
      .catch(() => {
        if (timeoutId) clearTimeout(timeoutId);
        if (this.activeResponseId === myId) {
          this.speakBrowserTTS(clean, myId);
        }
      });
  }

  say(message, autoOpen = true) {
    const clean = String(message).replace(/<[^>]*>/g, '').trim();
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
    this.currentResponseText = clean;
    this.speak(clean);
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

    const cleanHint = String(hintText).replace(/<[^>]*>/g, '').trim();
    const spokenText = `Petunjuk MIKO Level ${level}: ${cleanHint}`;
    this.currentResponseText = spokenText;
    this.speak(spokenText);
  }

  async requestHint(attemptCount, currentState = {}) {
    const myId = ++this.activeResponseId;
    this.stopSpeaking();
    this.activeResponseId = myId;

    if (this.bubble) {
      this.say("MIKO sedang menyiapkan petunjuk terbaik untukmu... 💭", true);
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
      // Drop stale response if another action happened
      if (myId !== this.activeResponseId) return;

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
      if (myId !== this.activeResponseId) return;
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
