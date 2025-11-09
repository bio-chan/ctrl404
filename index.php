<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หนังแผน(ไม่)ลับนักศีกษาไซเบอร์ :: C T R L</title>
    <!-- โหลด Tailwind CSS CDN --><script src="https://cdn.tailwindcss.com"></script>
    <!-- ตั้งค่า Font Kanit และ Monospace --><style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap');
        body {
            font-family: 'Kanit', sans-serif; /* เปลี่ยนเป็น Kanit */
            cursor: none; /* ซ่อนเคอร์เซอร์เพื่อความเป็นฮาคเกอร์ */
            transition: background-color 0.1s linear; /* ให้พื้นหลังเปลี่ยนสีแบบนุ่มนวล */
        }
        #ctrl-output {
            line-height: 1; /* กำหนด line-height ให้ชิดกัน */
            word-break: break-all;
            white-space: pre-wrap; /* เพื่อให้ JavaScript สามารถใช้ \n ได้ */
            display: block;
            transition: color 0.1s linear; /* ให้ตัวอักษรเปลี่ยนสีแบบนุ่มนวล */
        }
        /* กำหนด Monospace font สำหรับตัวอักษรเพื่อการจัดเรียงที่แม่นยำ */
        #ctrl-output {
            font-family: monospace;
            font-size: 14px; 
        }
        /* Style สำหรับปุ่มปิด */
        #close-button {
            transition: opacity 0.3s;
        }
        #close-button:hover {
            opacity: 1;
        }
        /* Animation for wrong password */
        @keyframes shake {
          0% { transform: translateX(0); }
          20% { transform: translateX(-10px); }
          40% { transform: translateX(10px); }
          60% { transform: translateX(-10px); }
          80% { transform: translateX(10px); }
          100% { transform: translateX(0); }
        }
        .shake {
          animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
          transform: translate3d(0, 0, 0);
        }
    </style>
</head>
<body class="bg-black text-white overflow-hidden p-0 m-0">

    <!-- LOGIN SCREEN (Default View) -->
    <div id="login-screen" class="absolute inset-0 flex items-center justify-center p-8 bg-black z-30">
        <div id="login-box" class="bg-neutral-900 border-2 border-fuchsia-500 rounded-lg p-10 shadow-2xl max-w-sm w-full text-center">
            <h1 class="text-4xl font-mono font-bold mb-4 text-green-400 animate-pulse">
                [ LOGIN PROTOCOL ]
            </h1>
            <p class="text-sm font-semibold mb-6 text-fuchsia-400">
                // INPUT ACCESS CODE TO PROCEED //
            </p>

            <input type="text" id="password-input" placeholder="ACCESS CODE" 
                   class="w-full p-3 mb-4 text-lg text-yellow-300 bg-black border-2 border-green-500 rounded-md focus:outline-none focus:border-fuchsia-500 font-mono tracking-widest text-center"
                   maxlength="7" autocomplete="off" onkeydown="if(event.key === 'Enter') checkPassword()">
            
            <button id="breach-button" onclick="checkPassword()" 
                    class="w-full py-3 font-bold text-lg bg-red-700 hover:bg-red-600 rounded-md transition duration-200 uppercase text-white shadow-lg disabled:bg-gray-700 disabled:cursor-not-allowed">
                ENTER
            </button>

            <p id="error-message" class="mt-4 text-red-500 font-mono text-sm hidden">ACCESS DENIED / SECURITY ALERT</p>
        </div>
    </div>
    
    <!-- MAIN CONTENT (Hidden until successful login) -->
    <div id="main-content" class="hidden absolute inset-0">
        
        <!-- ส่วนแสดงผล C T R L (พื้นหลังวนลูป) -->
        <pre id="ctrl-output" class="absolute inset-0 text-opacity-80"></pre>

        <!-- OVERLAY: ข้อมูลรับสมัคร (แสดงทับพื้นหลัง) -->
        <div class="absolute inset-0 flex items-center justify-center p-8 z-10">
            <div class="bg-black bg-opacity-70 border-2 border-green-500 rounded-xl p-8 shadow-2xl max-w-lg w-full text-center transform hover:scale-[1.02] transition-transform duration-300">
                <h1 class="text-3xl md:text-4xl font-bold mb-1 text-fuchsia-400 tracking-wider animate-pulse">
                    [[ หนังแผน(ไม่)ลับนักศีกษาไซเบอร์ ]]
                </h1>
                <!-- เพิ่มคำว่า alice ตรงนี้ -->
                <p class="text-xl font-semibold mb-4 text-green-400">
                    // alice //
                </p>
                
                <p class="text-xl md:text-2xl font-mono text-green-400 mt-4 border-t border-green-700 pt-4">
                    > MISSION STATUS: OPEN <
                </p>
                <p class="text-lg md:text-xl font-semibold text-yellow-400 mt-2">
                    รับสมัครตั้งแต่วันนี้ถึงวันที่ 16
                </p>
                
                <!-- ส่วน QR CODE -->
                <div class="mt-8 pt-4 border-t border-fuchsia-700">
                    <p class="text-sm font-semibold text-fuchsia-400 mb-3 uppercase">
                        // SCAN TO APPLY //
                    </p>
                    <img src="https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=https://movie-cyber-student.com/apply" 
                         alt="QR Code for Application" 
                         onerror="this.onerror=null;this.src='https://placehold.co/150x150/000/fff?text=QR+CODE+LINK'"
                         class="mx-auto border-4 border-green-500 rounded-lg p-1 bg-white">
                    <p class="text-xs text-gray-500 mt-2 font-mono">
                        [Link: movie-cyber-student.com/apply]
                    </p>
                </div>
                
                <p class="text-sm text-gray-400 mt-6">
                    (ตั้งแต่วันี้ถึง 16)
                </p>
            </div>
        </div>
        
        <!-- ข้อความเตือน (ซ่อนไว้ ให้แสดงเมื่อผู้ใช้เลื่อนเมาส์) -->
        <div id="close-button" class="fixed bottom-0 right-0 m-4 p-2 bg-red-800 bg-opacity-30 text-white rounded-lg shadow-xl opacity-0 hover:opacity-100 transition-opacity z-20">
            <span class="font-bold">!! SYSTEM RUNNING !!</span>
            <div class="text-xs">เลื่อนเมาส์มาที่นี่ แล้วคลิกเพื่อหยุด</div>
        </div>
    </div>

    <script>
        const outputDiv = document.getElementById('ctrl-output');
        const bodyElement = document.body;
        const mainContent = document.getElementById('main-content');
        const loginScreen = document.getElementById('login-screen');
        const passwordInput = document.getElementById('password-input');
        const errorMessage = document.getElementById('error-message');
        const loginBox = document.getElementById('login-box');
        const breachButton = document.getElementById('breach-button');
        
        // C T R L Logic Variables
        const pattern = 'C T R L ';
        const loopInterval = 200; 
        const fontSize = 14; 
        const lineHeight = 14; 
        const CORRECT_PASSWORD = 'CTRL404';

        const colors = [
            'text-green-800', 'text-fuchsia-800'
        ];
        const backgroundColors = [
            'bg-black', 'bg-neutral-900'
        ];

        let currentColorIndex = 0;
        let isRunning = false; // Starts false, only runs after successful login

        // --- Core Functions for CTRL Animation ---
        
        function renderCTRL() {
            if (!isRunning) return;

            const width = window.innerWidth;
            const height = window.innerHeight;

            const charWidthApprox = fontSize * 0.6; 
            const charHeightApprox = lineHeight; 

            const repetitionsPerLine = Math.ceil(width / charWidthApprox / pattern.length) + 1;
            const linesNeeded = Math.ceil(height / charHeightApprox) + 1;

            let lineContent = pattern.repeat(repetitionsPerLine);
            lineContent = lineContent.substring(0, Math.floor(width / charWidthApprox));

            let fullText = '';
            for (let i = 0; i < linesNeeded; i++) {
                fullText += lineContent + '\n';
            }

            outputDiv.textContent = fullText;
        }

        function loop() {
            if (!isRunning) return;
            
            // สลับสี
            outputDiv.classList.remove(...colors);
            bodyElement.classList.remove(...backgroundColors);
            currentColorIndex = (currentColorIndex + 1) % colors.length;
            outputDiv.classList.add(colors[currentColorIndex]);
            bodyElement.classList.add(backgroundColors[currentColorIndex]);

            renderCTRL(); 

            setTimeout(loop, loopInterval);
        }

        // --- Login Protocol Logic ---
        
        function startMainProtocol() {
            loginScreen.classList.add('hidden');
            mainContent.classList.remove('hidden');
            isRunning = true;
            
            // Start the infinite loop and resize listener
            loop();       
            window.addEventListener('resize', renderCTRL);
        }

        function checkPassword() {
            if (breachButton.disabled) return;
            
            const enteredCode = passwordInput.value.toUpperCase().trim();
            
            if (enteredCode === CORRECT_PASSWORD) {
                // SUCCESS
                errorMessage.classList.add('hidden');
                passwordInput.classList.remove('border-red-500');
                passwordInput.classList.add('border-green-500');
                loginBox.classList.remove('shake');
                
                // Delay slightly to show success color before switching
                setTimeout(startMainProtocol, 500);

            } else {
                // FAILURE
                errorMessage.textContent = 'ACCESS DENIED / SECURITY ALERT';
                errorMessage.classList.remove('hidden');
                passwordInput.classList.add('border-red-500');
                loginBox.classList.add('shake');
                
                // Disable button for cooldown
                breachButton.disabled = true;
                breachButton.textContent = 'LOCKED (3s COOLDOWN)';

                setTimeout(() => {
                    breachButton.disabled = false;
                    breachButton.textContent = 'BREACH';
                    loginBox.classList.remove('shake');
                    passwordInput.classList.remove('border-red-500');
                    errorMessage.classList.add('hidden');
                    passwordInput.value = '';
                    passwordInput.focus();
                }, 3000);
            }
        }

        // --- Termination Logic ---

        function stopCTRL() {
            isRunning = false;
            outputDiv.textContent = 'SYSTEM TERMINATED.';
            outputDiv.className = 'absolute inset-0 p-4 text-green-500 text-xl flex items-center justify-center';
            bodyElement.className = 'bg-black text-white overflow-hidden p-0 m-0';
            window.removeEventListener('resize', renderCTRL);
        }

        // --- Initialization ---

        window.onload = () => {
            // Set initial colors and start the login process
            outputDiv.classList.add(colors[currentColorIndex]);
            bodyElement.classList.add(backgroundColors[currentColorIndex]);
            passwordInput.focus();
        };

        document.getElementById('close-button').addEventListener('click', stopCTRL);

    </script>
</body>
</html>