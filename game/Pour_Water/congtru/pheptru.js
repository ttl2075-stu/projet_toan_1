// KHAI BÁO BIẾN
const mainElement = document.querySelector("main");
const navElement = document.querySelector("nav");
let waterContainer = document.querySelector("#canuoc");
const taskElement = document.querySelector(".assignment");
let glassNames = []; // BIẾN LẤY DATA TỪ CSDL
let glassOffsets = [];
let glassCount;
let glassElements;
let isAnimationRunning = false;
let lyOut = [];
let de_bai = debai;
console.log(de_bai);
// CÁC HÀM RỜI (KHÔNG THEO FLOW)
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));

    [array[i], array[j]] = [array[j], array[i]];
  }
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
  //   const xhr = new XMLHttpRequest();
  //   const url = "../assets/php/setting.php";
  //   xhr.open("POST", url, true);
  //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //   xhr.onload = function () {
  //     if (xhr.status === 200) {
  //       const response = xhr.responseText;
  //       colors = colorsSetting[response];
  //       console.log("a:" + colors);
  //     } else {
  //       console.error("Error retrieving colors from PHP");
  //       colors = colorsSetting[0];
  //       console.log("b:" + colors);
  //     }
  //   };
  //   xhr.send("action=getColorsUser");
}

const usedColors = [];
console.log(colors);

function getRandomColor() {
  //   const remainColors = colors.filter((color) => !usedColors.includes(color));
  //   let color = remainColors[Math.floor(Math.random() * remainColors.length)];
  //   usedColors.push(color);
  //   return color;
  // Chọn một màu ngẫu nhiên từ mảng colors
  const color = colors[Math.floor(Math.random() * colors.length)];
  return color;
}
console.log(usedColors);
function remove1waterr(lyAddWater) {
  if (isAnimationRunning) return; // Nếu đang chạy animation thì không cho click
  isAnimationRunning = true;
  // Hiệu ứng đổ nước
  let a = lyAddWater.firstElementChild;

  const newWater = document.createElement("div");
  newWater.className = "waterr";
  newWater.style.backgroundColor = a.style.backgroundColor;

  a.style.animationName = "dropWater";
  console.log();
  // document.querySelectorAll('.lyOut')[parseInt(lyAddWater.getAttribute('lystt'))-1];
  // Hiệu ứng nước
  let waterfall = lyAddWater.parentElement.parentElement;
  waterfall = waterfall.querySelector(".waterfall");
  waterfall.style.display = "block";
  document
    .querySelectorAll(".lyOut")
    [parseInt(lyAddWater.getAttribute("lystt")) - 1].appendChild(newWater);

  a.addEventListener("animationend", () => {
    waterfall.style.display = "none";
    a.remove();
    isAnimationRunning = false;
  });
}

// Gọi hàm callGetDebai để thực hiện AJAX request
getDebai();
function getDebai() {
  //   let a = [
  //     [2, 1],
  //     [3, 0],
  //   ];
  glassNames = de_bai;
  glassCount = glassNames.length;
  renderLy();
  //   const xhr = new XMLHttpRequest();
  //   const url = "./data.php";
  //   xhr.open("POST", url, true);
  //   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //   xhr.onload = function () {
  //     if (xhr.status === 200) {
  //       const response = xhr.responseText;
  //       glassNames = JSON.parse(response);
  //       glassCount = glassNames.length;
  //       renderLy();
  //     } else {
  //       console.error("Error retrieving colors from PHP");
  //       Window.reload();
  //     }
  //   };
  //   xhr.send("action=getDebai");
}

function renderLy() {
  mainElement.innerHTML = "";
  // Tạo các ly nước
  console.log("In cốc");

  for (let i = 1; i <= glassCount; i++) {
    mainElement.innerHTML += `
            <div class="ques-ly">
                <div class="question">${glassNames[i - 1][0]} - ${
      glassNames[i - 1][1]
    } = <span class="answer">?</span></div>
                <div class="warpper-ly">
                    <img src="../media/nap${i}.png" alt="" class="naply">
                    <div class="ly" id="lyid${i}" lySTT="${i}">
                    </div>
                </div>
                <div class="voinuoc">
                    <img src="../media/voi_nuoc.png" alt=""/>
                    <div class="waterfall pheptru" style="display: none;">
                        <div class="water">
                            <div class="fall m slow light-blue"></div>
                            <div class="fall s medium teal"></div>
                        </div>
                    </div>
                </div>
            </div>
    `;
    // Tạo các mực nước có sẵn theo giá trị num1
    const lyAddWater = document.getElementById(`lyid${i}`);
    let k = 0;
    for (j = 1; j <= glassNames[i - 1][0]; j++) {
      const newWater = document.createElement("div");
      newWater.className = "waterr";
      //   console.log(getRandomColor());
      console.log(colors[k]);

      newWater.style.backgroundColor = colors[k];
      lyAddWater.appendChild(newWater);
      k++;
      if (k == 9) {
        k == 0;
      }
    }
  }

  glassElements = [...mainElement.querySelectorAll(".warpper-ly")];
  const lyElements = mainElement.querySelectorAll(".ly");
  lyElements.forEach((ele) =>
    ele.addEventListener("click", () => remove1waterr(ele))
  );

  document.querySelector(".water-out").innerHTML = "";
  for (let i = 1; i <= glassCount; i++) {
    document.querySelector(".water-out").innerHTML += `
            <div class="warpper-ly">
                <div class="ly lyOut" id="lyoutid${i}"></div>
            </div>
        `;
  }
  lyOut = document.querySelectorAll(".lyOut");
  // document.querySelector(".action").innerHTML = `
  //       <button class="bn632-hover bn26" onclick="checkAnswer()">Nộp bài</button>
  //   `;
}

function checkAnswer() {
  glassElements = [...mainElement.querySelectorAll(".warpper-ly")];

  const check = glassElements.every((ele, index) => {
    return (
      ele.querySelectorAll(".waterr").length ==
      glassNames[index][0] - glassNames[index][1]
    );
  });

  if (check) {
    viewAnswer();
    alert("CHÚC MỪNG BẠN ĐÃ CHIẾN THẮNG");
  } else {
    alert("BẠN ĐÃ TRẢ LỜI SAI. HÃY THỬ LẠI NHÉ!!!");
  }
}

function resetGame() {
  renderLy();
}

function viewAnswer() {
  const viewAnswerElements = [...mainElement.querySelectorAll("span.answer")];
  viewAnswerElements.forEach((ele, index) => {
    ele.innerHTML = glassNames[index][0] - glassNames[index][1];
  });
}
