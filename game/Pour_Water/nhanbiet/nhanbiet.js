// KHAI BÁO BIẾN
const mainElement = document.querySelector("main");
const waterContainer = document.querySelector("#canuoc");
const waterFall = document.querySelector(".waterfall");
const popup = document.querySelector(".popupCheck");
const popupWin = document.querySelector(".popupCheck-win");
const popupLose = document.querySelector(".popupCheck-lose");
const audioWin = document.querySelector(".audio-win");
const audioLose = document.querySelector(".audio-lose");
let glassNames = []; // BIẾN LẤY DATA TỪ CSDL
let glassOffsets = [];
let glassCount;
let glassElements;
let gameMode = "";

glassElements = [...mainElement.querySelectorAll(".warpper-ly")];

setOffsets(); // Xac dinh toa do cua cac ly
window.addEventListener("resize", setOffsets); // Sự kiện khi kích thước trình duyệt thay đổi

// Xác định chế độ chơi
gameMode = "click";
if (gameMode == "auto") {
  waterContainer.classList.add("slide");
  mainElement.addEventListener("click", autoPourWater);
} else if (gameMode == "click") {
  document.addEventListener("mousemove", mousemove); // Sự kiện khi người dùng di chuột thì ca nước chạy theo
  mainElement.addEventListener("click", handleWaterClick);
}

// HÀM XỬ LÝ CÁC SỰ KIỆN
// Hàm xáo trộn mảng
function shuffleArray(array) {
  // for (let i = array.length - 1; i > 0; i--) {
  //     const j = Math.floor(Math.random() * (i + 1));

  //     [array[i], array[j]] = [array[j], array[i]];
  // }
  return array;
}

// Hàm xác định toạ độ các ly nước khi kích thước trình duyệt thay đổi
function setOffsets() {
  console.log("Kích thước trình duyệt đã thay đổi");
  glassOffsets = [];
  glassElements.forEach((ele) => {
    glassOffsets.push({
      x1: ele.offsetLeft,
      x2: ele.offsetLeft + ele.offsetWidth,
    });
  });
  console.log(glassOffsets);
}

// Các hàm xử lý setting
function openSetting() {
  document.querySelector(".setting").style.display = "block";
}
function cancelcolor() {
  document.querySelector(".setting").style.display = "none";
}
function cfmcolor() {
  const colorSelect = document.querySelector("#colorSetting").value;
  colors = colorss[colorSelect * 1 - 1];
  cancelcolor();
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
  const xhr = new XMLHttpRequest();
  const url = "../assets/php/setting.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.responseText;
      colors = colorsSetting[response];
    } else {
      console.error("Error retrieving colors from PHP");
      colors = colorsSetting[0];
    }
  };
  xhr.send("action=getColorsUser");
}

const usedColors = [];
function getRandomColor() {
  const remainColors = colors.filter((color) => !usedColors.includes(color));
  let color = remainColors[Math.floor(Math.random() * remainColors.length)];
  usedColors.push(color);
  return color;
}

// Kiểm tra kết quả
function checkAnswer() {
  glassElements = [...mainElement.querySelectorAll(".warpper-ly")];

  const check = glassElements.every((ele, index) => {
    return (
      ele.querySelectorAll(".waterr").length ==
      ele.querySelector("span").innerHTML
    );
  });

  if (check) {
    console.log("a");

    popup.style.display = "block";
    popupWin.style.display = "block";
    audioWin.volume = 1;
    audioWin.play();
    document.getElementById("wheelContainer").style.display = "flex";
  } else {
    console.log("b");

    popup.style.display = "block";
    popupLose.style.display = "block";
    audioLose.volume = 1;
    audioLose.play();
  }
  setTimeout(() => {
    popup.style.display = "none";
    popupWin.style.display = "none";
    popupLose.style.display = "none";
    audioWin.pause();
    audioLose.pause();
  }, 5000);
}

// Reset game
function resetGame() {
  mainElement.querySelectorAll(".waterr").forEach((ele) => {
    ele.remove();
  });
}

// Di chuyển ca nước theo con trỏ chuột
function mousemove(event) {
  const mouseX = event.clientX;
  waterContainer.style.left = mouseX - 80 + "px";
}

// Hiệu ứng dịch nắp ly sang trái khi đổ nước
function animationNapLy(quesLyDiv) {
  const naply = quesLyDiv.querySelector(".naply");
  naply.style.animation = "moNapLy 0.54s linear";

  setTimeout(() => {
    naply.style.animation = "";
    naply.style.left = "100%";
  }, 540);
}

// Hiệu ứng dịch chuyển đề bài khi đổ nước
function animationDebai(quesLyDiv) {
  const debai = quesLyDiv.querySelector("span");
  debai.style.animation = "moDebai 0.54s linear";

  setTimeout(() => {
    debai.style.animation = "";
    debai.style.left = "150%";
  }, 540);
}

// Xử lý khi click để đổ nước
function handleWaterClick(event) {
  console.log("oke");

  const target = event.clientX;
  const indexLy = glassOffsets.findIndex((currentLy) => {
    return currentLy.x1 <= target - 20 && target <= currentLy.x2;
  });

  if (indexLy >= 0) {
    waterContainer.querySelector(".waterfall").style.display = "block";
    document.removeEventListener("mousemove", mousemove);
    mainElement.removeEventListener("click", handleWaterClick);
    const quesLyDiv = glassElements[indexLy];
    animationNapLy(quesLyDiv);
    animationDebai(quesLyDiv);

    const newWater = document.createElement("div");
    newWater.className = "waterr";
    const colorRandom = getRandomColor();
    newWater.style.backgroundColor = colorRandom;
    waterFall.style.backgroundColor = colorRandom;
    glassElements[indexLy].querySelector(".ly").appendChild(newWater);

    setTimeout(() => {
      waterContainer.querySelector(".waterfall").style.display = "none";
      mainElement.addEventListener("click", handleWaterClick);
      document.addEventListener("mousemove", mousemove);
      quesLyDiv.querySelector(".naply").style.animation =
        "dongNapLy 0.5s linear";
      quesLyDiv.querySelector(".naply").style.left = "0%";
      quesLyDiv.querySelector("span").style.animation = "dongDebai 0.5s linear";
      quesLyDiv.querySelector("span").style.left = "50%";
    }, 2000);
  }
}

// Hàm xử lý đổ nước (ca nước chạy tự động)
// Chưa xử lý
function autoPourWater(event) {
  const targett = document.querySelector("#canuoc").offsetLeft;
  const target = targett + 72;
  const indexLy = glassOffsets.findIndex((currentLy) => {
    return currentLy.x1 <= target - 20 && target <= currentLy.x2;
  });

  if (indexLy >= 0) {
    waterContainer.querySelector(".waterfall").style.display = "block";
    mainElement.removeEventListener("click", autoPourWater);
    waterContainer.style.animationPlayState = "paused";

    const newWater = document.createElement("div");
    newWater.className = "waterr";
    newWater.style.backgroundColor = getRandomColor();
    glassElements[indexLy].querySelector(".ly").appendChild(newWater);

    setTimeout(() => {
      waterContainer.querySelector(".waterfall").style.display = "none";
      mainElement.addEventListener("click", autoPourWater);
      waterContainer.style.animationPlayState = "running";
    }, 2000);
  }
}
