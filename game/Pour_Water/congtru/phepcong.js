// KHAI BÁO BIẾN
const mainElement = document.querySelector('main');
let waterContainer = document.querySelector('#canuoc');
let glassNames = []; // BIẾN LẤY DATA TỪ CSDL
let glassOffsets = [];
let glassCount;
let glassElements;
let gameMode = '';


glassElements = [...mainElement.querySelectorAll('.warpper-ly')];

setOffsets(); // Xac dinh toa do cua cac ly
window.addEventListener('resize', setOffsets); // Sự kiện khi kích thước trình duyệt thay đổi

// Xác định chế độ chơi
gameMode = 'click';
if (gameMode == 'auto') {
    waterContainer.classList.add('slide');
    mainElement.addEventListener('click', autoPourWater);
} else if (gameMode == 'click') {
    document.addEventListener('mousemove', mousemove); // Sự kiện khi người dùng di chuột thì ca nước chạy theo
    mainElement.addEventListener('click', handleWaterClick);
}


// HÀM XỬ LÝ CÁC SỰ KIỆN
// Hàm xáo trộn mảng
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Hàm xác định toạ độ các ly nước
function setOffsets() {
    console.log('Kích thước trình duyệt đã thay đổi');
    glassOffsets = [];
    glassElements.forEach((ele) => {
        glassOffsets.push({ x1: ele.offsetLeft, x2: ele.offsetLeft + ele.offsetWidth });
    });
    console.log(glassOffsets);
}

// Các hàm xử lý setting
function openSetting() {
    document.querySelector('.setting').style.display = 'block';
}
function cancelcolor() {
    document.querySelector('.setting').style.display = 'none';
}
function cfmcolor() {
    const colorSelect = document.querySelector('#colorSetting').value;
    colors = colorss[(colorSelect*1)-1];
    cancelcolor();
}

// Xử lý màu sắc
let colorsSetting = [];
getColorsFromPHP();
function getColorsFromPHP() {
    const xhr = new XMLHttpRequest();
    const url = '../assets/php/setting.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            colorsSetting = JSON.parse(response);
        } else {
            console.error('Error retrieving colors from PHP');
        }
    };
    xhr.send('action=getColorsSetting');
}

let colors = [];
getColorsUser();
function getColorsUser () {
    const xhr = new XMLHttpRequest();
    const url = '../assets/php/setting.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText;
            colors = colorsSetting[(response)];
        } else {
            console.error('Error retrieving colors from PHP');
            colors = colorsSetting[0];
        }
    };
    xhr.send('action=getColorsUser');
}

const usedColors = [];
function getRandomColor() {
    const remainColors = colors.filter((color) => !usedColors.includes(color));
    let color = remainColors[Math.floor(Math.random() * remainColors.length)];
    usedColors.push(color);
    return color;
}

function animationNapLy(quesLyDiv) {
    const naply = quesLyDiv.querySelector('.naply');
    naply.style.animation = 'moNapLy 0.54s linear';

    setTimeout(() => {
        naply.style.animation = '';
        naply.style.left = '100%';
    }, 500);
}

function checkAnswer() {
    glassElements = [...mainElement.querySelectorAll('.warpper-ly')];
    const check = glassElements.every((ele, index) => {
        const debai = ele.parentElement;
        const num1 = debai.querySelector('.num1').innerHTML;
        const num2 = debai.querySelector('.num2').innerHTML;
        return ele.querySelectorAll('.waterr').length == parseInt(num1) + parseInt(num2);
    });

    if (check) {
        viewAnswer();
        alert('CHÚC MỪNG BẠN ĐÃ CHIẾN THẮNG');
    } else {
        alert('BẠN ĐÃ TRẢ LỜI SAI. HÃY THỬ LẠI NHÉ!!!');
    }
}

function viewAnswer() {
    const viewAnswerElements = [...mainElement.querySelectorAll('span.answer')];
    viewAnswerElements.forEach((ele, index) => {
        const debai = ele.parentElement;
        const num1 = debai.querySelector('.num1').innerHTML;
        const num2 = debai.querySelector('.num2').innerHTML;
        debai.querySelector('.answer').innerHTML = parseInt(num1) + parseInt(num2);
    });
}

function resetGame() {
    mainElement.querySelectorAll('.waterr').forEach((ele) => {
        ele.remove();
    });
}

// Di chuyển ca nước theo con trỏ chuột
function mousemove(event) {
    const mouseX = event.clientX;
    waterContainer.style.left = mouseX - 80 + 'px';
}

function handleWaterClick(event) {
    const target = event.clientX;
    const indexLy = glassOffsets.findIndex((currentLy) => {
        return currentLy.x1 <= target - 20 && target <= currentLy.x2;
    });

    if (indexLy >= 0) {
        document.removeEventListener('mousemove', mousemove);
        mainElement.removeEventListener('click', handleWaterClick);
        const quesLyDiv = glassElements[indexLy].parentElement;
        animationNapLy(quesLyDiv);

        const newWater = document.createElement('div');
        newWater.className = 'waterr';

        const numberWaterr = quesLyDiv.querySelectorAll('.waterr').length;
        const num1 = parseInt(quesLyDiv.querySelector('.num1').innerHTML);
        glassElements[indexLy].querySelector('.ly').appendChild(newWater);
        if (numberWaterr == 0 || numberWaterr == num1) {
            newWater.style.backgroundColor = getRandomColor();
        } else if (numberWaterr < num1) {
            newWater.style.backgroundColor = quesLyDiv.querySelector('.waterr').style.backgroundColor;
        } else if (numberWaterr > num1) {
            newWater.style.backgroundColor = quesLyDiv.querySelectorAll('.waterr')[num1].style.backgroundColor;
        }

        quesLyDiv.querySelector('.naply').addEventListener('animationcancel', () => {
            waterContainer.querySelector('.waterfall').style.display = 'block';
            document.removeEventListener('mousemove', mousemove);
            mainElement.removeEventListener('click', handleWaterClick);

            setTimeout(() => {
                waterContainer.querySelector('.waterfall').style.display = 'none';
                mainElement.addEventListener('click', handleWaterClick);
                document.addEventListener('mousemove', mousemove);
                quesLyDiv.querySelector('.naply').style.animation = 'dongNapLy 0.5s linear';
                quesLyDiv.querySelector('.naply').style.left = '0%';
            }, 2000);
        });
    }
}

// function autoPourWater(event) {
//     const targett = document.querySelector('#canuoc').offsetLeft;
//     const target = targett + 72;
//     const indexLy = glassOffsets.findIndex((currentLy) => {
//         return currentLy.x1 <= target - 20 && target <= currentLy.x2;
//     });

//     if (indexLy >= 0) {
//         waterContainer.querySelector('.waterfall').style.display = 'block';
//         mainElement.removeEventListener('click', autoPourWater);
//         waterContainer.style.animationPlayState = 'paused';
//         glassElements[indexLy].querySelector(`.ly`).innerHTML += `
//          <div class="waterr" style="background-color: ${getRandomColor()};"></div>
//       `;

//         setTimeout(() => {
//             waterContainer.querySelector('.waterfall').style.display = 'none';
//             mainElement.addEventListener('click', autoPourWater);
//             waterContainer.style.animationPlayState = 'running';
//         }, 2000);
//     }
// }
