/**
 * MISSION KIDS — Master Mission Engine
 * Orchestrates 7-step lifecycle, interaction validation, MIKO hints, and rewards.
 */

class MissionEngine {
  constructor(missionData) {
    this.data = missionData;
    this.config = missionData.config;
    this.slug = missionData.slug;
    this.id = missionData.id;

    this.currentStep = 'story';
    this.attemptCount = 0;
    this.hintsUsed = 0;
    this.selectedReflection = null;

    this.companion = new MikoCompanion(this.slug);
    this.handler = new InteractionHandler(this.data);

    this.init();
  }

  init() {
    // Dock MIKO to the side-top during missions so it doesn't block controls
    const mikoDock = document.getElementById('miko-dock');
    if (mikoDock) {
      mikoDock.classList.add('dock-side-top');
    }

    this.bindNavigationButtons();
    this.bindChallengeButtons();
    this.bindReflection();
    this.setStep('story');

    // Auto-start playful background music if sound enabled
    if (window.SoundFX && !window.SoundFX.isMuted()) {
      window.SoundFX.startBgm();
    }
  }

  setStep(stepName) {
    this.currentStep = stepName;

    // Update Stepper UI
    document.querySelectorAll('.step-node').forEach(node => {
      node.classList.remove('active');
      if (node.dataset.step === stepName) {
        node.classList.add('active');
      }
    });

    // Update Stage Panels
    document.querySelectorAll('.stage-panel').forEach(panel => {
      panel.classList.remove('active');
    });
    const targetPanel = document.getElementById(`stage-${stepName}`);
    if (targetPanel) {
      targetPanel.classList.add('active');
    }

    // Step entry actions
    if (stepName === 'challenge') {
      const canvasEl = document.getElementById('canvas-game-area');
      const controlsEl = document.getElementById('controls-tray-area');
      this.handler.mount(canvasEl, controlsEl);
      
      const guide = this.companion.getMissionGuide(this.slug);
      const guideTextEl = document.getElementById('miko-guide-text');
      if (guideTextEl && guide) {
        guideTextEl.textContent = guide.text;
      }
      this.companion.playMissionGuide(this.slug);
    } else if (stepName === 'reflection') {
      this.loadReflectionData();
    }
  }

  bindNavigationButtons() {
    const btnStoryNext = document.getElementById('btn-story-next');
    if (btnStoryNext) {
      btnStoryNext.addEventListener('click', () => this.setStep('learn'));
    }

    const btnLearnBack = document.getElementById('btn-learn-back');
    if (btnLearnBack) {
      btnLearnBack.addEventListener('click', () => this.setStep('story'));
    }

    const btnLearnNext = document.getElementById('btn-learn-next');
    if (btnLearnNext) {
      btnLearnNext.addEventListener('click', () => this.setStep('challenge'));
    }
  }

  bindChallengeButtons() {
    const btnCheck = document.getElementById('btn-check-solution');
    const btnHint = document.getElementById('btn-request-hint');
    const btnListenGuide = document.getElementById('btn-listen-miko-guide');
    const feedbackBox = document.getElementById('in-canvas-feedback');

    if (btnListenGuide) {
      btnListenGuide.addEventListener('click', () => {
        this.companion.playMissionGuide(this.slug);
      });
    }

    if (btnHint) {
      btnHint.addEventListener('click', async () => {
        this.hintsUsed++;
        await this.companion.requestHint(this.attemptCount, this.handler.state);
      });
    }

    if (btnCheck) {
      btnCheck.addEventListener('click', async () => {
        this.attemptCount++;
        const badge = document.getElementById('attempt-badge');
        if (badge) badge.textContent = `Percobaan ${this.attemptCount}`;

        btnCheck.disabled = true;
        btnCheck.textContent = "Memeriksa...";

        const result = await this.handler.validateSolution();
        btnCheck.disabled = false;
        btnCheck.textContent = "Periksa Hasil Jawaban ✨";

        feedbackBox.style.display = 'block';
        if (result.success) {
          feedbackBox.style.background = '#DCFCE7';
          feedbackBox.style.color = '#15803D';
          feedbackBox.style.border = '2px solid #86EFAC';
          feedbackBox.innerHTML = `🎉 <strong>${result.message}</strong><br><button type="button" class="btn-kid btn-kid-accent" id="btn-to-reflection" style="margin-top: 8px; padding: 0.5rem 1.2rem; font-size: 14px;">Lanjut ke Refleksi &rarr;</button>`;

          document.getElementById('btn-to-reflection').addEventListener('click', () => {
            this.setStep('reflection');
          });

          // Show centered celebratory success modal
          const modal = document.getElementById('modal-challenge-success');
          const modalMsg = document.getElementById('modal-success-msg');
          if (modalMsg) {
            modalMsg.textContent = result.message || 'Jawabanmu benar dan semua langkah sudah tepat!';
          }
          if (modal) {
            modal.classList.add('active');
            const btnModalReflect = document.getElementById('btn-modal-to-reflection');
            if (btnModalReflect) {
              btnModalReflect.onclick = () => {
                modal.classList.remove('active');
                this.setStep('reflection');
              };
            }
            const btnModalStay = document.getElementById('btn-modal-stay');
            if (btnModalStay) {
              btnModalStay.onclick = () => {
                modal.classList.remove('active');
              };
            }
          }

          if (window.Celebration) {
            window.Celebration.burst({ count: 90 });
            window.Celebration.starShower({ count: 45, shootingStars: 6 });
          }
          if (window.SoundFX) {
            window.SoundFX.playSuccess();
            window.SoundFX.playStarShower();
          }

          this.companion.say("Luar biasa! Kamu berhasil memecahkan tantangannya! Ayo lanjutkan ke refleksi pembelajaran! 🌟");
        } else {
          feedbackBox.style.background = '#FEE2E2';
          feedbackBox.style.color = '#991B1B';
          feedbackBox.style.border = '2px solid #FCA5A5';
          feedbackBox.innerHTML = `⚠️ <strong>${result.message}</strong>`;

          // Asynchronously record failed attempt so backend attempt count accurately breaks first-try bonus
          fetch('?page=api&action=record_attempt', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-Token': this.data.csrf_token || ''
            },
            body: JSON.stringify({
              csrf_token: this.data.csrf_token || '',
              mission_id: this.id,
              hints_used: this.hintsUsed,
              is_success: false
            })
          }).catch(() => {});

          if (this.attemptCount >= 2) {
            this.companion.showHintBadge();
            this.companion.say("Jangan menyerah ya! Coba klik tombol Petunjuk MIKO untuk mendapat bantuan berharga! 💡");
          }
        }
      });
    }
  }

  loadReflectionData() {
    const refConfig = this.config.reflection || {
      question: "Apa hal baru yang kamu pelajari dari misi ini?",
      options: [
        "Saya belajar bagaimana bereksperimen dan menemukan solusi dengan sabar.",
        "Misi ini hanya bermain tombol tanpa arti.",
        "Komputer selalu bisa menyelesaikan sendiri tanpa manusia."
      ],
      correct: 0
    };

    const qText = document.getElementById('reflection-question-text');
    const tray = document.getElementById('reflection-options-tray');
    const btnSubmit = document.getElementById('btn-submit-reflection');

    if (qText) qText.textContent = refConfig.question;
    if (tray) {
      tray.innerHTML = '';
      refConfig.options.forEach((opt, idx) => {
        const label = document.createElement('label');
        label.className = 'reflection-option-label';
        label.innerHTML = `
          <input type="radio" name="reflection_choice" value="${idx}" style="accent-color: var(--color-primary); width: 20px; height: 20px;">
          <span>${opt}</span>
        `;
        label.querySelector('input').addEventListener('change', (e) => {
          this.selectedReflection = refConfig.options[idx];
          if (btnSubmit) btnSubmit.disabled = false;
        });
        tray.appendChild(label);
      });
    }

    if (btnSubmit) {
      btnSubmit.onclick = () => this.finishMission();
    }
  }

  async finishMission() {
    const btnSubmit = document.getElementById('btn-submit-reflection');
    if (btnSubmit) {
      btnSubmit.disabled = true;
      btnSubmit.textContent = "Menyimpan prestasimu...";
    }

    try {
      const solutionPayload = this.handler && typeof this.handler.getSolutionPayload === 'function'
        ? this.handler.getSolutionPayload()
        : null;

      const response = await fetch('?page=api&action=complete_mission', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': this.data.csrf_token || ''
        },
        body: JSON.stringify({
          csrf_token: this.data.csrf_token || '',
          mission_id: this.id,
          hints_used: this.hintsUsed,
          reflection_answer: this.selectedReflection,
          solution_payload: solutionPayload
        })
      });

      const data = await response.json();
      if (data.success) {
        this.renderRewardScreen(data);
        this.setStep('reward');
      } else {
        alert(data.error || "Gagal menyimpan hasil.");
        if (btnSubmit) {
          btnSubmit.disabled = false;
          btnSubmit.textContent = "Coba Simpan Lagi 🚀";
        }
      }
    } catch (err) {
      console.error("Error completing mission:", err);
      alert("Koneksi ke server terputus! Hasil misimu belum berhasil disimpan. Pastikan internetmu aktif dan klik tombol untuk mencoba lagi ya!");
      if (btnSubmit) {
        btnSubmit.disabled = false;
        btnSubmit.textContent = "Coba Simpan Lagi 🚀";
      }
    }
  }

  renderRewardScreen(result) {
    // 0. Stop mission BGM so celebration fanfare shines
    if (window.SoundFX) {
      window.SoundFX.stopBgm();
    }

    // 1. Trigger Canvas Confetti, Star Shower & Sound Fanfare
    if (window.Celebration) {
      window.Celebration.burst({ count: 120 });
      window.Celebration.starShower({ count: 55, shootingStars: 8 });
    }
    if (window.SoundFX) {
      window.SoundFX.playCelebration();
      window.SoundFX.playStarShower();
    }

    // 2. Staggered Animated Stars
    const starsTray = document.getElementById('reward-stars-tray');
    if (starsTray) {
      starsTray.innerHTML = '';
      const count = result.stars || 3;
      for (let i = 1; i <= count; i++) {
        const star = document.createElement('span');
        star.className = `star-pop-${Math.min(3, i)}`;
        star.style.display = 'inline-block';
        star.style.fontSize = '3.5rem';
        star.style.margin = '0 8px';
        star.textContent = '⭐';
        starsTray.appendChild(star);
      }
    }

    // 3. XP Breakdown with Animated Count-Up
    const xpTray = document.getElementById('xp-breakdown-tray');
    if (xpTray && result.xp_breakdown) {
      xpTray.innerHTML = '';
      result.xp_breakdown.forEach(item => {
        const row = document.createElement('div');
        row.className = 'xp-breakdown-item';
        row.innerHTML = `<span>${item.label}</span><span>+${item.amount} XP</span>`;
        xpTray.appendChild(row);
      });

      const totalRow = document.createElement('div');
      totalRow.className = 'xp-breakdown-item';
      totalRow.style.borderTop = '2px dashed #D97706';
      totalRow.style.paddingTop = '8px';
      totalRow.style.color = '#B45309';
      totalRow.style.fontSize = 'var(--fs-lg)';
      totalRow.style.fontWeight = '700';

      const totalLabel = document.createElement('span');
      totalLabel.textContent = 'Total Didapat:';
      const totalAmount = document.createElement('span');
      totalAmount.id = 'animated-xp-total';
      totalAmount.textContent = `+${result.total_awarded_xp} XP`;

      totalRow.appendChild(totalLabel);
      totalRow.appendChild(totalAmount);
      xpTray.appendChild(totalRow);

      if (window.Celebration) {
        window.Celebration.animateCountUp(totalAmount, 0, result.total_awarded_xp, 1200, '+', ' XP');
      }
    }

    // 4. Update Nav XP Counter
    const navXp = document.getElementById('nav-total-xp');
    if (navXp && result.level_info) {
      const prevXp = parseInt(navXp.textContent) || 0;
      if (window.Celebration) {
        window.Celebration.animateCountUp(navXp, prevXp, result.level_info.total_xp, 1000, '', '');
      } else {
        navXp.textContent = result.level_info.total_xp;
      }
    }

    // 5. Badges Alert
    if (result.new_achievements && result.new_achievements.length > 0) {
      const badgeBox = document.getElementById('unlocked-badge-alert');
      const badgeDesc = document.getElementById('unlocked-badge-desc');
      if (badgeBox && badgeDesc) {
        badgeBox.style.display = 'block';
        badgeBox.classList.add('popInBouncy');
        badgeDesc.textContent = `Kamu membuka medali: "${result.new_achievements[0].title}" (+${result.new_achievements[0].xp_reward} XP)!`;
      }
    }

    this.companion.say(`Horeee! Selamat atas keberhasilanmu! Kamu mendapatkan +${result.total_awarded_xp} XP baru! 🎊🎉`);
  }
}

// Auto-initialize when current mission exists
document.addEventListener('DOMContentLoaded', () => {
  if (window.CURRENT_MISSION) {
    window.engine = new MissionEngine(window.CURRENT_MISSION);
  }
});
