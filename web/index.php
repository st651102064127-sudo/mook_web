<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โรงพยาบาลหล่มสัก - Index</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="scene" id="scene">
        
        <div class="clouds" id="clouds">
            <div class="cloud c1"></div>
            <div class="cloud c2"></div>
        </div>

        <div class="ground" id="ground"></div>

        <div class="hospital-container" id="hospital">
            <div class="hospital-sign floating">
                <h1>โรงพยาบาลหล่มสัก</h1>
                <p>Lom Sak Hospital</p>
            </div>
            
            <div class="roof"></div>
            <div class="cross-symbol">
                <div class="cross-h"></div>
                <div class="cross-v"></div>
            </div>
            
            <div class="building">
                <!-- หน้าต่างซ้าย -->
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                
                <div class="main-door">
                    <div class="door-handle"></div>
                </div>

                <!-- หน้าต่างขวา -->
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
                <div class="window"></div>
            </div>
        </div>

        <div class="trees" id="trees">
            <div class="tree"><div class="leaves"></div><div class="trunk"></div></div>
            <div class="tree"><div class="leaves"></div><div class="trunk"></div></div>
            <div class="tree"><div class="leaves"></div><div class="trunk"></div></div>
        </div>

        <!-- UI Layer (ปรับแก้ใหม่) -->
        <div class="ui-layer">
            <div class="text-container">
                <h2 class="welcome-text">ยินดีต้อนรับ</h2>
                <p class="welcome-sub">ศูนย์การแพทย์ที่คุณไว้วางใจ</p>
            </div>
            <br>
            <button class="enter-btn " style="position:relative; top: 200px;" onclick="enterSite()">เข้าสู่เว็บไซต์</button>
        </div>

        <div class="footer-info">
            &copy; 2023 โรงพยาบาลหล่มสัก Lom Sak Hospital
        </div>

    </div>

    <script>
        const scene = document.getElementById('scene');
        const clouds = document.getElementById('clouds');
        const ground = document.getElementById('ground');
        const hospital = document.getElementById('hospital');
        const trees = document.getElementById('trees');

        document.addEventListener('mousemove', (e) => {
            const x = (window.innerWidth - e.pageX * 2) / 100; 
            const y = (window.innerHeight - e.pageY * 2) / 100; 

            clouds.style.transform = `translate(${x * 0.5}px, ${y * 0.5}px)`;
            ground.style.transform = `translateZ(50px) translate(${x * 0.8}px, ${y * 0.8}px)`;
            hospital.style.transform = `translateX(-50%) rotateY(${x * 0.5}deg) translateX(${x}px) translateY(${y}px)`;
            trees.style.transform = `translate(${x * 1.5}px, ${y * 1.5}px)`;
        });

        function enterSite() {
            const btn = document.querySelector('.enter-btn');
            const textContainer = document.querySelector('.text-container');
            
            textContainer.style.transition = 'opacity 0.5s, transform 0.5s';
            textContainer.style.opacity = '0';
            textContainer.style.transform = 'translateY(-20px)';
            
            btn.style.transform = 'scale(0.9)';
            btn.innerText = 'กำลังเข้าสู่ระบบ...';
            
            setTimeout(() => {
                window.location.href = 'main.php'
                
                // Reset (เอาออกได้ในการใช้งานจริง)
                textContainer.style.opacity = '1';
                textContainer.style.transform = 'translateY(0)';
                btn.innerText = 'เข้าสู่เว็บไซต์';
            }, 800);
        }
    </script>
</body>
</html>