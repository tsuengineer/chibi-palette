const wrapper_width = 850;
const wrapper_height = 540;
const wrapper_radius = 30;
function createLicenseSvg() {
  // パラメータの初期化
  const inputParams = init();

  // SVG描画領域の初期化
  const svg = createSvg(0, 0, wrapper_width, wrapper_height);
  const p = document.querySelector('article');
  if (p.firstChild) {
    p.removeChild(p.firstChild);
  }
  p.appendChild(svg);

  // 土台を作成する
  createBase();

  // 背景を描く
  drawBackground(inputParams.licenseColor);

  // 線を引く
  drawLines();

  // 固定テキストを設定する
  drawFixedText();

  // 可変テキストを設定する
  drawVariableText(inputParams);

  // 画像を設定する
  setPicture(inputParams);
};

// getElementByIdするメソッド
const getValue = (id) => {
  const element = document.getElementById(id);
  if (element) {
    return element.value;
  }
  return null;
};

const init = () => {
  const licenseKinds = [];
  for (let i = 1; i <= 14; i++) {
    const checkbox = document.getElementById(`licenseKinds${i}`);
    if (checkbox.checked) {
      licenseKinds.push({
        id: i,
        name: checkbox.value,
      });
    }
  }

  const licenseColorInputs = document.getElementsByName('licenseColor');
  let selectedLicenseColor;
  for (let i = 0; i < licenseColorInputs.length; i++) {
    if (licenseColorInputs[i].checked) {
      selectedLicenseColor = licenseColorInputs[i].value;
      break;
    }
  }

  return {
    name: getValue('name'),
    birthYear: getValue('birthYear'),
    birthMonth: getValue('birthMonth'),
    birthDay: getValue('birthDay'),
    address: getValue('address'),
    issueYear: getValue('issueYear'),
    issueMonth: getValue('issueMonth'),
    issueDay: getValue('issueDay'),
    issueNumber: getValue('issueNumber'),
    expirationDate: getValue('expirationDate'),
    licenseConditions1: getValue('licenseConditions1'),
    licenseConditions2: getValue('licenseConditions2'),
    licenseConditions3: getValue('licenseConditions3'),
    licenseConditions4: getValue('licenseConditions4'),
    licenseNumber: getValue('licenseNumber'),
    bikeLicenseYear: getValue('bikeLicenseYear'),
    bikeLicenseMonth: getValue('bikeLicenseMonth'),
    bikeLicenseDay: getValue('bikeLicenseDay'),
    otherLicenseYear: getValue('otherLicenseYear'),
    otherLicenseMonth: getValue('otherLicenseMonth'),
    otherLicenseDay: getValue('otherLicenseDay'),
    secondClassLicenseYear: getValue('secondClassLicenseYear'),
    secondClassLicenseMonth: getValue('secondClassLicenseMonth'),
    secondClassLicenseDay: getValue('secondClassLicenseDay'),
    org1: getValue('org1'),
    org2: getValue('org2'),
    licenseColor: selectedLicenseColor,
    licenseKinds: licenseKinds,
    licenseName: getValue('licenseName'),
  }
}

// SVG描画エリアの初期化
function createSvg(x1, y1, x2, y2) {
  const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
  svg.setAttribute("viewBox", `${x1} ${y1} ${x2} ${y2} `);
  svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
  svg.setAttribute("version", "1.1");
  svg.setAttribute( "class", "license-svg");
  svg.setAttribute("width", wrapper_width);
  svg.setAttribute("height", wrapper_height);
  return svg;
}

// 土台を作成する
function createBase() {
  rect(0, 0, wrapper_width, wrapper_height, wrapper_radius, "#fff", "#000");
}

// 背景を描く
function drawBackground(color) {
  // 有効期限
  // #2da6df 青
  // #b29e59 金
  rect(30, 190, 500, 45, 0, color);

  // 免許番号
  rect(240, 377, 68, 25, 0, "#fcc");

  // 種類
  rect(337.5, 410, 192.5, 90, 0, "#fcc");
  line(337.5, 455, 530, 410, "#fff");
  line(337.5, 500, 530, 455, "#fff");
}

// 線を引く
function drawLines() {
  // 氏名枠
  rect(30, 30, 790, 40, 20, "none", "#000");

  // メイン枠
  rect(30, 110, 790, 400, 20, "none", "#000");

  // 縦線
  line(100, 30, 100, 70, "#000"); // 氏名
  line(540, 30, 540, 70, "#000"); // 生年月日
  line(100, 110, 100, 190, "#000"); // 住所
  line(100, 370, 100, 510, "#000"); // 免許番号

  // 横線
  line(30, 150, 820, 150, "#000"); // 住所
  line(30, 190, 575, 190, "#000"); // 交付
  line(30, 410, 100, 410, "#000"); // 二・小・原
  line(30, 440, 100, 440, "#000"); // 他
  line(30, 470, 100, 470, "#000"); // 二種

  // 種類枠
  rect(310, 410, 220, 90, 0, "none", "#000"); // 枠
  line(337.5, 410, 337.5, 500, "#000");
  line(365, 410, 365, 500, "#000");
  line(392.5, 410, 392.5, 500, "#000");
  line(420, 410, 420, 500, "#000");
  line(447.5, 410, 447.5, 500, "#000");
  line(475, 410, 475, 500, "#000");
  line(502.5, 410, 502.5, 500, "#000");
  line(337.5, 455, 530, 455, "#000"); // 横線
}

function drawFixedText() {
  text(50, 50, '氏名', '16px', '#000', false, 1.5);
  text(635, 50, '年', '16px', '#000');
  text(705, 50, '月', '16px', '#000');
  text(770, 50, '日生', '16px', '#000', false, 1.5);

  text(50, 130, '住所', '16px', '#000');
  text(50, 170, '交付', '16px', '#000');
  text(220, 170, '年', '16px', '#000');
  text(290, 170, '月', '16px', '#000');
  text(360, 170, '日', '16px', '#000');

  text(50, 255, '免許の', '14px', '#000');
  text(50, 280, '条件等', '14px', '#000');

  text(45, 390, '番 号', '16px', '#000');
  text(115, 390, '第', '16px', '#000');
  text(440, 390, '号', '16px', '#000');

  text(32.5, 425, '二･小･原', '16px', '#000');
  text(185, 425, '年', '16px', '#000');
  text(240, 425, '月', '16px', '#000');
  text(290, 425, '日', '16px', '#000');

  text(55, 455, '他', '16px', '#000');
  text(185, 455, '年', '16px', '#000');
  text(240, 455, '月', '16px', '#000');
  text(290, 455, '日', '16px', '#000');

  text(45, 490, '二 種', '16px', '#000');
  text(185, 485, '年', '16px', '#000');
  text(240, 485, '月', '16px', '#000');
  text(290, 485, '日', '16px', '#000');

  text(323.75, 430, '種類', '16px', '#000', true, 16);

  text(520, 525, 'ちびキャラパレット https://chibipalette.com', '12px', '#000');
}

function drawVariableText(params) {
  // 免許証の名前
  text(555, 200, params.licenseName, '22px', '#2af', true, 10);

  // 氏名
  text(120, 50, params.name, '20px', '#000');

  // 生年月日
  text(565, 50, params.birthYear, '18px', '#000');
  text(675, 50, params.birthMonth, '18px', '#000');
  text(740, 50, params.birthDay, '18px', '#000');

  // 住所
  text(120, 130, params.address, '22px', '#000');

  // 期限
  text(50, 213, params.expirationDate, '24px', '#000');

  // 交付年月日
  text(150, 170, params.issueYear, '20px', '#000');
  text(255, 170, params.issueMonth, '20px', '#000');
  text(325, 170, params.issueDay, '20px', '#000');

  // 交付番号
  text(420, 170, params.issueNumber, '20px', '#000');

  // 免許の条件
  text(140, 255, params.licenseConditions1, '20px', '#000');
  text(140, 285, params.licenseConditions2, '20px', '#000');
  text(140, 315, params.licenseConditions3, '20px', '#000');
  text(140, 345, params.licenseConditions4, '20px', '#000');

  // 優良マーク
  if (params.licenseColor === '#b29e59') {
    rect(60, 305, 60, 40, 10, "none", "#000", 4);
    text(67.5, 325, '優良', '22px', '#000');
  }

  // 免許番号
  text(180, 390, params.licenseNumber, '24px', '#000', false, 3);

  // 二小原
  text(115, 425, params.bikeLicenseYear, '18px', '#000');
  text(210, 425, params.bikeLicenseMonth, '18px', '#000');
  text(260, 425, params.bikeLicenseDay, '18px', '#000');

  // 他
  text(115, 455, params.otherLicenseYear, '18px', '#000');
  text(210, 455, params.otherLicenseMonth, '18px', '#000');
  text(260, 455, params.otherLicenseDay, '18px', '#000');

  // 二種
  text(115, 485, params.secondClassLicenseYear, '18px', '#000');
  text(210, 485, params.secondClassLicenseMonth, '18px', '#000');
  text(260, 485, params.secondClassLicenseDay, '18px', '#000');

  // 種類
  if (params.licenseKinds.some((element) => element.id === 1)) {
    text(352, 415, '大型', '18px', '#000', true, 1.5);
  } else {
    text(345, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 2)) {
    text(378, 415, '中型', '18px', '#000', true, 1.5);
  } else {
    text(374, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 3)) {
    text(406, 410, '準中型', '16px', '#000', true, -1.5);
  } else {
    text(402, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 4)) {
    text(433, 415, '普通', '18px', '#000', true, 1.5);
  } else {
    text(428, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 5)) {
    text(461, 415, '大特', '18px', '#000', true, 1.5);
  } else {
    text(456, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 6)) {
    text(488, 411, '大自ニ', '16px', '#000', true,-2);
  } else {
    text(483, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 7)) {
    text(516, 411, '普自ニ', '16px', '#000', true, -2);
  } else {
    text(512, 430, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 8)) {
    text(352, 458, '小特', '18px', '#000', true, 1.5);
  } else {
    text(345, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 9)) {
    text(378, 458, '原付', '18px', '#000', true, 1.5);
  } else {
    text(374, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 10)) {
    text(406, 458, '大二', '18px', '#000', true, 1.5);
  } else {
    text(402, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 11)) {
    text(433, 458, '中二', '18px', '#000', true, 1.5);
  } else {
    text(428, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 12)) {
    text(461, 458, '普二', '18px', '#000', true, 1.5);
  } else {
    text(456, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 13)) {
    text(488, 455, '大特ニ', '16px', '#000', true,-2);
  } else {
    text(483, 475, '-', '22px', '#000', false);
  }

  if (params.licenseKinds.some((element) => element.id === 14)) {
    text(516, 455, '引引ニ', '16px', '#000', true, -2);
  } else {
    text(512, 475, '-', '22px', '#000', false);
  }

  // 組織
  text(600, 470, params.org1, '16px', '#e62');
  text(620, 495, params.org2, '16px', '#e62');
}

function setPicture() {
  const preview = document.getElementById('preview');
  image(preview.src, 577.5, 155, 240, 300);
}

function line(x1, y1, x2, y2, color) {
  let line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
  line.setAttribute('x1', x1);
  line.setAttribute('y1', y1);
  line.setAttribute('x2', x2);
  line.setAttribute('y2', y2);
  line.setAttribute('stroke', color);
  line.setAttribute('stroke-linejoin', 'round');
  line.setAttribute('stroke-width', '2');
  document.querySelector('svg.license-svg').appendChild(line);
}

function rect(startX, startY, width, height, radius, background, color, strokeWidth = 2) {
  let rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
  rect.setAttribute('x', startX);
  rect.setAttribute('y', startY);
  rect.setAttribute('width', width);
  rect.setAttribute('height', height);
  rect.setAttribute('rx', radius);
  rect.setAttribute('ry', radius);
  rect.setAttribute('fill', background);
  rect.setAttribute('stroke', color);
  rect.setAttribute('stroke-width', strokeWidth);
  document.querySelector('svg.license-svg').appendChild(rect);
}

function text(x, y, word, size, color, verticalWriting = false, letterSpacing = 1) {
  let text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
  text.setAttribute('x', x);
  text.setAttribute('y', y);
  text.setAttribute('fill', color);
  text.setAttribute('stroke', 'none');
  text.setAttribute('text-anchor', 'start');
  text.setAttribute('dominant-baseline', 'central');
  text.setAttribute('font-size', size);
  text.setAttribute('font-weight', 'bold');
  text.setAttribute('letter-spacing', letterSpacing)
  if (verticalWriting) {
    text.setAttribute('writing-mode', 'tb');
  }
  text.innerHTML = word;
  document.querySelector('svg.license-svg').appendChild(text);
}

function image(src, x, y, width, height) {
  let image = document.createElementNS('http://www.w3.org/2000/svg', 'image');
  image.setAttribute('x', x);
  image.setAttribute('y', y);
  image.setAttribute('width', width);
  image.setAttribute('height', height);
  image.setAttribute('href', src);
  document.querySelector('svg.license-svg').appendChild(image);
}
