const readline = require('readline');
const math = require('mathjs');

let A = 0;
let B = 0;
const width = 80;
const height = 22;

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function draw() {
  const z = Array(1760).fill(0);
  const b = Array(1760).fill(' ');

  for (let j = 0; j < 628; j += 7) {
    for (let i = 0; i < 628; i += 2) {
      const c = Math.sin(i);
      const d = Math.cos(j);
      const e = Math.sin(A);
      const f = Math.sin(j);
      const g = Math.cos(A);
      const h = Math.cos(i);
      const D = 1 / (c * f * g + d * h + 5);
      const l = Math.floor(40 + 30 * D * (h * g - c * d * f));
      const m = Math.floor(12 + 15 * D * (h * d + c * g * f));
      const n = l + width * m;

      if (m >= 0 && m < height && l >= 0 && l < width && D > z[n]) {
        z[n] = D;
        b[n] = '.,-~:;=!*#$@'[Math.floor(8 * ((d * e - c * h * f) / 2 + 1))];
      }
    }
  }

  const output = b.join('');
  readline.cursorTo(process.stdout, 0, 0);
  console.log(output);
}

function update() {
  draw();
  A += 0.04;
  B += 0.08;
  setTimeout(update, 30);
}

update();
