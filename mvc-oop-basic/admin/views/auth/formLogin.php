
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Đăng nhập Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css?v=3.2.0">
<script data-cfasync="false" nonce="a7afd72b-d856-4912-87bc-53aecc3af007">try{(function(w,d){!function(bH,bI,bJ,bK){if(bH.zaraz)console.error("zaraz is loaded twice");else{bH[bJ]=bH[bJ]||{};bH[bJ].executed=[];bH.zaraz={deferred:[],listeners:[]};bH.zaraz._v="5876";bH.zaraz._n="a7afd72b-d856-4912-87bc-53aecc3af007";bH.zaraz.q=[];bH.zaraz._f=function(bL){return async function(){var bM=Array.prototype.slice.call(arguments);bH.zaraz.q.push({m:bL,a:bM})}};for(const bN of["track","set","debug"])bH.zaraz[bN]=bH.zaraz._f(bN);bH.zaraz.init=()=>{var bO=bI.getElementsByTagName(bK)[0],bP=bI.createElement(bK),bQ=bI.getElementsByTagName("title")[0];bQ&&(bH[bJ].t=bI.getElementsByTagName("title")[0].text);bH[bJ].x=Math.random();bH[bJ].w=bH.screen.width;bH[bJ].h=bH.screen.height;bH[bJ].j=bH.innerHeight;bH[bJ].e=bH.innerWidth;bH[bJ].l=bH.location.href;bH[bJ].r=bI.referrer;bH[bJ].k=bH.screen.colorDepth;bH[bJ].n=bI.characterSet;bH[bJ].o=(new Date).getTimezoneOffset();if(bH.dataLayer)for(const bR of Object.entries(Object.entries(dataLayer).reduce((bS,bT)=>({...bS[1],...bT[1]}),{})))zaraz.set(bR[0],bR[1],{scope:"page"});bH[bJ].q=[];for(;bH.zaraz.q.length;){const bU=bH.zaraz.q.shift();bH[bJ].q.push(bU)}bP.defer=!0;for(const bV of[localStorage,sessionStorage])Object.keys(bV||{}).filter(bX=>bX.startsWith("_zaraz_")).forEach(bW=>{try{bH[bJ]["z_"+bW.slice(7)]=JSON.parse(bV.getItem(bW))}catch{bH[bJ]["z_"+bW.slice(7)]=bV.getItem(bW)}});bP.referrerPolicy="origin";bP.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bH[bJ])));bO.parentNode.insertBefore(bP,bO)};["complete","interactive"].includes(bI.readyState)?zaraz.init():bH.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");window.zaraz._p=async bc=>new Promise(bd=>{if(bc){bc.e&&bc.e.forEach(be=>{try{const bf=d.querySelector("script[nonce]"),bg=bf?.nonce||bf?.getAttribute("nonce"),bh=d.createElement("script");bg&&(bh.nonce=bg);bh.innerHTML=be;bh.onload=()=>{d.head.removeChild(bh)};d.head.appendChild(bh)}catch(bi){console.error(`Error executing script: ${be}\n`,bi)}});Promise.allSettled((bc.f||[]).map(bj=>fetch(bj[0],bj[1])))}bd()});zaraz._p({"e":["(function(w,d){})(window,document)"]});})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>BÁN THÚ CƯNG</a>
    </div>
    <div class="card-body">
    <?php if (!empty($_SESSION['error'])) { ?>
        <p class="text-danger login-box-msg"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php } else { ?>
        <p class="login-box-msg">Vui lòng đăng nhập</p>
    <?php } ?>
      <form action="<?= BASE_URL_ADMIN . '?act=check-login-admin' ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-1">
        <a href="">Quên mật khẩu</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8c78df7c7c0f484497ecbca7046644da1771523124516" integrity="sha512-8DS7rgIrAmghBFwoOTujcf6D9rXvH8xm8JQ1Ja01h9QX8EzXldiszufYa4IFfKdLUKTTrnSFXLDkUEOTrZQ8Qg==" data-cf-beacon='{"version":"2024.11.0","token":"2437d112162f4ec4b63c3ca0eb38fb20","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
