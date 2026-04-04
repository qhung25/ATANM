<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã hóa Bảo mật - Dark Mode</title>
    <!-- Nhúng icon từ Bootstrap Bi -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* --- RESET & CƠ BẢN --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top, #1a1a2e 0%, #0f0f1a 100%);
            min-height: 100vh;
            padding: 40px 20px;
            color: #e0e0e0;
        }

        h1.main-title {
            text-align: center;
            color: #ffffff;
            margin-bottom: 40px;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 0 10px rgba(74, 144, 226, 0.5);
        }

        /* --- BỐ CỤC GRID 3 CỘT --- */
        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        /* Responsive cho mobile */
        @media (max-width: 992px) {
            .wrapper {
                grid-template-columns: 1fr;
            }
        }

        /* --- THIẾT KẾ CARD (FORM) DARK --- */
        .cipher-card {
            background-color: #161625;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .cipher-card:hover {
            transform: translateY(-8px);
            border-color: rgba(74, 144, 226, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        .cipher-card h2 {
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            letter-spacing: 1px;
        }

        .card-caesar h2 { color: #4facfe; text-shadow: 0 0 8px rgba(79, 172, 254, 0.4); }
        .card-playfair h2 { color: #a18cd1; text-shadow: 0 0 8px rgba(161, 140, 209, 0.4); }
        .card-rsa h2 { color: #f093fb; text-shadow: 0 0 8px rgba(240, 147, 251, 0.4); }

        .input-group {
            margin-bottom: 18px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 13px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        textarea, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #2d2d44;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
            background-color: #0f0f1a;
            color: #ffffff;
        }

        textarea { height: 110px; resize: none; }

        input:focus, textarea:focus {
            border-color: #4facfe;
            box-shadow: 0 0 10px rgba(79, 172, 254, 0.2);
            background-color: #1a1a2e;
        }

        /* --- NÚT BẤM --- */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: auto;
            padding-top: 15px;
        }

        button {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            color: white;
            font-size: 13px;
            text-transform: uppercase;
        }

        .btn-encrypt { background: linear-gradient(to right, #00c6ff, #0072ff); }
        .btn-decrypt { background: linear-gradient(to right, #00b09b, #96c93d); }

        button:hover { opacity: 0.9; transform: scale(1.03); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        button:active { transform: scale(0.97); }

        /* --- KẾT QUẢ --- */
        .result-area {
            margin-top: 25px;
            background-color: #0a0a14;
            padding: 18px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
            min-height: 70px;
            font-size: 14px;
            word-break: break-all;
            display: none;
            font-family: 'Courier New', Courier, monospace;
        }

        .result-area.active { 
            display: block; 
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #666;
            display: block;
            margin-bottom: 8px;
        }

        #c_result, #p_result, #r_result {
            color: #00ffcc;
        }

        /* --- FOOTER & NAV --- */
        .footer {
            text-align: center;
            margin-top: 60px;
        }

        .back-link {
            text-decoration: none;
            color: #ff4757;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s;
            padding: 10px 20px;
            border: 1px solid #ff4757;
            border-radius: 30px;
        }

        .back-link:hover { 
            background-color: #ff4757;
            color: #fff;
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.4);
        }

        .nav-grid {
            display: inline-grid;
            grid-template-columns: repeat(3, 110px);
            gap: 12px;
            margin-bottom: 30px;
        }

        .nav-grid a {
            text-decoration: none;
            background: #161625;
            padding: 10px;
            font-size: 12px;
            border-radius: 8px;
            color: #aaa;
            border: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        .nav-grid a:hover {
            color: #fff;
            border-color: rgba(255,255,255,0.2);
            background: #1f1f33;
        }
    </style>
</head>
<body>

    <h1 class="main-title">Hệ Thống Mã Hóa Bảo Mật</h1>

    <div class="wrapper">
        
        <!-- CỘT 1: CAESAR -->
        <div class="cipher-card card-caesar" style="border-top: 4px solid #4facfe;">
            <h2>Caesar Cipher</h2>
            <div class="input-group">
                <label>Văn bản:</label>
                <textarea id="c_text" placeholder="Nhập bản rõ hoặc bản mã..."></textarea>
            </div>
            <div class="input-group">
                <label>Độ dịch (Key k):</label>
                <input type="number" id="c_key" value="3">
            </div>
            <div class="button-group">
                <button class="btn-encrypt" onclick="handleCaesar('encrypt')">Mã hóa</button>
                <button class="btn-decrypt" onclick="handleCaesar('decrypt')">Giải mã</button>
            </div>
            <div id="c_res_box" class="result-area" style="border-left: 4px solid #4facfe;">
                <span class="result-label">Kết quả đầu ra:</span>
                <span id="c_result"></span>
            </div>
        </div>

        <!-- CỘT 2: PLAYFAIR -->
        <div class="cipher-card card-playfair" style="border-top: 4px solid #a18cd1;">
            <h2>Playfair Cipher</h2>
            <div class="input-group">
                <label>Văn bản:</label>
                <textarea id="p_text" placeholder="Nhập văn bản..."></textarea>
            </div>
            <div class="input-group">
                <label>Khóa (Keyword):</label>
                <input type="text" id="p_key" value="MONARCHY" style="text-transform: uppercase;">
            </div>
            <div class="button-group">
                <button class="btn-encrypt" onclick="handlePlayfair('encrypt')" style="background: linear-gradient(to right, #6a11cb, #2575fc);">Mã hóa</button>
                <button class="btn-decrypt" onclick="handlePlayfair('decrypt')" style="background: linear-gradient(to right, #11998e, #38ef7d);">Giải mã</button>
            </div>
            <div id="p_res_box" class="result-area" style="border-left: 4px solid #a18cd1;">
                <span class="result-label">Kết quả đầu ra:</span>
                <span id="p_result"></span>
            </div>
        </div>

        <!-- CỘT 3: RSA -->
        <div class="cipher-card card-rsa" style="border-top: 4px solid #f093fb;">
            <h2>RSA Algorithm</h2>
            <div class="input-group">
                <label>Văn bản / Số:</label>
                <textarea id="r_text" placeholder="Mã hóa: text | Giải mã: số,số,số..."></textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="input-group" style="flex: 1;">
                    <label>E hoặc D:</label>
                    <input type="number" id="r_key" value="7">
                </div>
                <div class="input-group" style="flex: 1;">
                    <label>Số N:</label>
                    <input type="number" id="r_n" value="143">
                </div>
            </div>
            <div class="button-group">
                <button class="btn-encrypt" onclick="handleRSA('encrypt')" style="background: linear-gradient(to right, #f093fb, #f5576c);">Mã hóa</button>
                <button class="btn-decrypt" onclick="handleRSA('decrypt')" style="background: linear-gradient(to right, #ff9a9e, #fecfef); color: #333;">Giải mã</button>
            </div>
            <div id="r_res_box" class="result-area" style="border-left: 4px solid #f093fb;">
                <span class="result-label">Kết quả đầu ra:</span>
                <span id="r_result"></span>
            </div>
        </div>

    </div>

    <div class="footer">
        <div class="nav-grid">
            <a href="#">Rail Fence</a>
            <a href="#">Caesar</a>
            <a href="#">RSA</a>
        </div>
        <br><br>
        <a href="#" class="back-link">Quay lại trang cá nhân <i class="bi bi-arrow-right"></i></a>
    </div>

    <script>
        // Hiển thị kết quả
        function showResult(prefix, content) {
            const box = document.getElementById(prefix + '_res_box');
            const span = document.getElementById(prefix + '_result');
            span.innerText = content;
            box.classList.add('active');
        }

        // --- 1. LOGIC CAESAR ---
        function handleCaesar(action) {
            const text = document.getElementById('c_text').value;
            let shift = parseInt(document.getElementById('c_key').value) || 0;
            if (action === 'decrypt') shift = (26 - (shift % 26)) % 26;
            
            let result = "";
            for (let i = 0; i < text.length; i++) {
                let char = text[i];
                if (char.match(/[a-z]/i)) {
                    const code = text.charCodeAt(i);
                    const offset = (code >= 65 && code <= 90) ? 65 : 97;
                    result += String.fromCharCode(((code - offset + shift) % 26 + 26) % 26 + offset);
                } else {
                    result += char;
                }
            }
            showResult('c', result);
        }

        // --- 2. LOGIC PLAYFAIR ---
        function handlePlayfair(action) {
            let text = document.getElementById('p_text').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
            const key = document.getElementById('p_key').value.toUpperCase().replace(/J/g, 'I').replace(/[^A-Z]/g, '');
            
            let alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
            let combined = key + alphabet;
            let matrix = [];
            let seen = new Set();
            for (let char of combined) {
                if (!seen.has(char)) { seen.add(char); matrix.push(char); }
            }

            if (action === 'encrypt') {
                let temp = "";
                for(let i=0; i<text.length; i++) {
                    temp += text[i];
                    if (i+1 < text.length && text[i] === text[i+1]) temp += 'X';
                }
                if (temp.length % 2 !== 0) temp += 'X';
                text = temp;
            }

            let result = "";
            let step = (action === 'encrypt') ? 1 : 4;

            for (let i = 0; i < text.length; i += 2) {
                let a = text[i], b = text[i+1] || 'X';
                let idxA = matrix.indexOf(a), idxB = matrix.indexOf(b);
                let r1 = Math.floor(idxA / 5), c1 = idxA % 5;
                let r2 = Math.floor(idxB / 5), c2 = idxB % 5;

                if (r1 === r2) {
                    result += matrix[r1 * 5 + (c1 + step) % 5] + matrix[r2 * 5 + (c2 + step) % 5];
                } else if (c1 === c2) {
                    result += matrix[((r1 + step) % 5) * 5 + c1] + matrix[((r2 + step) % 5) * 5 + c2];
                } else {
                    result += matrix[r1 * 5 + c2] + matrix[r2 * 5 + c1];
                }
            }
            showResult('p', result);
        }

        // --- 3. LOGIC RSA ---
        function power(base, exp, mod) {
            let res = BigInt(1);
            base = BigInt(base) % BigInt(mod);
            exp = BigInt(exp);
            while (exp > 0n) {
                if (exp % 2n === 1n) res = (res * base) % BigInt(mod);
                base = (base * base) % BigInt(mod);
                exp = exp / 2n;
            }
            return Number(res);
        }

        function handleRSA(action) {
            const text = document.getElementById('r_text').value;
            const key = parseInt(document.getElementById('r_key').value);
            const n = parseInt(document.getElementById('r_n').value);

            if (action === 'encrypt') {
                let resArr = [];
                for (let i = 0; i < text.length; i++) {
                    resArr.push(power(text.charCodeAt(i), key, n));
                }
                showResult('r', resArr.join(', '));
            } else {
                let vals = text.split(',').map(v => v.trim());
                let resStr = "";
                vals.forEach(v => {
                    if (v && !isNaN(v)) resStr += String.fromCharCode(power(v, key, n));
                });
                showResult('r', resStr);
            }
        }
    </script>
</body>
</html>