const fs = require('fs');
const path = require('path');

// Simple Mock DOM
class MockElement {
  constructor(tag = 'div') {
    this.tagName = tag.toUpperCase();
    this.children = [];
    this.childNodes = [];
    this.classList = {
      _classes: new Set(),
      add(c) { this._classes.add(c); },
      remove(c) { this._classes.delete(c); },
      contains(c) { return this._classes.has(c); }
    };
    this._textContent = '';
  }

  get textContent() {
    if (this.childNodes.length === 0) return this._textContent;
    return this.childNodes.map(n => n.textContent).join('');
  }

  set textContent(val) {
    this._textContent = String(val);
    this.children = [];
    this.childNodes = [];
  }

  appendChild(node) {
    this.childNodes.push(node);
    if (node instanceof MockElement) {
      this.children.push(node);
    }
    return node;
  }

  get innerHTML() {
    if (this.childNodes.length === 0) {
      return this._textContent
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }
    return this.childNodes.map(n => {
      if (n instanceof MockElement) {
        const tag = n.tagName.toLowerCase();
        if (tag === 'br') return '<br>';
        return '<' + tag + '>' + n.innerHTML + '</' + tag + '>';
      }
      return n.textContent
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }).join('');
  }
}

global.document = {
  getElementById(id) {
    return new MockElement('div');
  },
  createElement(tag) {
    return new MockElement(tag);
  }
};

global.window = {};
const code = fs.readFileSync('public/js/engine/MikoCompanion.js', 'utf8');
eval(code);

const companion = new window.MikoCompanion('tanaman-layu');

const payloads = [
  '<script>alert(1)</script>',
  '<img src=x onerror=alert(1)>',
  'Teks biasa MIKO',
  'Teks dengan "quotes" dan \'single\' serta <tag> & entity'
];

console.log('=== PENGUJIAN DOM XSS MIKOCOMPANION ===');

let allPassed = true;

for (const p of payloads) {
  // 1. Test say()
  companion.say(p);
  const sayHtml = companion.bubbleText.innerHTML;
  const sayHasScript = companion.bubbleText.children.some(c => c.tagName === 'SCRIPT');
  const sayHasImg = companion.bubbleText.children.some(c => c.tagName === 'IMG');
  const saySafe = !sayHasScript && !sayHasImg;
  if (!saySafe) allPassed = false;

  console.log(`[TEST say()] Payload: ${p}`);
  console.log(`  innerHTML: ${sayHtml}`);
  console.log(`  Rendered as literal text: ${saySafe ? 'YES (PASS)' : 'NO (FAIL)'}`);

  // 2. Test renderHint()
  companion.renderHint(1, p);
  const hintHtml = companion.bubbleText.innerHTML;
  const hintHasScript = companion.bubbleText.children.some(c => c.tagName === 'SCRIPT');
  const hintHasImg = companion.bubbleText.children.some(c => c.tagName === 'IMG');
  const hintSafe = !hintHasScript && !hintHasImg;
  if (!hintSafe) allPassed = false;

  console.log(`[TEST renderHint()] Payload: ${p}`);
  console.log(`  innerHTML: ${hintHtml}`);
  console.log(`  Rendered as literal text: ${hintSafe ? 'YES (PASS)' : 'NO (FAIL)'}`);
  console.log('---');
}

// 3. Test safe emphasis wrapper
companion.say('<em>MIKO sedang menyiapkan petunjuk... 💭</em>');
const emHtml = companion.bubbleText.innerHTML;
const hasEm = companion.bubbleText.children.some(c => c.tagName === 'EM');
console.log(`[TEST say() with <em>]:`);
console.log(`  innerHTML: ${emHtml}`);
console.log(`  Has EM element: ${hasEm ? 'YES (PASS)' : 'NO (FAIL)'}`);
if (!hasEm) allPassed = false;

// 4. Test progressive hint levels (1, 2, 3)
for (let lvl = 1; lvl <= 3; lvl++) {
  companion.renderHint(lvl, `Petunjuk rahasia level ${lvl}`);
  const hasStrong = companion.bubbleText.children.some(c => c.tagName === 'STRONG');
  const hasBr = companion.bubbleText.children.some(c => c.tagName === 'BR');
  const hasSpan = companion.bubbleText.children.some(c => c.tagName === 'SPAN');
  console.log(`[TEST Hint Level ${lvl}]: STRONG=${hasStrong}, BR=${hasBr}, SPAN=${hasSpan} -> ${hasStrong && hasBr && hasSpan ? 'PASS' : 'FAIL'}`);
  if (!hasStrong || !hasBr || !hasSpan) allPassed = false;
}

console.log('\n======================================');
console.log(`HASIL AKHIR: ${allPassed ? 'SEMUA UJI DOM XSS LULUS (PASS)' : 'ADA UJI YANG GAGAL'}`);
console.log('======================================');

if (!allPassed) process.exit(1);
