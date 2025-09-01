<?php
session_start();
require "db.php";

/* ====== AUTH ====== */
$success = false;
$username_safe = "";
$message = "Invalid request.";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $success = true;
            $username_safe = htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8');
            $message = "Login Successful!<br>Welcome, <b>{$username_safe}</b> — Total Concentration!";
        } else {
            $message = "Invalid password";
        }
    } else {
        $message = "User not found";
    }
    $stmt->close();
}
$conn->close();

/* ====== THEME ====== */
$theme = 'flame'; // water | flame | thunder | beast | love
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo $success ? 'Login Success' : 'Login Failed'; ?></title>

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Yuji+Syuku&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">

<style>
  :root{
    --ok:#16a34a; --bad:#b91c1c;
  }
  *{box-sizing:border-box} html,body{height:100%;margin:0}
  body{font-family:"Noto Sans JP", sans-serif; color:#f8fafc; background:#0a0e13; overflow-x:hidden;}

  /* THEME COLORS */
  body.theme-water{ --pri:#22d3ee; --sec:#0ea5e9; }
  body.theme-flame{ --pri:#f59e0b; --sec:#ef4444; }
  body.theme-thunder{ --pri:#fde047; --sec:#f59e0b; }
  body.theme-beast{ --pri:#60a5fa; --sec:#94a3b8; }
  body.theme-love{ --pri:#fb7185; --sec:#f472b6; }

  /* ===== BACKGROUND LAYERS ===== */
  .bg-img{
    position: fixed; inset: 0; z-index: -5;
    background: url("dm3.jpg?v=1") center 40% / cover no-repeat;
    filter: saturate(1.06) contrast(1.05) brightness(0.95);
    opacity: 0.90;
    background-attachment: fixed;
  }
  .bg-mask{
    position: fixed; inset: 0; z-index: -4; pointer-events: none;
    background:
      radial-gradient(55% 35% at 50% 15%, rgba(0,0,0,.20), transparent 60%),
      radial-gradient(70% 50% at 50% 100%, rgba(0,0,0,.45), rgba(0,0,0,.6));
  }
  .layer{position:fixed; inset:0; z-index:-3;}
  .grad{
    background:
      radial-gradient(1200px 600px at 70% 10%, color-mix(in oklab, var(--pri) 20%, transparent), transparent 60%),
      radial-gradient(900px 500px at 10% 80%, color-mix(in oklab, var(--sec) 20%, transparent), transparent 60%),
      rgba(5,7,10,0.65); /* semi-transparent instead of solid black */
  }

  /* ===== HEADER ===== */
  .header{
    position:sticky; top:0; display:flex; justify-content:space-between; align-items:center;
    padding:14px 22px; background:linear-gradient(180deg, rgba(0,0,0,.55), rgba(0,0,0,0));
  }
  .brand{display:flex; gap:10px; align-items:center;}
  .mark{width:34px;height:34px;border-radius:50%;
        background:conic-gradient(from 0deg,var(--pri),var(--sec),var(--pri));
        border:2px solid rgba(255,255,255,.35);}
  .title{font-family:"Bebas Neue", sans-serif; font-size:26px; letter-spacing:1px;}
  .nav a{color:#e2e8f0; text-decoration:none; font-weight:700; padding:.45rem .9rem;
    border:1px solid rgba(255,255,255,.2); border-radius:10px; background:rgba(255,255,255,.05);}
  .nav a:hover{background:rgba(255,255,255,.12);}

  /* ===== MAIN ===== */
  .wrap{min-height:100vh; display:grid; place-items:center; text-align:center; padding:60px 20px;}

  /* Kanji/EN Title */
  .status-ink .jp{
    display:block; font-family:"Yuji Syuku", serif;
    font-size: clamp(38px, 6vw, 60px); color:#f1f5f9;
    text-shadow:0 0 12px color-mix(in oklab,var(--pri) 80%,transparent);
  }
  .status-ink .en{
    display:block; font-family:"Bebas Neue", sans-serif;
    font-size: clamp(22px, 3vw, 34px); letter-spacing:3px;
    margin-top:8px; color: <?php echo $success ? 'var(--ok)' : 'var(--bad)'; ?>;
    text-shadow:0 0 10px color-mix(in oklab,var(--pri) 70%,transparent);
  }
  .hanko{
    display:inline-block; margin-left:8px;
    font-family:"Yuji Syuku", serif; font-size:26px;
    color:#7f1d1d; border:3px solid #7f1d1d;
    border-radius:6px; padding:2px 8px; transform:rotate(-8deg);
    background:rgba(255,255,255,.1);
  }

  .msg-ink{margin:14px 0 20px; font-size:18px; line-height:1.8;}

  /* Buttons */
  .actions{display:flex; justify-content:center; gap:12px; flex-wrap:wrap;}
  .btn-ink{padding:.7rem 1.2rem; font-weight:700; border-radius:8px; text-decoration:none;
    border:2px solid var(--ok); background:rgba(22,163,74,.1); color:var(--ok);
    box-shadow:0 0 8px rgba(22,163,74,.6) inset;}
  .btn-ink.alt{border-color:var(--bad); background:rgba(185,28,28,.1); color:var(--bad);
    box-shadow:0 0 8px rgba(185,28,28,.6) inset;}
  .btn-ink:hover{background:rgba(255,255,255,.08);}
  .btn-ink:active{transform:translateY(1px);}

  /* Particles */
  .particle{position:fixed; left:0; top:-20px; width:8px; height:8px; background:var(--pri);
    border-radius:50%; opacity:.8; pointer-events:none;
    animation:fall linear var(--dur) infinite; z-index:-1;}
  @keyframes fall{to{transform:translate3d(100vw,110vh,0) rotate(540deg); opacity:.9;}}
</style>
</head>

<?php $themeClass = "theme-".$theme; ?>
<body class="<?php echo $themeClass; ?>">
  <!-- Background order: image -> mask -> gradient -->
  <div class="bg-img"></div>
  <div class="bg-mask"></div>
  <div class="layer grad"></div>

  <!-- Header -->
  <header class="header">
    <div class="brand"><div class="mark"></div><div class="title">DEMON SLAYER AUTH</div></div>
    <nav class="nav">
      <?php if ($success): ?><a href="dashboard.php">Enter Dashboard</a>
      <?php else: ?><a href="login.php">Back to Login</a><?php endif; ?>
    </nav>
  </header>

  <!-- Main -->
  <main class="wrap">
    <h1 class="status-ink">
      <span class="jp"><?php echo $success ? '入場許可' : '入場不可'; ?></span>
      <span class="en"><?php echo $success ? 'ACCESS GRANTED' : 'ACCESS DENIED'; ?></span>
      <span class="hanko">認</span>
    </h1>

    <div class="msg-ink"><?php echo $message; ?></div>

    <div class="actions">
      <?php if ($success): ?>
        <a class="btn-ink" href="dashboard.php">Enter Dashboard</a>
        <a class="btn-ink alt" href="logout.php">Log out</a>
      <?php else: ?>
        <a class="btn-ink" href="login.php">Try Again</a>
        <a class="btn-ink alt" href="register.php">Create Account</a>
      <?php endif; ?>
    </div>
  </main>

  <div style="text-align:center;padding:10px 16px;color:#94a3b8;font-size:12px;">
    Fan-made theme inspired by Kimetsu no Yaiba. Use your own character images if you add any.
  </div>

  <!-- particles -->
  <script>
    for (let i=0;i<22;i++){
      const p=document.createElement('div');
      p.className='particle';
      p.style.left=(-10 - Math.random()*40)+'vw';
      p.style.animationDelay=(Math.random()*6)+'s';
      p.style.setProperty('--dur',(6+Math.random()*8)+'s');
      document.body.appendChild(p);
    }
  </script>
</body>
</html>
