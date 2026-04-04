<?php
session_start();
require_once 'db.php'; // Kết nối hệ thống

// Bảo mật: Chỉ cho phép người đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title> Mã Hóa Toán Học</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    :root {
        --math-bg: #121416;
        --math-paper: #1e2125;
        --math-accent: #00d4ff;
        --math-text: #ffffff;
        --math-label: #a0aab4;
        --math-border: #3d4248;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Segoe UI', Roboto, sans-serif;
        background-color: var(--math-bg);
        color: var(--math-text);
        padding: 20px; /* Giảm padding tổng thể */
        background-image: radial-gradient(var(--math-border) 1px, transparent 1px);
        background-size: 30px 30px;
        line-height: 1.4; /* Thu hẹp khoảng cách dòng */
        overflow-x: hidden;
    }

    .container {
        max-width: 1100px; /* Thu hẹp độ rộng khung */
        margin: 0 auto;
    }

    .header {
        text-align: center;
        margin-bottom: 25px; /* Giảm khoảng cách header */
        border-bottom: 2px double var(--math-accent);
        padding-bottom: 15px;
    }

    .header h1 { 
        font-size: 32px; /* Giảm cỡ chữ tiêu đề chính */
        font-weight: 800;
        letter-spacing: 1.5px; 
        color: var(--math-accent); 
        text-transform: uppercase;
    }

    .header p { 
        font-size: 15px; /* Giảm cỡ chữ slogan */
        opacity: 0.8; 
        margin-top: 5px;
        font-family: 'Consolas', monospace;
    }

    .grid-system {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px; /* Thu hẹp khoảng cách các ô */
    }

    .cipher-box {
        background: var(--math-paper);
        border: 2px solid var(--math-border);
        padding: 20px; /* Giảm padding trong ô */
        position: relative;
        border-radius: 8px;
    }

    h2 { 
        font-size: 20px; /* Giảm cỡ chữ đề mục */
        margin-bottom: 15px; 
        border-left: 4px solid var(--math-accent); 
        padding-left: 12px;
        color: var(--math-accent);
    }

    label { 
        display: block; 
        font-size: 13px; /* Giảm cỡ chữ nhãn */
        font-weight: bold;
        margin-bottom: 8px; 
        color: var(--math-accent); 
    }

    textarea, input {
        width: 100%;
        background: #000000;
        border: 1px solid var(--math-border);
        color: #00ffcc;
        padding: 10px; /* Thu nhỏ ô nhập liệu */
        font-family: 'Consolas', monospace;
        font-size: 16px; /* Cỡ chữ nhập liệu vừa đủ nhìn */
        margin-bottom: 12px;
        outline: none;
        border-radius: 4px;
    }

    textarea { height: 90px; resize: none; } /* Giảm chiều cao textarea */

    .btn-group { display: flex; gap: 10px; }
    
    button {
        flex: 1;
        padding: 10px; /* Thu nhỏ nút bấm */
        background: transparent;
        border: 2px solid var(--math-accent);
        color: var(--math-accent);
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: 0.2s;
        text-transform: uppercase;
    }

    button:hover { 
        background: var(--math-accent); 
        color: #000; 
    }

    .res-box {
        margin-top: 15px;
        padding: 12px;
        background: #0a0a0a;
        border-left: 3px solid var(--math-accent);
        min-height: 45px;
        font-size: 16px;
        font-family: 'Consolas', monospace;
        color: #fff;
    }

    .footer-nav {
        margin-top: 35px; /* Giảm khoảng cách nút quay lại */
        text-align: center;
    }

    .back-btn {
        color: #ff4757;
        text-decoration: none;
        border: 1.5px solid #ff4757;
        padding: 10px 30px;
        font-weight: bold;
        font-size: 14px;
        border-radius: 4px;
    }
</style>

</head>
<body>

<div class="container">
    <div class="header">
        <h1>MÃ HÓA </h1>
        <p>Đặng Quốc Hùng</p>
    </div>

    <div class="grid-system">
        <div class="cipher-box">
            <h2>01. Thuật toán Caesar</h2>
            <label>Dữ liệu nguồn (P):</label>
            <textarea id="c_in" placeholder="Nhập chuỗi ký tự cần xử lý..."></textarea>
            <label>Khóa dịch mã (k):</label>
            <input type="number" id="c_key" value="3">
            <div class="btn-group">
                <button onclick="calcCaesar(1)">MÃ HÓA</button>
                <button onclick="calcCaesar(-1)">GIẢI MÃ</button>
            </div>
            <div id="c_res" class="res-box"></div>
        </div>

        <div class="cipher-box" style="border-top: 3px solid var(--math-accent)">
            <h2>02. Ma trận Playfair</h2>
            <label>Văn bản đầu vào:</label>
            <textarea id="p_in" placeholder="Nhập văn bản..."></textarea>
            <label>Từ khóa (Keyword):</label>
            <input type="text" id="p_key" value="MATHEMATICS">
            <div class="btn-group">
                <button onclick="calcPlayfair('en')">THỰC THI (E)</button>
                <button onclick="calcPlayfair('de')">ĐẢO NGƯỢC (D)</button>
            </div>
            <div id="p_res" class="res-box"></div>
        </div>

        <div class="cipher-box">
            <h2>03. Giao thức RSA</h2>
        <div style="display: flex; gap: 10px; margin-bottom: 5px;">
            <div style="flex: 1;"><label>Số p (Prime):</label><input type="number" id="r_p" value="61"></div>
            <div style="flex: 1;"><label>Số q (Prime):</label><input type="number" id="r_q" value="53"></div>
            <div style="flex: 1;"><label>Số mũ e:</label><input type="number" id="r_e" value="17"></div>
        </div>
        
        <label>Thông điệp (m):</label>
        <textarea id="r_in" placeholder="Nhập văn bản (Mã hóa) hoặc dãy số (Giải mã)..."></textarea>
        
        <div class="btn-group">
            <button onclick="calcRSA('en')">MÃ HÓA</button>
            <button onclick="calcRSA('de')">GIẢI MÃ</button>
        </div>
        <div id="r_res" class="res-box"></div>
    </div>
    </div>

    <div class="footer-nav">
        <a href="hung.php" class="back-btn"><i class="bi bi-arrow-left"></i> QUAY LẠI TRANG CÁ NHÂN</a>
    </div>
</div>

<script>
    // Hàm hiển thị kết quả kiểu Console Terminal
    function show(id, msg) {
        const el = document.getElementById(id);
        el.style.display = 'block';
        el.innerHTML = `<span style="color:var(--math-accent)">[Hệ thống] Kết quả:</span> ` + msg;
    }

    // Xử lý Caesar
    function calcCaesar(dir) {
        let text = document.getElementById('c_in').value;
        let k = (parseInt(document.getElementById('c_key').value) % 26) * dir;
        let res = text.replace(/[a-z]/gi, c => {
            let s = c === c.toUpperCase() ? 65 : 97;
            return String.fromCharCode(((c.charCodeAt(0) - s + k + 26) % 26) + s);
        });
        show('c_res', res);
    }

    // Xử lý Playfair
    function calcPlayfair(mode) {
        let text = document.getElementById('p_in').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
        let key = document.getElementById('p_key').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
        let alpha = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
        let matrix = [...new Set(key + alpha)];
        
        if (mode === 'en') {
            let temp = "";
            for(let i=0; i<text.length; i++) {
                temp += text[i];
                if(i+1 < text.length && text[i] === text[i+1]) temp += 'X';
            }
            if(temp.length % 2 !== 0) temp += 'X';
            text = temp;
        }

        let res = "", step = (mode === 'en') ? 1 : 4;
        for(let i=0; i<text.length; i+=2) {
            let a = matrix.indexOf(text[i]), b = matrix.indexOf(text[i+1]);
            let r1 = ~~(a/5), c1 = a%5, r2 = ~~(b/5), c2 = b%5;
            if(r1 === r2) res += matrix[r1*5+(c1+step)%5] + matrix[r2*5+(c2+step)%5];
            else if(c1 === c2) res += matrix[((r1+step)%5)*5+c1] + matrix[((r2+step)%5)*5+c2];
            else res += matrix[r1*5+c2] + matrix[r2*5+c1];
        }
        show('p_res', res);
    }

    // Xử lý RSA
    function calcRSA(mode) {
    let text = document.getElementById('r_in').value;
    let p = BigInt(document.getElementById('r_p').value || 1);
    let q = BigInt(document.getElementById('r_q').value || 1);
    let e = BigInt(document.getElementById('r_e').value || 1);
    
    // Tính n từ p và q người dùng nhập vào
    let n = p * q;

    if(mode === 'en') {
        // Mã hóa từng ký tự
        let arr = []; 
        for(let i=0; i<text.length; i++) {
            arr.push(power(text.charCodeAt(i), e, n));
        }
        show('r_res', arr.join(', '));
    } else {
        // Giải mã dãy số (Dùng tạm e làm số mũ giải mã như logic cũ)
        let res = text.split(',').map(v => {
            let val = v.trim();
            return (val && !isNaN(val)) ? String.fromCharCode(Number(power(val, e, n))) : '';
        }).join('');
        show('r_res', res);
    }
}
</script>

</body>
</html>