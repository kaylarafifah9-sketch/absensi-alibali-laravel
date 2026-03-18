<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Absensi Ali Bali Express</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:#F0F4F8;min-height:100vh;display:flex;justify-content:center;align-items:flex-start;padding:24px 12px}
.phone{width:390px;background:#fff;border-radius:32px;box-shadow:0 4px 24px rgba(0,0,0,0.10);overflow:hidden}
.hdr{padding:30px 20px 22px;background:#1A73E8;color:#fff}
.hdr h2{font-size:18px;font-weight:600}
.hdr p{font-size:12px;opacity:.85;margin-top:2px}
.body{padding:20px}
.card{background:#fff;border:1px solid #E8EAED;border-radius:14px;padding:20px;margin-bottom:12px}
.sec{font-size:11px;font-weight:700;color:#5F6368;margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px}
.field{margin-bottom:12px}
.field label{display:block;font-size:11px;color:#5F6368;margin-bottom:4px}
.field input{width:100%;padding:9px 12px;border:1px solid #DADCE0;border-radius:8px;font-size:13px;outline:none}
.field input:focus{border-color:#1A73E8}
.btn{width:100%;padding:11px;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;background:#34A853;color:#fff}
.alert-err{background:#FCE8E6;color:#A50E0E;padding:10px 12px;border-radius:8px;font-size:12px;margin-bottom:12px}
.chip{padding:4px 12px;border-radius:99px;font-size:11px;font-weight:600;cursor:pointer;background:#E8F0FE;color:#1558B0;border:none;margin:3px}
</style>
</head>
<body>
<div class="phone">
  <div class="hdr">
    <div style="font-size:28px;margin-bottom:6px">🚀</div>
    <h2>ALI BALI EXPRESS</h2>
    <p>Sistem Absensi Karyawan Berbasis GPS</p>
  </div>
  <div class="body">
    @if(session('error'))
    <div class="alert-err">{{ session('error') }}</div>
    @endif
    <div class="card">
      <div class="sec">Masuk ke akun Anda</div>
      <form method="POST" action="/login">
        @csrf
        <div class="field">
          <label>ID Karyawan</label>
          <input type="text" name="employee_id" id="emp_id" placeholder="Contoh: EMP001" required>
        </div>
        <div class="field" style="margin-bottom:16px">
          <label>Password</label>
          <input type="password" name="password" id="pwd" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Masuk →</button>
      </form>
    </div>
    <div class="card">
      <div style="font-size:11px;color:#5F6368;font-weight:600;margin-bottom:8px">Akun demo:</div>
      <div style="font-family:monospace;font-size:11px;color:#5F6368;line-height:2">
        EMP001 · Ellan → 1234<br>
        EMP002 · Aldy → 1243<br>
        EMP003 · Rossa → 1212<br>
        ADMIN → admin
      </div>
      <div style="margin-top:10px">
        <button class="chip" onclick="isi('EMP001','1234')">Ellan</button>
        <button class="chip" onclick="isi('EMP002','1243')">Aldy</button>
        <button class="chip" onclick="isi('EMP003','1212')">Rossa</button>
        <button class="chip" style="background:#F1F3F4;color:#5F6368" onclick="isi('ADMIN','admin')">Admin</button>
      </div>
    </div>
  </div>
</div>
<script>
function isi(id,pw){
  document.getElementById('emp_id').value=id;
  document.getElementById('pwd').value=pw;
}
</script>
</body>
</html>