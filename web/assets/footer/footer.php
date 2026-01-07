<!-- <footer class="footer bg-green-1 text-dark navbar-light" style="background-color: #f7f7f7; padding: 20px 50px;">
    <div class="p-3">footer</div>
    <img src="assets/images/icon/logo.png" alt="Lomsak Hospital Logo" style="height: 40px; margin-right: 10px;">
    <h3 style="margin: 0; font-size: 1.2em; ">โรงพยาบาลหล่มสัก</h3>
</footer> -->

<footer class="bg-success bg-green-1 py-5">
  <div class="container">
    <div class="row g-4">

      <!-- Column 1 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="d-flex align-items-center mb-3">
          <img src="assets/images/icon/logo.png" alt="Lomsak Hospital Logo" style="height: 40px;" class="me-2">
          <h3 class="h6 m-0">โรงพยาบาลหล่มสัก</h3>
        </div>
        <p class="small text-muted mb-1">
          โรงพยาบาลหล่มสัก<br>
          15 ถนนคนเดินชัย<br>
          อำเภอหล่มสัก <br>จังหวัดเพชรบูรณ์ 67110
        </p>
        <div class="d-flex align-items-center mt-2">
          <span class="me-2">📞</span>
          <span class="small text-muted">056 - 704120</span>
        </div>
      </div>

      <!-- Column 2 -->
      <div class="col-12 col-md-6 col-lg-3">
        <h4 class="h6 text-dark">หน่วยงานภายนอกที่เกี่ยวข้อง</h4>
        <ul class="external-list list-unstyled small">
          <li><a href="https://moph.go.th/" target="_blank" rel="noopener noreferrer">&rarr; กระทรวงสาธารณสุข</a></li>
          <li><a href="https://www.dtam.moph.go.th/" target="_blank" rel="noopener noreferrer">&rarr; กรมพัฒนาการแพทย์แผนไทย <br> และการแพทย์ทางเลือก</a></li>
          <li><a href="https://www.nhso.go.th/" target="_blank" rel="noopener noreferrer">&rarr; สำนักงานหลักประกันสุขภาพ</a></li>
          <li><a href="https://www.sso.go.th/" target="_blank" rel="noopener noreferrer">&rarr; สำนักงานประกันสังคม</a></li>
          <li><a href="https://www.cgd.go.th/" target="_blank" rel="noopener noreferrer">&rarr; กรมบัญชีกลาง</a></li>
          <li><a href="https://www.ha.or.th/" target="_blank" rel="noopener noreferrer">&rarr; สถาบันพัฒนาและรับรองคุณภาพ <br> โรงพยาบาล</a></li>
        </ul>
      </div>

     


      <!-- Column 3 -->
      <div class="col-12 col-md-6 col-lg-3">
        <h4 class="h6 text-dark">หน่วยงานวิชาชีพ</h4>
        <ul class="external-list list-unstyled small">
          <li><a href="https://www.tmc.or.th/" target="_blank" rel="noopener noreferrer">&rarr; แพทยสภา</a></li>
          <li><a href="https://www.dentalcouncil.or.th/" target="_blank" rel="noopener noreferrer">&rarr; ทันตแพทยสภา</a></li>
          <li><a href="https://www.pharmacycouncil.org/" target="_blank" rel="noopener noreferrer">&rarr; สภาเภสัชกรรม</a></li>
          <li><a href="https://www.tnmc.or.th/" target="_blank" rel="noopener noreferrer">&rarr; สภาการพยาบาล</a></li>
          <li><a href="https://mtcouncil.org/" target="_blank" rel="noopener noreferrer">&rarr; สภาเทคนิคการแพทย์</a></li>
          <li><a href="https://tsrt.or.th" target="_blank" rel="noopener noreferrer">&rarr; สมาคมรังสีเทคนิค</a></li>
          <li><a href="https://pt.or.th/PTCouncils/" target="_blank" rel="noopener noreferrer">&rarr; สภากายภาพบำบัด</a></li>
          <li><a href="https://www.ccph.or.th/" target="_blank" rel="noopener noreferrer">&rarr; สภาวิชาชีพสาธารณสุข</a></li>
        </ul>
      </div>



      <!-- Column 4 -->
      <div class="col-12 col-md-6 col-lg-3">
        <h4 class="h6 text-dark">เวลาทำการของโรงพยาบาล</h4>
        <div class="border rounded p-2 bg-white mb-2 d-flex justify-content-between small text-muted">
          <span>🕔 จันทร์ - ศุกร์</span>
          <span>08:30 - 16:30</span>
        </div>
        <div class="border rounded p-2 bg-white text-center">
          <p class="m-0 fw-bold small">Emergency : 24 ชั่วโมง</p>
        </div>
      </div>

    </div>
  </div>
</footer>

<!-- เพิ่ม JavaScript เพื่อทำให้เงาเข้มขึ้นเมื่อ scroll -->
<script>
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.modern-navbar');
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>

<!-- CSS -->
<style>
  .external-list li {
    margin: .35rem 0;
  }

  .external-list a {
    display: inline-block;
    color: #6c757d;
    /* สีเทาอ่อนคล้าย text-muted */
    text-decoration: none;
    padding: 3px 6px;
    border-radius: 6px;
    transition: transform .1s ease, color .15s ease;
  }

  .external-list a:hover,
  .external-list a:focus {
    color: #2b7a45;
    /* สีเมื่อ hover */
    transform: translateX(4px);
    text-decoration: none;
    background: rgba(43, 122, 69, 0.06);
  }

  .external-list a::before {
    content: "";
    display: inline-block;
    width: 6px;
    height: 6px;
    margin-right: 8px;
    vertical-align: middle;
    background: currentColor;
    opacity: .15;
    border-radius: 2px;
  }
</style>


<!-- <pre><?php print_r($_SESSION) ?></pre> -->