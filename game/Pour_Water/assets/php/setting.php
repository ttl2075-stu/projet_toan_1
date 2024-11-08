<?php
$sound = [];
$size = 1;
$font;
$colorsUser = 0; // Bảng màu người dùng lựa chọn
$colors = [
    [
        '#FFDAB9',
        '#FF8C00',
        '#FF4500',
        '#DC143C',
        '#FF1493',
        '#FF69B4',
        '#FFA07A',
        '#8B4513',
        '#8A2BE2',
        '#DA70D6',
        '#B8860B',
        '#FFD700',
        '#7FFFD4',
        '#00CED1',
        '#00FF7F',
        '#1E90FF',
        '#32CD32',
        '#4682B4',
    ],
    [
        '#FF69B4' /* Hot Pink */,
        '#FF8C69' /* Salmon */,
        '#FF6347' /* Tomato */,
        '#FFD700' /* Gold */,
        '#DA70D6' /* Orchid */,
        '#BA55D3' /* Medium Orchid */,
        '#87CEEB' /* Sky Blue */,
        '#40E0D0' /* Turquoise */,
        '#3CB371' /* Medium Sea Green */,
        '#66CDAA' /* Medium Aquamarine */,
        '#F0E68C' /* Khaki */,
        '#FF7F50' /* Coral */,
        '#FF4500' /* Orange Red */,
        '#8B0000' /* Dark Red */,
        '#CD5C5C' /* Indian Red */,
        '#FFA500' /* Orange */,
        '#20B2AA' /* Light Sea Green */,
    ],
    [
        '#FF4500' /* Orange Red */,
        '#FF1493' /* Deep Pink */,
        '#FF6347' /* Tomato */,
        '#FFA07A' /* Light Salmon */,
        '#DB7093' /* Pale Violet Red */,
        '#FF69B4' /* Hot Pink */,
        '#FF7F50' /* Coral */,
        '#FFD700' /* Gold */,
        '#EE82EE' /* Violet */,
        '#BA55D3' /* Medium Orchid */,
        '#9370DB' /* Medium Purple */,
        '#7B68EE' /* Medium Slate Blue */,
        '#4682B4' /* Steel Blue */,
        '#00CED1' /* Dark Turquoise */,
        '#48D1CC' /* Medium Turquoise */,
        '#32CD32' /* Lime Green */,
        '#228B22' /* Forest Green */,
    ],
    [
        'red',
        'green',
        'blue',
        'yellow',
        'purple',
        'orange',
        'pink',
        'brown',
        'black',
        'gray',
    ]
];



// Hàm trả biến về JS
if (isset($_POST['action']) && $_POST['action'] == 'getColorsSetting') {
    echo getColorsSetting();
} else if (isset($_POST['action']) && $_POST['action'] == 'getColorsUser') {
    echo getColorsUser();
}

function getColorsSetting()
{
    return json_encode($GLOBALS['colors']);
}
function getColorsUser()
{
    return json_encode($GLOBALS['colorsUser']);
}
