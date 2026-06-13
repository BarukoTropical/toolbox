<?php
// Konvertierte PHP-Datei
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TOOLBOX</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gif.js/0.2.0/gif.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#000000;
  --font:'Inter',sans-serif;
  --mono:'JetBrains Mono',monospace;
  --text:#ffffff;
  --muted:rgba(255,255,255,0.45);
  --muted2:rgba(255,255,255,0.18);
  --border:rgba(255,255,255,0.10);
  --border-bright:rgba(255,255,255,0.18);

  /* Liquid glass layers */
  --glass-bg:rgba(255,255,255,0.06);
  --glass-bg-hover:rgba(255,255,255,0.09);
  --glass-blur:blur(28px) saturate(180%);
  --glass-shine:linear-gradient(135deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.04) 40%, transparent 60%);
  --glass-shine-top:linear-gradient(180deg, rgba(255,255,255,0.14) 0%, transparent 50%);

  --green:#30d158;
  --blue:#0a84ff;
  --purple:#bf5af2;
  --yellow:#ffd60a;
  --red:#ff453a;
  --cyan:#32ade6;
}

html{scroll-behavior:smooth}
body{
  background:var(--bg);
  color:var(--text);
  font-family:var(--font);
  min-height:100vh;
  overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
}

/* ── BACKGROUND SCENE ───────────────────────────────────────────── */
.bg-scene{
  position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none;
}
.bg-scene::before{
  content:'';position:absolute;
  width:900px;height:900px;
  top:-200px;left:50%;transform:translateX(-50%);
  background:radial-gradient(ellipse, rgba(120,80,255,0.22) 0%, rgba(60,40,180,0.10) 40%, transparent 70%);
  animation:bgpulse 8s ease-in-out infinite alternate;
}
.bg-scene::after{
  content:'';position:absolute;
  width:600px;height:600px;
  bottom:-100px;right:-100px;
  background:radial-gradient(ellipse, rgba(0,120,255,0.14) 0%, transparent 70%);
  animation:bgpulse 11s ease-in-out infinite alternate-reverse;
}
.bg-grain{
  position:absolute;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  opacity:0.5;
}
@keyframes bgpulse{0%{transform:translateX(-50%) scale(1)}100%{transform:translateX(-50%) scale(1.12)}}

/* ── LIQUID GLASS MIXIN (applied via classes) ───────────────────── */
.glass{
  position:relative;
  background:var(--glass-bg);
  backdrop-filter:var(--glass-blur);
  -webkit-backdrop-filter:var(--glass-blur);
  border:1px solid var(--border);
  border-radius:20px;
  overflow:hidden;
}
/* Top specular highlight — the key Apple detail */
.glass::before{
  content:'';
  position:absolute;top:0;left:0;right:0;
  height:50%;
  background:var(--glass-shine-top);
  border-radius:inherit;
  pointer-events:none;z-index:1;
}
/* Diagonal gloss streak */
.glass::after{
  content:'';
  position:absolute;
  top:-60%;left:-30%;
  width:70%;height:180%;
  background:linear-gradient(105deg, rgba(255,255,255,0.09) 0%, rgba(255,255,255,0.0) 50%);
  transform:rotate(0deg);
  pointer-events:none;z-index:1;
}
.glass:hover{
  background:var(--glass-bg-hover);
  border-color:var(--border-bright);
  transition:background 0.2s, border-color 0.2s;
}
.glass > *{position:relative;z-index:2}

/* ── NAV ────────────────────────────────────────────────────────── */
nav{
  position:fixed;top:16px;left:50%;transform:translateX(-50%);
  z-index:200;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 20px;height:52px;
  width:min(900px, calc(100vw - 40px));
  background:rgba(20,20,30,0.55);
  backdrop-filter:blur(32px) saturate(200%);
  -webkit-backdrop-filter:blur(32px) saturate(200%);
  border:1px solid rgba(255,255,255,0.12);
  border-radius:16px;
  box-shadow:
    0 1px 0 rgba(255,255,255,0.12) inset,
    0 -1px 0 rgba(0,0,0,0.4) inset,
    0 16px 48px rgba(0,0,0,0.5);
}
/* Top shine on nav */
nav::before{
  content:'';position:absolute;top:0;left:0;right:0;height:50%;
  background:linear-gradient(180deg,rgba(255,255,255,0.10) 0%,transparent 100%);
  border-radius:16px 16px 0 0;pointer-events:none;
}
.nav-logo{
  display:flex;align-items:center;gap:9px;
  font-weight:800;font-size:15px;letter-spacing:-0.3px;
  text-decoration:none;color:#fff;
}
.nav-logo-icon{
  width:28px;height:28px;
  background:linear-gradient(145deg,rgba(255,255,255,0.95),rgba(200,200,220,0.7));
  border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  font-size:14px;
  box-shadow:0 2px 8px rgba(0,0,0,0.4), 0 1px 0 rgba(255,255,255,0.5) inset;
}
.nav-links{display:flex;gap:24px}
.nav-links a{
  color:rgba(255,255,255,0.5);font-size:13px;font-weight:500;
  text-decoration:none;transition:color 0.15s;letter-spacing:0.3px;
}
.nav-links a:hover{color:#fff}
.nav-cta{
  background:linear-gradient(145deg,rgba(255,255,255,0.92),rgba(220,220,230,0.75));
  color:#000;
  padding:8px 18px;border-radius:10px;font-size:13px;font-weight:700;
  text-decoration:none;letter-spacing:0.2px;transition:opacity 0.15s;
  box-shadow:0 2px 10px rgba(0,0,0,0.35), 0 1px 0 rgba(255,255,255,0.6) inset;
}
.nav-cta:hover{opacity:0.88}

/* ── HERO ───────────────────────────────────────────────────────── */
.hero{
  min-height:100vh;display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  text-align:center;padding:110px 24px 80px;
  position:relative;
}
.hero-badge{
  display:inline-flex;align-items:center;gap:8px;
  padding:8px 18px;
  background:rgba(255,255,255,0.07);
  backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.14);
  border-radius:99px;
  font-size:12px;font-weight:600;color:rgba(255,255,255,0.65);
  letter-spacing:0.8px;
  margin-bottom:36px;
  box-shadow:0 1px 0 rgba(255,255,255,0.12) inset, 0 4px 16px rgba(0,0,0,0.3);
  position:relative;overflow:hidden;
}
.hero-badge::before{
  content:'';position:absolute;top:0;left:0;right:0;height:50%;
  background:linear-gradient(180deg,rgba(255,255,255,0.10) 0%,transparent 100%);
}
.hero-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--green);box-shadow:0 0 6px var(--green);animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.4}}

.hero-title{
  font-size:clamp(64px,11vw,148px);
  font-weight:900;letter-spacing:-5px;line-height:0.88;
  margin-bottom:28px;
  background:linear-gradient(180deg,
    rgba(255,255,255,1) 0%,
    rgba(255,255,255,0.85) 50%,
    rgba(200,190,255,0.6) 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.hero-title .dim{
  background:linear-gradient(180deg,rgba(255,255,255,0.35) 0%,rgba(255,255,255,0.12) 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.hero-sub{
  font-size:clamp(15px,2vw,19px);
  color:rgba(255,255,255,0.45);
  max-width:440px;line-height:1.65;margin-bottom:48px;font-weight:400;
}
.hero-btns{display:flex;gap:12px;flex-wrap:wrap;justify-content:center;margin-bottom:80px}

/* Glossy primary button */
.btn-hero{
  display:inline-flex;align-items:center;gap:8px;
  padding:14px 30px;border-radius:14px;
  font-family:var(--font);font-size:15px;font-weight:700;
  cursor:pointer;text-decoration:none;
  background:linear-gradient(145deg,rgba(255,255,255,0.95),rgba(210,205,235,0.80));
  color:#000;border:none;
  box-shadow:
    0 1px 0 rgba(255,255,255,0.7) inset,
    0 -1px 0 rgba(0,0,0,0.15) inset,
    0 8px 32px rgba(0,0,0,0.4),
    0 2px 8px rgba(180,160,255,0.2);
  transition:transform 0.12s, box-shadow 0.12s;
  position:relative;overflow:hidden;
}
.btn-hero::before{
  content:'';position:absolute;top:0;left:0;right:0;height:50%;
  background:linear-gradient(180deg,rgba(255,255,255,0.5) 0%,transparent 100%);
  border-radius:14px 14px 0 0;
}
.btn-hero:hover{transform:translateY(-1px);box-shadow:0 1px 0 rgba(255,255,255,0.7) inset,0 -1px 0 rgba(0,0,0,0.15) inset,0 12px 40px rgba(0,0,0,0.5),0 3px 10px rgba(180,160,255,0.3)}
.btn-hero:active{transform:translateY(0)}

.btn-ghost-hero{
  display:inline-flex;align-items:center;gap:8px;
  padding:14px 30px;border-radius:14px;
  font-family:var(--font);font-size:15px;font-weight:600;
  cursor:pointer;text-decoration:none;
  background:rgba(255,255,255,0.06);
  color:rgba(255,255,255,0.7);
  border:1px solid rgba(255,255,255,0.12);
  backdrop-filter:blur(20px);
  box-shadow:0 1px 0 rgba(255,255,255,0.10) inset, 0 8px 24px rgba(0,0,0,0.3);
  transition:all 0.15s;
  position:relative;overflow:hidden;
}
.btn-ghost-hero::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.08) 0%,transparent 100%)}
.btn-ghost-hero:hover{background:rgba(255,255,255,0.10);color:#fff}

/* Hero stats row */
.hero-stats{
  display:flex;
  background:rgba(255,255,255,0.055);
  backdrop-filter:blur(28px);
  border:1px solid rgba(255,255,255,0.10);
  border-radius:18px;
  overflow:hidden;
  box-shadow:0 1px 0 rgba(255,255,255,0.12) inset,0 -1px 0 rgba(0,0,0,0.3) inset,0 20px 60px rgba(0,0,0,0.45);
  position:relative;
}
.hero-stats::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.10) 0%,transparent 100%);pointer-events:none}
.hero-stat{padding:22px 48px;text-align:center;border-right:1px solid rgba(255,255,255,0.08)}
.hero-stat:last-child{border-right:none}
.hero-stat-val{font-size:30px;font-weight:800;letter-spacing:-1px;background:linear-gradient(180deg,#fff 0%,rgba(255,255,255,0.7) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-stat-lbl{font-size:11px;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:1.5px;margin-top:4px;font-weight:600}

/* ── SECTIONS ───────────────────────────────────────────────────── */
.section{padding:100px 40px;max-width:1060px;margin:0 auto}
.eyebrow{font-size:11px;font-weight:700;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:3px;font-family:var(--mono);margin-bottom:14px}
.section-title{
  font-size:clamp(38px,5vw,62px);font-weight:900;letter-spacing:-2px;line-height:0.95;margin-bottom:56px;
  background:linear-gradient(180deg,#fff 0%,rgba(255,255,255,0.6) 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* ── TOOL GRID ──────────────────────────────────────────────────── */
.tool-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:12px}
.tool-card{
  padding:26px 24px;border-radius:18px;cursor:pointer;
  background:rgba(255,255,255,0.055);
  backdrop-filter:blur(24px);
  border:1px solid rgba(255,255,255,0.09);
  transition:all 0.2s;
  position:relative;overflow:hidden;
}
/* card gloss */
.tool-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:55%;
  background:linear-gradient(180deg,rgba(255,255,255,0.10) 0%,transparent 100%);
  pointer-events:none;border-radius:18px 18px 0 0;
}
.tool-card::after{
  content:'';position:absolute;top:-60%;left:-30%;width:65%;height:180%;
  background:linear-gradient(105deg,rgba(255,255,255,0.07) 0%,transparent 50%);
  pointer-events:none;
}
.tool-card:hover{
  background:rgba(255,255,255,0.09);
  border-color:rgba(255,255,255,0.18);
  transform:translateY(-2px);
  box-shadow:0 16px 48px rgba(0,0,0,0.5),0 1px 0 rgba(255,255,255,0.15) inset;
}
.tool-card.active{
  background:rgba(255,255,255,0.10);
  border-color:rgba(255,255,255,0.22);
  box-shadow:0 1px 0 rgba(255,255,255,0.18) inset,0 8px 32px rgba(0,0,0,0.4);
}
.tool-card > *{position:relative;z-index:2}
.tc-icon{font-size:26px;margin-bottom:14px;display:block}
.tc-name{font-size:16px;font-weight:700;letter-spacing:-0.3px;margin-bottom:6px}
.tc-desc{font-size:12px;color:rgba(255,255,255,0.4);line-height:1.5}
.tc-badge{
  position:absolute;top:16px;right:16px;z-index:3;
  font-size:10px;font-weight:700;font-family:var(--mono);
  background:linear-gradient(135deg,rgba(255,255,255,0.95),rgba(220,215,240,0.85));
  color:#000;padding:3px 8px;border-radius:5px;letter-spacing:0.3px;
  box-shadow:0 1px 0 rgba(255,255,255,0.5) inset,0 2px 6px rgba(0,0,0,0.3);
}

/* ── APP WRAPPER ────────────────────────────────────────────────── */
.app-section{padding:0 40px 100px;max-width:1060px;margin:0 auto}
.app-wrap{
  background:rgba(255,255,255,0.05);
  backdrop-filter:blur(32px) saturate(160%);
  border:1px solid rgba(255,255,255,0.10);
  border-radius:22px;overflow:hidden;
  box-shadow:0 1px 0 rgba(255,255,255,0.12) inset,0 -1px 0 rgba(0,0,0,0.4) inset,0 32px 80px rgba(0,0,0,0.5);
  position:relative;
}
.app-wrap::before{
  content:'';position:absolute;top:0;left:0;right:0;height:45%;
  background:linear-gradient(180deg,rgba(255,255,255,0.09) 0%,transparent 100%);
  pointer-events:none;z-index:0;
}
.app-wrap::after{
  content:'';position:absolute;top:-50%;left:-25%;width:60%;height:180%;
  background:linear-gradient(110deg,rgba(255,255,255,0.05) 0%,transparent 55%);
  pointer-events:none;z-index:0;
}
.app-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 26px;border-bottom:1px solid rgba(255,255,255,0.07);
  position:relative;z-index:2;
}
.app-head-left{display:flex;align-items:center;gap:12px}
.app-head-icon{font-size:20px}
.app-head-name{font-size:15px;font-weight:700;letter-spacing:-0.2px}
.app-head-desc{font-size:12px;color:rgba(255,255,255,0.35)}
.app-body{padding:26px;display:none;position:relative;z-index:2}
.app-body.active{display:block;animation:fadein 0.2s ease}
@keyframes fadein{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}

/* ── FORM ───────────────────────────────────────────────────────── */
.field{margin-bottom:16px}
.field label{display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:7px;font-family:var(--mono)}
.field input[type=text],
.field input[type=number],
.field textarea,
.field select{
  width:100%;
  background:rgba(0,0,0,0.35);
  border:1px solid rgba(255,255,255,0.09);
  border-radius:11px;
  padding:11px 15px;
  color:#fff;font-family:var(--font);font-size:14px;
  transition:border-color 0.15s,background 0.15s;
  resize:vertical;
  box-shadow:0 1px 0 rgba(255,255,255,0.05) inset,0 -1px 0 rgba(0,0,0,0.3) inset;
}
.field input:focus,.field textarea:focus,.field select:focus{
  outline:none;
  border-color:rgba(255,255,255,0.25);
  background:rgba(0,0,0,0.45);
}
.field textarea{font-family:var(--mono);font-size:13px;min-height:100px}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}

/* ── BUTTONS ────────────────────────────────────────────────────── */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:7px;
  padding:11px 22px;border-radius:12px;font-family:var(--font);
  font-size:13px;font-weight:700;cursor:pointer;transition:all 0.14s;
  border:none;letter-spacing:0.2px;position:relative;overflow:hidden;
}
.btn::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.18) 0%,transparent 100%);pointer-events:none}
.btn > *{position:relative;z-index:1}
.btn-w{
  background:linear-gradient(145deg,rgba(255,255,255,0.94),rgba(215,210,235,0.82));
  color:#000;
  box-shadow:0 1px 0 rgba(255,255,255,0.7) inset,0 -1px 0 rgba(0,0,0,0.15) inset,0 6px 20px rgba(0,0,0,0.35);
}
.btn-w:hover{opacity:0.88;transform:translateY(-1px)}
.btn-w:disabled{opacity:0.3;cursor:not-allowed;transform:none}
.btn-g{
  background:rgba(255,255,255,0.07);
  border:1px solid rgba(255,255,255,0.11);
  color:rgba(255,255,255,0.65);
  box-shadow:0 1px 0 rgba(255,255,255,0.08) inset;
}
.btn-g:hover{background:rgba(255,255,255,0.11);color:#fff;border-color:rgba(255,255,255,0.18)}
.btn-full{width:100%}
.btn-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}

/* ── DROPZONE ───────────────────────────────────────────────────── */
.dz{
  border:1px solid rgba(255,255,255,0.09);border-radius:14px;
  padding:44px 24px;text-align:center;cursor:pointer;
  background:rgba(0,0,0,0.25);
  transition:all 0.18s;position:relative;margin-bottom:20px;
  box-shadow:0 1px 0 rgba(255,255,255,0.07) inset;
}
.dz input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.dz:hover,.dz.over{border-color:rgba(255,255,255,0.22);background:rgba(255,255,255,0.05)}
.dz-icon{font-size:34px;display:block;margin-bottom:10px}
.dz-title{font-size:14px;font-weight:700;margin-bottom:5px}
.dz-sub{font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono)}

/* ── PROGRESS ───────────────────────────────────────────────────── */
.prog-wrap{display:none;margin-top:14px}
.prog-bg{
  background:rgba(255,255,255,0.06);border-radius:99px;height:4px;overflow:hidden;margin-bottom:8px;
  box-shadow:0 1px 0 rgba(0,0,0,0.4) inset;
}
.prog-fill{
  height:100%;width:0%;transition:width 0.1s;border-radius:99px;
  background:linear-gradient(90deg,rgba(255,255,255,0.7),rgba(255,255,255,1));
  box-shadow:0 0 8px rgba(255,255,255,0.5);
}
.prog-lbl{font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono)}

/* ── RESULT BOX ─────────────────────────────────────────────────── */
.res-box{
  background:rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.09);
  border-radius:14px;padding:18px;margin-top:14px;display:none;
  box-shadow:0 1px 0 rgba(255,255,255,0.07) inset;
}
.output-box{
  background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.08);
  border-radius:10px;padding:14px;margin-top:12px;
  font-family:var(--mono);font-size:12px;
  white-space:pre-wrap;word-break:break-all;
  min-height:56px;max-height:300px;overflow-y:auto;
  color:rgba(255,255,255,0.65);line-height:1.7;
}
.output-img{display:block;width:100%;border-radius:10px;margin-top:14px;border:1px solid rgba(255,255,255,0.09)}

/* ── PILLS ──────────────────────────────────────────────────────── */
.pills{display:flex;gap:7px;flex-wrap:wrap;margin-bottom:12px}
.pill{
  font-size:11px;font-family:var(--mono);font-weight:600;
  padding:4px 10px;border-radius:6px;
  background:rgba(255,255,255,0.07);
  border:1px solid rgba(255,255,255,0.10);
  color:rgba(255,255,255,0.6);
}
.pill-gr{background:rgba(48,209,88,0.10);border-color:rgba(48,209,88,0.25);color:var(--green)}
.pill-bl{background:rgba(10,132,255,0.10);border-color:rgba(10,132,255,0.25);color:var(--blue)}
.pill-yl{background:rgba(255,214,10,0.10);border-color:rgba(255,214,10,0.25);color:var(--yellow)}

/* ── STATS ──────────────────────────────────────────────────────── */
.stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;margin-bottom:18px}
.stat-box{
  background:rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.08);
  border-radius:12px;padding:14px;text-align:center;
  position:relative;overflow:hidden;
}
.stat-box::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.06) 0%,transparent 100%)}
.stat-val{font-size:26px;font-weight:800;letter-spacing:-1px;background:linear-gradient(180deg,#fff,rgba(255,255,255,0.65));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;position:relative}
.stat-lbl{font-size:10px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;margin-top:3px;font-family:var(--mono);position:relative}

/* ── COLOR ──────────────────────────────────────────────────────── */
.color-prev{
  width:100%;height:76px;border-radius:12px;margin-bottom:14px;
  border:1px solid rgba(255,255,255,0.10);transition:background 0.2s;
  position:relative;overflow:hidden;
}
.color-prev::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.25) 0%,transparent 100%)}
.swatch-row{display:flex;gap:8px;flex-wrap:wrap;margin-top:10px}
.swatch{
  width:30px;height:30px;border-radius:8px;cursor:pointer;
  transition:transform 0.12s,box-shadow 0.12s;
  border:1px solid rgba(255,255,255,0.15);
  position:relative;overflow:hidden;
}
.swatch::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.3) 0%,transparent 100%)}
.swatch:hover{transform:scale(1.18);box-shadow:0 4px 12px rgba(0,0,0,0.5)}

/* ── PASSWORD ───────────────────────────────────────────────────── */
.pw-opts{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.pw-opt{
  display:flex;align-items:center;gap:9px;
  background:rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.08);
  border-radius:10px;padding:10px 13px;cursor:pointer;
  font-size:13px;color:rgba(255,255,255,0.5);transition:all 0.15s;
}
.pw-opt:hover{border-color:rgba(255,255,255,0.18);color:#fff}
.pw-opt input{accent-color:#fff}
.pw-entry{
  display:flex;align-items:center;justify-content:space-between;gap:12px;
  background:rgba(0,0,0,0.25);border:1px solid rgba(255,255,255,0.08);
  border-radius:10px;padding:12px 16px;margin-bottom:8px;
  font-family:var(--mono);font-size:13px;
  position:relative;overflow:hidden;
}
.pw-entry::before{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.04) 0%,transparent 100%)}
.pw-copy-btn{
  background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);
  color:rgba(255,255,255,0.5);border-radius:7px;padding:5px 12px;
  font-size:11px;font-weight:700;cursor:pointer;transition:all 0.15s;
  text-transform:uppercase;letter-spacing:0.4px;font-family:var(--font);
  white-space:nowrap;position:relative;z-index:1;
}
.pw-copy-btn:hover{background:rgba(255,255,255,0.12);color:#fff}

/* ── VIDEO PREVIEW ──────────────────────────────────────────────── */
#gif-prev{display:none;margin-top:12px;border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,0.09)}
#gif-vid{width:100%;max-height:210px;object-fit:contain;display:block;background:#000}

/* ── IMG COMPARE ────────────────────────────────────────────────── */
.img-cmp{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:14px}
.img-cmp-lbl{font-size:10px;color:rgba(255,255,255,0.35);font-family:var(--mono);font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:7px}
.img-cmp img{width:100%;border-radius:9px;border:1px solid rgba(255,255,255,0.09);max-height:180px;object-fit:contain;background:#000}

/* ── QR ─────────────────────────────────────────────────────────── */
#qr-out{display:none;text-align:center;margin-top:18px}
#qr-out canvas{border-radius:10px;box-shadow:0 8px 32px rgba(0,0,0,0.5)}

/* ── TOAST ──────────────────────────────────────────────────────── */
#toast{
  position:fixed;bottom:24px;right:24px;z-index:999;
  background:rgba(30,30,40,0.80);
  backdrop-filter:blur(24px);
  border:1px solid rgba(255,255,255,0.12);
  border-radius:12px;padding:12px 18px;
  font-size:13px;font-weight:600;font-family:var(--mono);
  transform:translateY(70px);opacity:0;transition:all 0.22s;pointer-events:none;
  box-shadow:0 1px 0 rgba(255,255,255,0.12) inset,0 16px 40px rgba(0,0,0,0.5);
}
#toast.show{transform:translateY(0);opacity:1}
#toast.ok{border-color:rgba(48,209,88,0.4);color:var(--green)}
#toast.err{border-color:rgba(255,69,58,0.4);color:var(--red)}

/* ── FOOTER ─────────────────────────────────────────────────────── */
footer{
  border-top:1px solid rgba(255,255,255,0.07);
  padding:32px 40px;
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;
  position:relative;z-index:1;
}
footer p{font-size:13px;color:rgba(255,255,255,0.3)}
footer span{color:#fff}

/* ── MOBILE ─────────────────────────────────────────────────────── */
@media(max-width:768px){
  nav{top:10px;padding:0 16px}
  .nav-links{display:none}
  .hero{padding:90px 20px 60px}
  .hero-stats{flex-direction:column}
  .hero-stat{border-right:none;border-bottom:1px solid rgba(255,255,255,0.07);padding:18px 32px}
  .hero-stat:last-child{border-bottom:none}
  .section,.app-section{padding-left:20px;padding-right:20px}
  .row2,.row3{grid-template-columns:1fr}
  footer{padding:24px 20px}
  .pw-opts{grid-template-columns:1fr}
  .img-cmp{grid-template-columns:1fr}
}
</style>
</head>
<body>

<div class="bg-scene"><div class="bg-grain"></div></div>

<!-- NAV -->
<nav>
  <a class="nav-logo" href="#">
    <div class="nav-logo-icon">⚡</div>
    TOOLBOX
  </a>
  <div class="nav-links">
    <a href="#tools">TOOLS</a>
    <a href="#app">NUTZEN</a>
  </div>
  <a class="nav-cta" href="#app">START NOW ⚡</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-badge">
    <span class="hero-badge-dot"></span>
    8 Tools · Lokal · Privat
  </div>
  <h1 class="hero-title">CONVERT<br><span class="dim">ANYTHING.</span></h1>
  <p class="hero-sub">Das schnellste Tool-Set im Browser.<br>Kein Upload. Kein Server. Kein Tracking.</p>
  <div class="hero-btns">
    <a class="btn-hero" href="#app"><span>START NOW ⚡</span></a>
    <a class="btn-ghost-hero" href="#tools"><span>TOOLS ERKUNDEN →</span></a>
  </div>
  <div class="hero-stats">
    <div class="hero-stat"><div class="hero-stat-val">8</div><div class="hero-stat-lbl">Tools</div></div>
    <div class="hero-stat"><div class="hero-stat-val">0KB</div><div class="hero-stat-lbl">Uploads</div></div>
    <div class="hero-stat"><div class="hero-stat-val">100%</div><div class="hero-stat-lbl">Privat</div></div>
  </div>
</section>

<!-- TOOLS -->
<section id="tools" class="section">
  <div class="eyebrow">// alle tools</div>
  <h2 class="section-title">WÄHLE DEIN<br>WERKZEUG.</h2>
  <div class="tool-grid">
    <div class="tool-card active" data-tool="gif"><span class="tc-badge">HOT</span><span class="tc-icon">🎬</span><div class="tc-name">MP4 → GIF</div><div class="tc-desc">Video in GIF konvertieren mit FPS & Trim-Kontrolle.</div></div>
    <div class="tool-card" data-tool="img"><span class="tc-icon">🖼️</span><div class="tc-name">Bild komprimieren</div><div class="tc-desc">JPEG & PNG ohne sichtbaren Qualitätsverlust verkleinern.</div></div>
    <div class="tool-card" data-tool="qr"><span class="tc-icon">⬛</span><div class="tc-name">QR Generator</div><div class="tc-desc">QR-Codes aus URLs. Farben anpassbar, PNG-Download.</div></div>
    <div class="tool-card" data-tool="b64"><span class="tc-icon">🔣</span><div class="tc-name">Base64 Coder</div><div class="tc-desc">Text sofort in Base64 kodieren und dekodieren.</div></div>
    <div class="tool-card" data-tool="json"><span class="tc-icon">{ }</span><div class="tc-name">JSON Formatter</div><div class="tc-desc">JSON formatieren, validieren und minimieren.</div></div>
    <div class="tool-card" data-tool="wc"><span class="tc-icon">📊</span><div class="tc-name">Text Analyse</div><div class="tc-desc">Zeichen, Wörter, Sätze, Lesezeit und Top-Wörter.</div></div>
    <div class="tool-card" data-tool="color"><span class="tc-icon">🎨</span><div class="tc-name">Farb Konverter</div><div class="tc-desc">HEX ↔ RGB ↔ HSL + fertiger CSS-Output.</div></div>
    <div class="tool-card" data-tool="pass"><span class="tc-icon">🔐</span><div class="tc-name">Passwort Gen</div><div class="tc-desc">Kryptografisch sichere Passwörter lokal generieren.</div></div>
  </div>
</section>

<!-- APP -->
<section id="app" class="app-section">
  <div class="app-wrap">
    <div class="app-head">
      <div class="app-head-left">
        <span class="app-head-icon" id="a-icon">🎬</span>
        <div>
          <div class="app-head-name" id="a-name">MP4 → GIF Converter</div>
          <div class="app-head-desc" id="a-desc">Keine Datei verlässt deinen Browser.</div>
        </div>
      </div>
    </div>

    <!-- GIF -->
    <div class="app-body active" id="tool-gif">
      <div class="dz" id="gif-dz"><input type="file" id="gif-in" accept="video/*"><span class="dz-icon">🎬</span><div class="dz-title">Video hier ablegen</div><div class="dz-sub">MP4 · WebM · MOV</div></div>
      <div id="gif-prev"><video id="gif-vid" controls muted playsinline></video></div>
      <div id="gif-fn" style="font-family:var(--mono);font-size:11px;color:var(--green);margin:6px 0;min-height:14px"></div>
      <div class="row3">
        <div class="field"><label>Breite (px)</label><input type="number" id="gif-w" value="480" min="64" max="1280"></div>
        <div class="field"><label>FPS</label><input type="number" id="gif-fps" value="12" min="1" max="30"></div>
        <div class="field"><label>Qualität (1–20)</label><input type="number" id="gif-q" value="8" min="1" max="20"></div>
      </div>
      <div class="row2">
        <div class="field"><label>Start (s)</label><input type="number" id="gif-s" value="0" min="0" step="0.1"></div>
        <div class="field"><label>Ende (0 = Ende)</label><input type="number" id="gif-e" value="0" min="0" step="0.1"></div>
      </div>
      <button class="btn btn-w btn-full" id="gif-btn" disabled>GIF ERSTELLEN ⚡</button>
      <div class="prog-wrap" id="gif-prog"><div class="prog-bg"><div class="prog-fill" id="gif-fill"></div></div><div class="prog-lbl" id="gif-lbl">Verarbeite…</div></div>
      <div class="res-box" id="gif-res"><div class="pills" id="gif-pills"></div><img id="gif-out" class="output-img"><div class="btn-row" style="margin-top:14px"><button class="btn btn-g" id="gif-rst">↩ RESET</button><button class="btn btn-w" id="gif-dl">⬇ DOWNLOAD</button></div></div>
    </div>

    <!-- IMG -->
    <div class="app-body" id="tool-img">
      <div class="dz" id="img-dz"><input type="file" id="img-in" accept="image/*"><span class="dz-icon">🖼️</span><div class="dz-title">Bild hier ablegen</div><div class="dz-sub">JPEG · PNG · WebP</div></div>
      <div class="field"><label>Qualität — <span id="img-qv">82</span>%</label><input type="range" id="img-q" min="10" max="100" value="82" style="width:100%;accent-color:#fff;margin-top:7px"></div>
      <div class="field"><label>Max. Breite (0 = original)</label><input type="number" id="img-mw" value="0" min="0"></div>
      <button class="btn btn-w btn-full" id="img-btn" disabled>KOMPRIMIEREN ⚡</button>
      <div class="res-box" id="img-res"><div class="pills" id="img-pills"></div><div class="img-cmp"><div><div class="img-cmp-lbl">Original</div><img id="img-orig"></div><div><div class="img-cmp-lbl">Komprimiert</div><img id="img-comp"></div></div><div class="btn-row" style="margin-top:12px"><button class="btn btn-w" id="img-dl">⬇ DOWNLOAD</button></div></div>
    </div>

    <!-- QR -->
    <div class="app-body" id="tool-qr">
      <div class="field"><label>URL oder Text</label><input type="text" id="qr-txt" placeholder="https://beispiel.de"></div>
      <div class="row2">
        <div class="field"><label>Größe (px)</label><input type="number" id="qr-sz" value="256" min="64" max="1024" step="32"></div>
        <div class="field"><label>Fehlerkorrektur</label><select id="qr-ec"><option value="L">L — 7%</option><option value="M" selected>M — 15%</option><option value="Q">Q — 25%</option><option value="H">H — 30%</option></select></div>
      </div>
      <div class="row2">
        <div class="field"><label>Farbe</label><input type="color" id="qr-fg" value="#ffffff" style="width:100%;height:42px;border-radius:10px;border:1px solid rgba(255,255,255,0.09);background:transparent;cursor:pointer;padding:2px"></div>
        <div class="field"><label>Hintergrund</label><input type="color" id="qr-bg" value="#000000" style="width:100%;height:42px;border-radius:10px;border:1px solid rgba(255,255,255,0.09);background:transparent;cursor:pointer;padding:2px"></div>
      </div>
      <button class="btn btn-w btn-full" id="qr-btn">QR ERSTELLEN ⚡</button>
      <div id="qr-out"><div id="qr-wrap"></div><div class="btn-row" style="justify-content:center;margin-top:12px"><button class="btn btn-w" id="qr-dl">⬇ PNG</button><button class="btn btn-g" id="qr-cp">📋 KOPIEREN</button></div></div>
    </div>

    <!-- BASE64 -->
    <div class="app-body" id="tool-b64">
      <div class="field"><label>Eingabe</label><textarea id="b64-in" placeholder="Text oder Base64 eingeben…" rows="5"></textarea></div>
      <div class="btn-row"><button class="btn btn-w" id="b64-enc">ENCODE →</button><button class="btn btn-g" id="b64-dec">← DECODE</button><button class="btn btn-g" id="b64-clr">LEEREN</button></div>
      <div class="res-box" id="b64-res"><div style="font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono);margin-bottom:7px" id="b64-lbl">Ergebnis</div><div class="output-box" id="b64-out"></div><div class="btn-row" style="margin-top:10px"><button class="btn btn-g" id="b64-cp">📋 KOPIEREN</button><button class="btn btn-g" id="b64-sw">⇄ ALS EINGABE</button></div></div>
    </div>

    <!-- JSON -->
    <div class="app-body" id="tool-json">
      <div class="field"><label>JSON</label><textarea id="json-in" placeholder='{"name":"Max","alter":25}' rows="7"></textarea></div>
      <div class="btn-row"><button class="btn btn-w" id="json-fmt">✨ FORMATIEREN</button><button class="btn btn-g" id="json-min">⬤ MINIMIEREN</button><button class="btn btn-g" id="json-clr">LEEREN</button></div>
      <div id="json-err" style="display:none;margin-top:10px;font-size:12px;color:var(--red);font-family:var(--mono)"></div>
      <div class="res-box" id="json-res"><div class="pills" id="json-pills"></div><div class="output-box" id="json-out"></div><div class="btn-row" style="margin-top:10px"><button class="btn btn-g" id="json-cp">📋 KOPIEREN</button></div></div>
    </div>

    <!-- WORD COUNT -->
    <div class="app-body" id="tool-wc">
      <div class="field"><label>Text</label><textarea id="wc-in" placeholder="Füge deinen Text hier ein…" rows="8" style="min-height:160px"></textarea></div>
      <div class="stat-grid">
        <div class="stat-box"><div class="stat-val" id="wc-c">0</div><div class="stat-lbl">Zeichen</div></div>
        <div class="stat-box"><div class="stat-val" id="wc-w">0</div><div class="stat-lbl">Wörter</div></div>
        <div class="stat-box"><div class="stat-val" id="wc-s">0</div><div class="stat-lbl">Sätze</div></div>
        <div class="stat-box"><div class="stat-val" id="wc-p">0</div><div class="stat-lbl">Absätze</div></div>
        <div class="stat-box"><div class="stat-val" id="wc-r">—</div><div class="stat-lbl">Lesezeit</div></div>
        <div class="stat-box"><div class="stat-val" id="wc-u">0</div><div class="stat-lbl">Einzigartig</div></div>
      </div>
      <div id="wc-top" style="display:none"><div style="font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono);font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:9px">TOP WÖRTER</div><div id="wc-top-w" style="display:flex;flex-wrap:wrap;gap:6px"></div></div>
    </div>

    <!-- COLOR -->
    <div class="app-body" id="tool-color">
      <div class="color-prev" id="cprev"></div>
      <div class="row3">
        <div class="field"><label>HEX</label><input type="text" id="c-hex" placeholder="#bf5af2" maxlength="7"></div>
        <div class="field"><label>RGB</label><input type="text" id="c-rgb" placeholder="191, 90, 242"></div>
        <div class="field"><label>HSL</label><input type="text" id="c-hsl" placeholder="278, 86%, 65%"></div>
      </div>
      <div style="font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono);font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:9px">SCHNELLPALETTE</div>
      <div class="swatch-row" id="cswatches"></div>
      <div style="margin-top:18px;font-size:11px;color:rgba(255,255,255,0.35);font-family:var(--mono);font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:9px">CSS OUTPUT</div>
      <div class="output-box" id="ccss"></div>
      <div class="btn-row" style="margin-top:10px"><button class="btn btn-g" id="ccp">📋 CSS KOPIEREN</button></div>
    </div>

    <!-- PASSWORD -->
    <div class="app-body" id="tool-pass">
      <div class="field"><label>Länge — <span id="pl-val">20</span> Zeichen</label><input type="range" id="p-len" min="6" max="128" value="20" style="width:100%;accent-color:#fff;margin-top:7px"></div>
      <div class="pw-opts">
        <label class="pw-opt"><input type="checkbox" id="p-up" checked> Großbuchstaben</label>
        <label class="pw-opt"><input type="checkbox" id="p-lo" checked> Kleinbuchstaben</label>
        <label class="pw-opt"><input type="checkbox" id="p-nm" checked> Zahlen (0-9)</label>
        <label class="pw-opt"><input type="checkbox" id="p-sy"> Sonderzeichen</label>
        <label class="pw-opt"><input type="checkbox" id="p-na"> Ähnliche vermeiden</label>
      </div>
      <div class="field"><label>Anzahl</label><input type="number" id="p-cnt" value="5" min="1" max="50"></div>
      <button class="btn btn-w btn-full" id="p-gen">🔐 GENERIEREN</button>
      <div class="res-box" id="p-res"><div id="p-list"></div></div>
    </div>

  </div><!-- app-wrap -->
</section>

<footer>
  <p>⚡ <span>TOOLBOX</span> — Alles lokal. Kein Server. Kein Tracking.</p>
  <p style="font-size:12px;font-family:var(--mono);color:rgba(255,255,255,0.2)">100% im Browser</p>
</footer>

<div id="toast"></div>

<script>
const $=id=>document.getElementById(id);
let toastT;
function toast(m,t='ok'){const el=$('toast');el.textContent=m;el.className='show '+t;clearTimeout(toastT);toastT=setTimeout(()=>el.className='',2400)}
function copy(t){navigator.clipboard.writeText(t).then(()=>toast('Kopiert!'))}
function fmtB(b){return b<1024?b+'B':b<1048576?(b/1024).toFixed(1)+'KB':(b/1048576).toFixed(2)+'MB'}
function setupDZ(dId,iId,cb){
  const dz=$(dId),inp=$(iId);
  dz.addEventListener('dragover',e=>{e.preventDefault();dz.classList.add('over')});
  dz.addEventListener('dragleave',()=>dz.classList.remove('over'));
  dz.addEventListener('drop',e=>{e.preventDefault();dz.classList.remove('over');if(e.dataTransfer.files[0])cb(e.dataTransfer.files[0])});
  inp.addEventListener('change',e=>{if(e.target.files[0])cb(e.target.files[0])});
}

// Tool switch
const meta={gif:{icon:'🎬',name:'MP4 → GIF Converter',desc:'Keine Datei verlässt deinen Browser.'},img:{icon:'🖼️',name:'Bild komprimieren',desc:'JPEG, PNG, WebP verkleinern.'},qr:{icon:'⬛',name:'QR Code Generator',desc:'URL oder Text als QR-Code.'},b64:{icon:'🔣',name:'Base64 En-/Decoder',desc:'Schnell und lokal.'},json:{icon:'{}',name:'JSON Formatter',desc:'Formatieren, validieren, minimieren.'},wc:{icon:'📊',name:'Text Analyse',desc:'Wörter, Sätze, Lesezeit.'},color:{icon:'🎨',name:'Farb Konverter',desc:'HEX ↔ RGB ↔ HSL.'},pass:{icon:'🔐',name:'Passwort Generator',desc:'Kryptografisch sicher.'}};
document.querySelectorAll('.tool-card').forEach(c=>{
  c.addEventListener('click',()=>{
    const t=c.dataset.tool;
    document.querySelectorAll('.tool-card').forEach(x=>x.classList.remove('active'));
    document.querySelectorAll('.app-body').forEach(x=>x.classList.remove('active'));
    c.classList.add('active');$('tool-'+t).classList.add('active');
    const m=meta[t];$('a-icon').textContent=m.icon;$('a-name').textContent=m.name;$('a-desc').textContent=m.desc;
    $('app').scrollIntoView({behavior:'smooth'});
  });
});

// ── GIF ──
let gifFile=null;
setupDZ('gif-dz','gif-in',f=>{
  if(!f.type.startsWith('video/')){toast('Kein Video!','err');return}
  gifFile=f;$('gif-fn').textContent=f.name;
  $('gif-vid').src=URL.createObjectURL(f);$('gif-prev').style.display='block';
  $('gif-btn').disabled=false;$('gif-res').style.display='none';
});
$('gif-btn').addEventListener('click',async()=>{
  if(!gifFile)return;
  const w=+$('gif-w').value||480,fps=+$('gif-fps').value||12,q=+$('gif-q').value||8;
  const s=+$('gif-s').value||0,ev=+$('gif-e').value||0;
  $('gif-btn').disabled=true;$('gif-res').style.display='none';$('gif-prog').style.display='block';
  const vid=document.createElement('video');vid.src=URL.createObjectURL(gifFile);vid.muted=true;
  await new Promise((r,j)=>{vid.onloadedmetadata=r;vid.onerror=j});
  const dur=(ev>0?Math.min(ev,vid.duration):vid.duration)-s;
  const frames=Math.floor(dur*fps),delay=Math.round(1000/fps);
  const h=Math.round((vid.videoHeight/vid.videoWidth)*w);
  const cv=document.createElement('canvas');cv.width=w;cv.height=h;const ctx=cv.getContext('2d');
  const gif=new GIF({workers:2,quality:q,width:w,height:h,workerScript:'https://cdnjs.cloudflare.com/ajax/libs/gif.js/0.2.0/gif.worker.js'});
  gif.on('progress',p=>{$('gif-fill').style.width=Math.round(60+p*40)+'%';$('gif-lbl').textContent='Kodiere GIF…'});
  gif.on('finished',blob=>{
    const burl=URL.createObjectURL(blob);$('gif-out').src=burl;
    $('gif-dl').onclick=()=>{const a=document.createElement('a');a.href=burl;a.download=gifFile.name.replace(/\.[^.]+$/,'')+'.gif';a.click()};
    $('gif-pills').innerHTML=`<span class="pill">${w}×${h}</span><span class="pill pill-bl">${fps} fps</span><span class="pill pill-gr">${fmtB(blob.size)}</span>`;
    $('gif-prog').style.display='none';$('gif-res').style.display='block';$('gif-btn').disabled=false;toast('GIF fertig! ⚡');
  });
  for(let i=0;i<frames;i++){
    await new Promise(r=>{vid.currentTime=s+(i/fps);vid.onseeked=r});
    ctx.drawImage(vid,0,0,w,h);gif.addFrame(ctx,{copy:true,delay});
    $('gif-fill').style.width=Math.round((i/frames)*60)+'%';$('gif-lbl').textContent=`Frame ${i+1}/${frames}`;
  }
  $('gif-lbl').textContent='Rendering…';gif.render();
});
$('gif-rst').onclick=()=>{gifFile=null;$('gif-in').value='';$('gif-fn').textContent='';$('gif-prev').style.display='none';$('gif-vid').src='';$('gif-res').style.display='none';$('gif-btn').disabled=true};

// ── IMG ──
let imgFile=null;
$('img-q').oninput=()=>$('img-qv').textContent=$('img-q').value;
setupDZ('img-dz','img-in',f=>{
  if(!f.type.startsWith('image/')){toast('Kein Bild!','err');return}
  imgFile=f;$('img-btn').disabled=false;$('img-orig').src=URL.createObjectURL(f);$('img-res').style.display='none';
});
$('img-btn').onclick=()=>{
  if(!imgFile)return;
  const q=+$('img-q').value/100,mw=+$('img-mw').value||0;
  const r=new FileReader();r.onload=e=>{
    const img=new Image();img.onload=()=>{
      let w=img.width,h=img.height;if(mw&&w>mw){h=Math.round((mw/w)*h);w=mw}
      const cv=document.createElement('canvas');cv.width=w;cv.height=h;cv.getContext('2d').drawImage(img,0,0,w,h);
      cv.toBlob(blob=>{
        const burl=URL.createObjectURL(blob);$('img-comp').src=burl;
        const s=Math.round((1-blob.size/imgFile.size)*100);
        $('img-pills').innerHTML=`<span class="pill">${w}×${h}</span><span class="pill pill-bl">Original: ${fmtB(imgFile.size)}</span><span class="pill pill-gr">−${s}%</span><span class="pill pill-yl">${fmtB(blob.size)}</span>`;
        $('img-dl').onclick=()=>{const a=document.createElement('a');a.href=burl;a.download='compressed_'+imgFile.name;a.click()};
        $('img-res').style.display='block';toast(`−${s}% gespart! ⚡`);
      },imgFile.type==='image/png'?'image/png':'image/jpeg',q);
    };img.src=e.target.result;
  };r.readAsDataURL(imgFile);
};

// ── QR ──
$('qr-btn').onclick=()=>{
  const txt=$('qr-txt').value.trim();if(!txt){toast('Text fehlt','err');return}
  $('qr-wrap').innerHTML='';
  new QRCode($('qr-wrap'),{text:txt,width:+$('qr-sz').value||256,height:+$('qr-sz').value||256,colorDark:$('qr-fg').value,colorLight:$('qr-bg').value,correctLevel:QRCode.CorrectLevel[$('qr-ec').value]});
  $('qr-out').style.display='block';
  setTimeout(()=>{
    const cv=$('qr-wrap').querySelector('canvas');if(!cv)return;
    $('qr-dl').onclick=()=>{const a=document.createElement('a');a.href=cv.toDataURL('image/png');a.download='qrcode.png';a.click()};
    $('qr-cp').onclick=()=>cv.toBlob(b=>{try{navigator.clipboard.write([new ClipboardItem({'image/png':b})]).then(()=>toast('Kopiert!')).catch(()=>toast('Nicht möglich','err'))}catch{toast('Nicht möglich','err')}});
    toast('QR erstellt!');
  },200);
};

// ── BASE64 ──
function b64op(enc){
  const v=$('b64-in').value;if(!v){toast('Leer','err');return}
  try{const out=enc?btoa(unescape(encodeURIComponent(v))):decodeURIComponent(escape(atob(v)));$('b64-out').textContent=out;$('b64-lbl').textContent=enc?'Base64 encoded':'Decoded text';$('b64-res').style.display='block';$('b64-cp').onclick=()=>copy(out);$('b64-sw').onclick=()=>{$('b64-in').value=out;$('b64-res').style.display='none'}}catch{toast('Ungültige Base64!','err')}
}
$('b64-enc').onclick=()=>b64op(true);$('b64-dec').onclick=()=>b64op(false);$('b64-clr').onclick=()=>{$('b64-in').value='';$('b64-res').style.display='none'};

// ── JSON ──
function doJSON(min){
  const v=$('json-in').value.trim();$('json-err').style.display='none';if(!v){toast('Leer','err');return}
  try{const p=JSON.parse(v);const out=min?JSON.stringify(p):JSON.stringify(p,null,2);$('json-out').textContent=out;$('json-pills').innerHTML=`<span class="pill pill-gr">Gültig ✓</span><span class="pill">${Array.isArray(p)?'Array':'Object'}</span><span class="pill pill-bl">${out.length} Zeichen</span>`;$('json-res').style.display='block';$('json-cp').onclick=()=>copy(out);toast(min?'Minimiert!':'Formatiert!')}catch(e){$('json-err').textContent='⚠ '+e.message;$('json-err').style.display='block';$('json-res').style.display='none'}
}
$('json-fmt').onclick=()=>doJSON(false);$('json-min').onclick=()=>doJSON(true);$('json-clr').onclick=()=>{$('json-in').value='';$('json-res').style.display='none';$('json-err').style.display='none'};

// ── WORD COUNT ──
const stopDE=new Set(['und','der','die','das','ist','ein','eine','in','zu','den','von','mit','auf','für','nicht','als','an','bei','nach','über','sich','aber','oder','wenn','dann','auch','noch','wie','wird','sind','ich','wir','sie','ihr','ihm','des','dem','war','hat','haben','vom','zur','zum','durch','so','da','es','er','am','im','bis','aus']);
$('wc-in').addEventListener('input',()=>{
  const t=$('wc-in').value;
  const chars=t.length,words=t.trim()===''?0:t.trim().split(/\s+/).length;
  const sentences=t.split(/[.!?]+/).filter(s=>s.trim()).length;
  const paras=t.split(/\n\s*\n/).filter(p=>p.trim()).length||1;
  const rm=Math.ceil(words/200);const rt=rm<1?'<1m':rm+'min';
  const ws=t.toLowerCase().match(/\b\w{3,}\b/g)||[];
  const freq={};ws.forEach(w=>{freq[w]=(freq[w]||0)+1});
  const top=Object.entries(freq).filter(([w])=>!stopDE.has(w)).sort((a,b)=>b[1]-a[1]).slice(0,10);
  $('wc-c').textContent=chars.toLocaleString();$('wc-w').textContent=words.toLocaleString();
  $('wc-s').textContent=sentences.toLocaleString();$('wc-p').textContent=paras.toLocaleString();
  $('wc-r').textContent=rt;$('wc-u').textContent=new Set(ws).size.toLocaleString();
  const tw=$('wc-top');
  if(top.length){tw.style.display='block';$('wc-top-w').innerHTML=top.map(([w,c])=>`<span class="pill">${w} ×${c}</span>`).join('')}else{tw.style.display='none'}
});

// ── COLOR ──
const swCs=['#ffffff','#bf5af2','#0a84ff','#ff453a','#30d158','#ffd60a','#ff9f0a','#32ade6','#ff375f','#64d2ff'];
swCs.forEach(c=>{const s=document.createElement('div');s.className='swatch';s.style.background=c;s.onclick=()=>{$('c-hex').value=c;upHex()};$('cswatches').appendChild(s)});
function hexToRgb(h){return{r:parseInt(h.slice(1,3),16),g:parseInt(h.slice(3,5),16),b:parseInt(h.slice(5,7),16)}}
function rgbToHsl(r,g,b){r/=255;g/=255;b/=255;const max=Math.max(r,g,b),min=Math.min(r,g,b);let h,s,l=(max+min)/2;if(max===min){h=s=0}else{const d=max-min;s=l>0.5?d/(2-max-min):d/(max+min);switch(max){case r:h=(g-b)/d+(g<b?6:0);break;case g:h=(b-r)/d+2;break;case b:h=(r-g)/d+4;break}h/=6}return{h:Math.round(h*360),s:Math.round(s*100),l:Math.round(l*100)}}
function hslToRgb(h,s,l){s/=100;l/=100;const k=n=>(n+h/30)%12,a=s*Math.min(l,1-l),f=n=>l-a*Math.max(-1,Math.min(k(n)-3,Math.min(9-k(n),1)));return{r:Math.round(f(0)*255),g:Math.round(f(8)*255),b:Math.round(f(4)*255)}}
function c2h(c){return c.toString(16).padStart(2,'0')}
function rgbToHex(r,g,b){return'#'+c2h(r)+c2h(g)+c2h(b)}
function setColor(hex,rgb,hsl){
  $('c-hex').value=hex;$('c-rgb').value=`${rgb.r}, ${rgb.g}, ${rgb.b}`;$('c-hsl').value=`${hsl.h}, ${hsl.s}%, ${hsl.l}%`;
  $('cprev').style.background=hex;
  const css=`--color: ${hex};\n--color-rgb: ${rgb.r}, ${rgb.g}, ${rgb.b};\n--color-hsl: ${hsl.h}deg ${hsl.s}% ${hsl.l}%;\n\nbackground: var(--color);\ncolor: rgb(var(--color-rgb));`;
  $('ccss').textContent=css;$('ccp').onclick=()=>copy(css);
}
function upHex(){const h=$('c-hex').value;if(!/^#[0-9a-fA-F]{6}$/.test(h))return;const rgb=hexToRgb(h);setColor(h,rgb,rgbToHsl(rgb.r,rgb.g,rgb.b))}
function upRgb(){const p=$('c-rgb').value.split(',').map(s=>parseInt(s.trim()));if(p.length<3||p.some(isNaN))return;const[r,g,b]=p;setColor(rgbToHex(r,g,b),{r,g,b},rgbToHsl(r,g,b))}
function upHsl(){const raw=$('c-hsl').value.replace(/%/g,'');const p=raw.split(',').map(s=>parseFloat(s.trim()));if(p.length<3||p.some(isNaN))return;const[h,s,l]=p;const rgb=hslToRgb(h,s,l);setColor(rgbToHex(rgb.r,rgb.g,rgb.b),rgb,{h,s,l})}
$('c-hex').oninput=upHex;$('c-rgb').oninput=upRgb;$('c-hsl').oninput=upHsl;
setColor('#bf5af2',hexToRgb('#bf5af2'),rgbToHsl(...Object.values(hexToRgb('#bf5af2'))));

// ── PASSWORD ──
$('p-len').oninput=()=>$('pl-val').textContent=$('p-len').value;
$('p-gen').onclick=()=>{
  const len=+$('p-len').value,na=$('p-na').checked;let chars='';
  if($('p-up').checked)chars+=na?'ABCDEFGHJKLMNPQRSTUVWXYZ':'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  if($('p-lo').checked)chars+=na?'abcdefghjkmnpqrstuvwxyz':'abcdefghijklmnopqrstuvwxyz';
  if($('p-nm').checked)chars+=na?'23456789':'0123456789';
  if($('p-sy').checked)chars+='!@#$%^&*()-_=+[]{}|;:,.<>?';
  if(!chars){toast('Mindestens eine Option!','err');return}
  $('p-list').innerHTML='';
  for(let i=0;i<(+$('p-cnt').value||5);i++){
    let pw='';const arr=new Uint8Array(len);crypto.getRandomValues(arr);arr.forEach(b=>pw+=chars[b%chars.length]);
    const d=document.createElement('div');d.className='pw-entry';
    d.innerHTML=`<span style="word-break:break-all;position:relative;z-index:1">${pw}</span><button class="pw-copy-btn">COPY</button>`;
    d.querySelector('.pw-copy-btn').onclick=()=>copy(pw);$('p-list').appendChild(d);
  }
  $('p-res').style.display='block';toast('Generiert! 🔐');
};
</script>
</body>
</html>