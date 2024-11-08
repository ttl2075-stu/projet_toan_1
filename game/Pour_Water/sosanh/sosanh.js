// KHAI BÁO BIẾN
const mainElement = document.querySelector("main");
const navElement = document.querySelector("nav");
let waterContainer = document.querySelector("#canuoc");
const taskElement = document.querySelector(".assignment");
let glassNames = []; // BIẾN LẤY DATA TỪ CSDL
let glassOffsets = [];
let glassCount;
let glassElements;
let key = "";
let type = "";
// console.log(debai);

const pathNapLy = [
  "./media/nap1.png",
  "./media/nap2.png",
  "./media/nap3.png",
  "./media/nap4.png",
  "./media/nap5.png",
  "./media/nap6.png",
  "./media/nap7.png",
  "./media/nap8.png",
];

// CÁC HÀM RỜI (KHÔNG THEO FLOW)
function shuffleArray(array) {
  //   for (let i = array.length - 1; i > 0; i--) {
  //     const j = Math.floor(Math.random() * (i + 1));

  //     [array[i], array[j]] = [array[j], array[i]];
  //   }
  return array;
}

// Xử lý màu sắc
let colorsSetting = [];
getColorsFromPHP();
function getColorsFromPHP() {
  const xhr = new XMLHttpRequest();
  const url = "../assets/php/setting.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.responseText;
      colorsSetting = JSON.parse(response);
    } else {
      console.error("Error retrieving colors from PHP");
    }
  };
  xhr.send("action=getColorsSetting");
}

let colors = [];
getColorsUser();
function getColorsUser() {
  colors = [
    "red",
    "green",
    "blue",
    "yellow",
    "purple",
    "orange",
    "pink",
    "brown",
    "black",
    "gray",
  ];
  // const xhr = new XMLHttpRequest();
  // const url = "../assets/php/setting.php";
  // xhr.open("POST", url, true);
  // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // xhr.onload = function () {
  //   if (xhr.status === 200) {
  //     const response = xhr.responseText;
  //     colors = colorsSetting[response];
  //   } else {
  //     console.error("Error retrieving colors from PHP");
  //     colors = colorsSetting[0];
  //   }
  // };
  // console.log(colors);
  // xhr.send("action=getColorsUser");
}

const usedColors = [];
function getRandomColor() {
  const remainColors = colors.filter((color) => !usedColors.includes(color));
  let color = remainColors[Math.floor(Math.random() * remainColors.length)];
  usedColors.push(color);
  return color;
}

/*
HÀM THEO THỨ TỰ XỬ LÝ BÀI:

*/
function callGetDebai() {
  // let a = [1, 2, 3];
  glassNames = debai;
  glassCount = glassNames.length;
  renderLy();
  // let xhr = new XMLHttpRequest();
  // xhr.open("POST", "data.php", true);
  // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // xhr.onreadystatechange = function () {
  //   if (xhr.readyState === 4 && xhr.status === 200) {
  //     // Xử lý phản hồi từ server.php
  //     glassNames = JSON.parse(xhr.responseText);
  //     glassCount = glassNames.length;

  //     renderLy();
  //   }
  // };

  // // Gửi yêu cầu với tham số action
  // xhr.send("action=getDebai");
}

function callGetDau() {
  type = dau;
  // let xhr = new XMLHttpRequest();
  // xhr.open("POST", "data.php", true);
  // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // xhr.onreadystatechange = function () {
  //   if (xhr.readyState === 4 && xhr.status === 200) {
  //     // Xử lý phản hồi từ server.php
  //     type = JSON.parse(xhr.responseText);
  //     console.log(type);
  //   }
  // };

  // // Gửi yêu cầu với tham số action
  // xhr.send("action=getDau");
}

callGetDau();
callGetDebai();

function renderLy() {
  // Trộn lại đề:

  // glassNames = shuffleArray(glassNames);
  let nap = 1;
  for (let i = 1; i <= glassCount; i++) {
    mainElement.innerHTML += `
        <div class="warpper-ly">
            <img src="../media/nap${nap}.png" alt="" class="naply">
            <div class="ly" id="ly${i}">
            </div>
            <span class="answer">${glassNames[i - 1]}</span>
        </div>
        `;
    // Tạo khối nước
    const ly = document.querySelector(`#ly${i}`);
    const k = glassNames[i - 1] * 1;
    let m = 0;
    for (let j = 1; j <= k; j++) {
      let waterElement = document.createElement("div");
      waterElement.className = "waterr";
      // console.log(colors[m]);

      waterElement.style.backgroundColor = colors[m];
      ly.appendChild(waterElement);
      m++;
      if (m == 10) {
        m = 0;
      }
    }
    console.log(nap);
    nap++;
    if (nap == 8) {
      nap = 1;
    }
  }

  glassElements = [...mainElement.querySelectorAll(".warpper-ly")];
  glassElements.forEach((element) => {
    element.addEventListener("click", () => chooseAnswer(element));
  });
}
