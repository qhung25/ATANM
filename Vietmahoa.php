<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Security Tool - Việt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --sec-bg: #0f172a;
            --sec-card: #1e293b;
            --sec-accent: #f59e0b; /* Amber/Orange */
            --sec-text: #f8fafc;
            --sec-border: #334155;
            --sec-neon: #fbbf24;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Fira Code', monospace;
            background-color: var(--sec-bg);
            color: var(--sec-text);
            padding: 30px;
            background-image: 
                linear-gradient(rgba(245, 158, 11, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(245, 158, 11, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 20px;
            background: var(--sec-card);
            border-radius: 15px;
            border-bottom: 4px solid var(--sec-accent);
        }

        .header h1 { 
            font-size: 28px;
            color: var(--sec-accent);
            text-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 25px;
        }

        .cipher-card {
            background: var(--sec-card);
            border: 1px solid var(--sec-border);
            padding: 25px;
            border-radius: 15px;
            transition: 0.3s;
        }

        .cipher-card:hover {
            border-color: var(--sec-accent);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.1);
        }

        h2 { 
            font-size: 18px; 
            margin-bottom: 20px; 
            color: var(--sec-accent);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        label { 
            font-size: 12px; 
            text-transform: uppercase;
            margin-bottom: 8px; 
            display: block;
            color: #94a3b8;
        }

        textarea, input {
            width: 100%;
            background: #020617;
            border: 1px solid var(--sec-border);
            color: var(--sec-neon);
            padding: 12px;
            font-size: 14px;
            margin-bottom: 15px;
            border-radius: 8px;
            outline: none;
        }

        textarea { height: 120px; }

        .btn-group { display: flex; gap: 12px; }
        
        button {
            flex: 1;
            padding: 12px;
            background: var(--sec-accent);
            border: none;
            color: #000;
            cursor: pointer;
            font-weight: 800;
            border-radius: 8px;
            transition: 0.2s;
        }

        button:hover { 
            filter: brightness(1.2);
            transform: translateY(-2px);
        }

        .result-area {
            margin-top: 20px;
            padding: 15px;
            background: #020617;
            border-radius: 8px;
            border: 1px dashed var(--sec-accent);
            min-height: 60px;
            word-break: break-all;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--sec-accent);
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border: 1px solid var(--sec-accent);
            border-radius: 8px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: var(--sec-accent);
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="bi bi-shield-shaded"></i> CYBER SECURITY</h1>
        <a href="viet.php" class="back-btn"><i class="bi bi-arrow-left"></i> TRỞ VỀ HỒ SƠ</a>
    </div>

    <div class="main-content">
        <!-- Caesar Section -->
        <div class="cipher-card">
            <h2>01. Caesar Cipher</h2>
            <label>Nội dung cần xử lý:</label>
            <textarea id="v_c_in" placeholder="Nhập văn bản..."></textarea>
            <label>Bước nhảy (Shift):</label>
            <input type="number" id="v_c_key" value="5">
            <div class="btn-group">
                <button onclick="v_calcCaesar(1)">MÃ HÓA</button>
                <button onclick="v_calcCaesar(-1)">GIẢI MÃ</button>
            </div>
            <div id="v_c_res" class="result-area">Đang chờ lệnh...</div>
        </div>

        <!-- Playfair & RSA Area -->
        <div style="display: flex; flex-direction: column; gap: 25px;">
            <div class="cipher-card">
                <h2>02. Playfair Algorithm</h2>
                <label>Văn bản nguồn:</label>
                <textarea id="v_p_in" style="height: 80px;"></textarea>
                <label>Từ khóa bảo mật:</label>
                <input type="text" id="v_p_key" value="VIETNAM">
                <div class="btn-group">
                    <button onclick="v_calcPlayfair('en')">ENCRYPT</button>
                    <button onclick="v_calcPlayfair('de')">DECRYPT</button>
                </div>
                <div id="v_p_res" class="result-area">Kết quả sẽ xuất hiện tại đây...</div>
            </div>

            <div class="cipher-card">
                <h2>03. RSA Implementation</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <div><label>P:</label><input type="number" id="v_r_p" value="13"></div>
                    <div><label>Q:</label><input type="number" id="v_r_q" value="11"></div>
                    <div><label>E:</label><input type="number" id="v_r_e" value="7"></div>
                </div>
                <label>Thông điệp:</label>
                <input type="text" id="v_r_in" placeholder="Text or Number sequence">
                <div class="btn-group">
                    <button onclick="v_calcRSA('en')">MÃ HÓA</button>
                    <button onclick="v_calcRSA('de')">GIẢI MÃ</button>
                </div>
                <div id="v_r_res" class="result-area">...</div>
            </div>
        </div>
    </div>
</div>

<script>
    function display(id, text) {
        document.getElementById(id).innerHTML = `<strong style="color:#fff">>_</strong> ${text}`;
    }

    // Caesar Logic
    function v_calcCaesar(dir) {
        let input = document.getElementById('v_c_in').value;
        let shift = (parseInt(document.getElementById('v_c_key').value) % 26) * dir;
        let out = input.replace(/[a-z]/gi, char => {
            let start = char <= 'Z' ? 65 : 97;
            return String.fromCharCode(((char.charCodeAt(0) - start + shift + 26) % 26) + start);
        });
        display('v_c_res', out);
    }

    // Playfair Logic (Giữ nguyên logic của nhóm nhưng đổi ID)
    function v_calcPlayfair(mode) {
        let text = document.getElementById('v_p_in').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
        let key = document.getElementById('v_p_key').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
        let matrix = [...new Set(key + "ABCDEFGHIKLMNOPQRSTUVWXYZ")];
        
        if (mode === 'en') {
            let t = "";
            for(let i=0; i<text.length; i++) {
                t += text[i];
                if(i+1 < text.length && text[i] === text[i+1]) t += 'X';
            }
            if(t.length % 2 !== 0) t += 'X';
            text = t;
        }

        let res = "", s = (mode === 'en') ? 1 : 4;
        for(let i=0; i<text.length; i+=2) {
            let a = matrix.indexOf(text[i]), b = matrix.indexOf(text[i+1]);
            let r1 = ~~(a/5), c1 = a%5, r2 = ~~(b/5), c2 = b%5;
            if(r1 === r2) res += matrix[r1*5+(c1+s)%5] + matrix[r2*5+(c2+s)%5];
            else if(c1 === c2) res += matrix[((r1+s)%5)*5+c1] + matrix[((r2+s)%5)*5+c2];
            else res += matrix[r1*5+c2] + matrix[r2*5+c1];
        }
        display('v_p_res', res);
    }

    // RSA Modular Exponentiation
    function v_power(base, exp, mod) {
        let res = 1n; base = BigInt(base) % BigInt(mod);
        exp = BigInt(exp);
        while (exp > 0n) {
            if (exp % 2n === 1n) res = (res * base) % BigInt(mod);
            base = (base * base) % BigInt(mod); exp /= 2n;
        }
        return res;
    }

    function v_calcRSA(mode) {
        let input = document.getElementById('v_r_in').value;
        let n = BigInt(document.getElementById('v_r_p').value) * BigInt(document.getElementById('v_r_q').value);
        let e = BigInt(document.getElementById('v_r_e').value);

        if(mode === 'en') {
            let encoded = [];
            for(let i=0; i<input.length; i++) encoded.push(v_power(input.charCodeAt(i), e, n).toString());
            display('v_r_res', encoded.join('-'));
        } else {
            let decoded = input.split('-').map(num => String.fromCharCode(Number(v_power(num, e, n)))).join('');
            display('v_r_res', decoded);
        }
    }
</script>

</body>
</html>