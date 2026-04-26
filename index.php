<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// --- Role-aware redirect for logged-in users ---
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':   header('Location: pages/dashboard.php'); exit;
        case 'student': header('Location: pages/dashboard.php'); exit;
        case 'company': header('Location: pages/dashboard.php'); exit;
    }
}

// --- Live Stats ---
$stats = ['total_students' => 0, 'total_companies' => 0, 'total_internships' => 0, 'total_placements' => 0];
$internships = [];
try {
    $pdo = getDB();
    $row = $pdo->query("
        SELECT
            (SELECT COUNT(*) FROM students) AS total_students,
            (SELECT COUNT(*) FROM companies WHERE verified=1) AS total_companies,
            (SELECT COUNT(*) FROM internships) AS total_internships,
            (SELECT COUNT(*) FROM placements) AS total_placements
    ")->fetch();
    if ($row) $stats = $row;

    $stmt = $pdo->query("
        SELECT i.internship_id, i.title, c.city, i.stipend, i.domain,
               i.duration_months, i.start_date, i.end_date, i.slots,
               c.company_name, i.status
        FROM internships i
        JOIN companies c ON i.company_id = c.company_id
        WHERE i.status = 'open' AND c.verified = 1
        ORDER BY i.start_date DESC
        LIMIT 6
    ");
    $internships = $stmt->fetchAll();
} catch (PDOException $e) {
    // Graceful fallback — page renders with zeros
}

$browseHref = isset($_SESSION['user_id']) ? 'pages/internships.php' : 'auth/login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternBridge PK — Find Your Internship</title>
    <meta name="description" content="InternBridge PK connects Pakistani students with verified companies for internship opportunities across Karachi, Lahore, Islamabad and beyond.">
    <link rel="stylesheet" href="assets/css/design-system.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/landing.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="ib-landing">

<!-- ═══ SHADER CANVAS ═══ -->
<canvas id="ib-shader-canvas" aria-hidden="true"></canvas>

<!-- ═══ NAVBAR ═══ -->
<nav id="ib-nav" class="ib-nav">
    <div class="ib-nav__inner">
        <a href="index.php" class="ib-nav__logo">
            <span class="ib-logo-icon"><i data-lucide="graduation-cap"></i></span>
            <span class="ib-logo-text">InternBridge <em>PK</em></span>
        </a>
        <ul class="ib-nav__links" id="ib-nav-links">
            <li><a href="#hero" class="ib-nav__link">Home</a></li>
            <li><a href="#how-it-works" class="ib-nav__link">How It Works</a></li>
            <li><a href="#internships" class="ib-nav__link">Browse</a></li>
            <li><a href="#about" class="ib-nav__link">About</a></li>
            <span class="ib-nav__pill" id="ib-nav-pill"></span>
        </ul>
        <div class="ib-nav__cta">
            <a href="auth/login.php" class="btn btn-ghost">Login</a>
            <a href="auth/login.php" class="btn btn-primary">Register</a>
        </div>
        <button class="ib-nav__hamburger" id="ib-hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- ═══ HERO ═══ -->
<section id="hero" class="ib-hero">
    <div class="ib-hero__content ib-reveal">
        <div class="ib-hero__badge">
            <i data-lucide="flag" style="width:16px;height:16px"></i>
            For Pakistani Students & Companies
        </div>
        <h1 class="ib-hero__title">
            Find Your <span class="ib-gradient-text">First Step</span><br>
            Toward a Career
        </h1>
        <p class="ib-hero__sub">
            InternBridge PK connects talented Pakistani students with verified
            companies across Karachi, Lahore, Islamabad, Peshawar and beyond.
        </p>
        <div class="ib-hero__actions">
            <a href="auth/login.php" class="btn btn-primary btn-lg">
                <i data-lucide="graduation-cap" style="width:18px;height:18px"></i> I'm a Student
            </a>
            <a href="auth/login.php" class="btn btn-outline btn-lg">
                <i data-lucide="building-2" style="width:18px;height:18px"></i> I'm a Company
            </a>
        </div>
    </div>
    <div class="ib-hero__deco" aria-hidden="true">
        <div class="ib-deco__ring ib-deco__ring--1"></div>
        <div class="ib-deco__ring ib-deco__ring--2"></div>
        <div class="ib-deco__ring ib-deco__ring--3"></div>
        <div class="ib-deco__orb"></div>
    </div>
</section>

<!-- ═══ STATS ═══ -->
<section class="ib-stats ib-reveal">
    <div class="ib-stats__grid">
        <div class="ib-stat" data-target="<?= (int)$stats['total_internships'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Internships Posted</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_students'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Students Registered</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_companies'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Verified Companies</span>
        </div>
        <div class="ib-stat" data-target="<?= (int)$stats['total_placements'] ?>">
            <span class="ib-stat__number">0</span>
            <span class="ib-stat__label">Successful Placements</span>
        </div>
    </div>
</section>

<!-- ═══ HOW IT WORKS ═══ -->
<section id="how-it-works" class="ib-section">
    <h2 class="ib-section__title ib-reveal">How It Works</h2>
    <div class="ib-hiw__tracks">
        <div class="ib-hiw__track ib-reveal">
            <h3 class="ib-hiw__track-title"><i data-lucide="graduation-cap"></i> For Students</h3>
            <div class="ib-hiw__steps">
                <div class="ib-step"><div class="ib-step__num">1</div><div class="ib-step__text"><h4>Register Free</h4><p>Create your account in under a minute</p></div></div>
                <div class="ib-step"><div class="ib-step__num">2</div><div class="ib-step__text"><h4>Build Your Profile</h4><p>Add your education, skills, and upload CV</p></div></div>
                <div class="ib-step"><div class="ib-step__num">3</div><div class="ib-step__text"><h4>Browse Internships</h4><p>Filter by city, field, and stipend range</p></div></div>
                <div class="ib-step"><div class="ib-step__num">4</div><div class="ib-step__text"><h4>Apply with Cover Letter</h4><p>Stand out with a personalized application</p></div></div>
                <div class="ib-step"><div class="ib-step__num">5</div><div class="ib-step__text"><h4>Get Placed</h4><p>Land your first internship and start your career</p></div></div>
            </div>
        </div>
        <div class="ib-hiw__track ib-reveal">
            <h3 class="ib-hiw__track-title"><i data-lucide="building-2"></i> For Companies</h3>
            <div class="ib-hiw__steps">
                <div class="ib-step"><div class="ib-step__num">1</div><div class="ib-step__text"><h4>Register Company</h4><p>Set up your company profile with details</p></div></div>
                <div class="ib-step"><div class="ib-step__num">2</div><div class="ib-step__text"><h4>Get Admin Verified</h4><p>Our team verifies your company identity</p></div></div>
                <div class="ib-step"><div class="ib-step__num">3</div><div class="ib-step__text"><h4>Post Listings</h4><p>Create internship opportunities in minutes</p></div></div>
                <div class="ib-step"><div class="ib-step__num">4</div><div class="ib-step__text"><h4>Review Applicants</h4><p>Shortlist and manage candidates easily</p></div></div>
                <div class="ib-step"><div class="ib-step__num">5</div><div class="ib-step__text"><h4>Place Talent</h4><p>Accept and onboard the right interns</p></div></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ INTERNSHIP PREVIEW ═══ -->
<section id="internships" class="ib-section">
    <div class="ib-section__header ib-reveal">
        <h2 class="ib-section__title" style="margin-bottom:0;text-align:left">Latest Open Internships</h2>
        <a href="<?= htmlspecialchars($browseHref) ?>" class="btn btn-outline">View All <i data-lucide="arrow-right" style="width:16px;height:16px"></i></a>
    </div>
    <div class="ib-cards__grid">
        <?php foreach ($internships as $i): ?>
        <div class="ib-icard ib-reveal">
            <div class="ib-icard__top">
                <div class="ib-icard__company">
                    <div class="ib-icard__logo-placeholder"><?= strtoupper(substr($i['company_name'],0,1)) ?></div>
                    <span class="ib-icard__company-name"><?= htmlspecialchars($i['company_name']) ?></span>
                </div>
                <div class="ib-icard__badges">
                    <?php if ($i['stipend'] > 0): ?>
                        <span class="badge badge-green"><i data-lucide="banknote" style="width:12px;height:12px"></i> Paid</span>
                    <?php else: ?>
                        <span class="badge badge-gray">Unpaid</span>
                    <?php endif; ?>
                </div>
            </div>
            <h4 class="ib-icard__title"><?= htmlspecialchars($i['title']) ?></h4>
            <div class="ib-icard__meta">
                <span><i data-lucide="map-pin" style="width:14px;height:14px"></i> <?= htmlspecialchars($i['city']) ?></span>
                <span><i data-lucide="clock" style="width:14px;height:14px"></i> <?= (int)$i['duration_months'] ?> months</span>
            </div>
            <?php if ($i['stipend'] > 0): ?>
                <div class="ib-icard__stipend">PKR <?= number_format($i['stipend']) ?>/month</div>
            <?php endif; ?>
            <div class="ib-icard__footer">
                <span class="ib-icard__deadline">Start: <?= date('d M Y', strtotime($i['start_date'])) ?></span>
                <a href="<?= htmlspecialchars($browseHref) ?>" class="btn btn-primary btn-sm">Apply <i data-lucide="arrow-right" style="width:14px;height:14px"></i></a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($internships)): ?>
            <p class="ib-empty">No open internships right now. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══ FEATURES ═══ -->
<section id="about" class="ib-section">
    <h2 class="ib-section__title ib-reveal">Why InternBridge?</h2>
    <div class="ib-features__grid">
        <div class="ib-features__col ib-reveal">
            <h3><i data-lucide="graduation-cap"></i> For Students</h3>
            <ul>
                <li><i data-lucide="search"></i> Browse internships filtered by city, field, and stipend</li>
                <li><i data-lucide="file-text"></i> Apply with a cover letter and upload your CV</li>
                <li><i data-lucide="bar-chart-3"></i> Track all your applications in one dashboard</li>
                <li><i data-lucide="star"></i> Rate companies after your internship ends</li>
                <li><i data-lucide="bell"></i> Get notified when your status changes</li>
            </ul>
            <a href="auth/login.php" class="btn btn-primary">Get Started Free</a>
        </div>
        <div class="ib-features__col ib-reveal">
            <h3><i data-lucide="building-2"></i> For Companies</h3>
            <ul>
                <li><i data-lucide="megaphone"></i> Post internship listings in minutes</li>
                <li><i data-lucide="users"></i> Manage and shortlist applicants easily</li>
                <li><i data-lucide="shield-check"></i> Build trust with admin-verified badges</li>
                <li><i data-lucide="trending-up"></i> Track your open positions and placements</li>
                <li><i data-lucide="bell"></i> Get notified when students apply</li>
            </ul>
            <a href="auth/login.php" class="btn btn-outline">Register Company</a>
        </div>
    </div>
</section>

<!-- ═══ MARQUEE ═══ -->
<section class="ib-marquee-section">
    <p class="ib-marquee__label">Students from top universities</p>
    <div class="ib-marquee">
        <div class="ib-marquee__track">
            <span>FAST-NUCES</span><span>NUST</span><span>UET Lahore</span>
            <span>COMSATS</span><span>IBA Karachi</span><span>GIKI</span>
            <span>QAU</span><span>University of Peshawar</span>
            <span>LUMS</span><span>Air University</span>
            <span>NED University</span><span>ITU Lahore</span>
            <span>FAST-NUCES</span><span>NUST</span><span>UET Lahore</span>
            <span>COMSATS</span><span>IBA Karachi</span><span>GIKI</span>
            <span>QAU</span><span>University of Peshawar</span>
            <span>LUMS</span><span>Air University</span>
            <span>NED University</span><span>ITU Lahore</span>
        </div>
    </div>
</section>

<!-- ═══ TESTIMONIALS ═══ -->
<section class="ib-section">
    <h2 class="ib-section__title ib-reveal">What Our Users Say</h2>
    <div class="ib-testi__grid">
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"InternBridge helped me land my first internship at a Karachi-based fintech in just 2 weeks. The process was incredibly smooth."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">AK</div>
                <div><strong>Ayesha Khan</strong><span>CS Student, FAST Karachi</span></div>
            </div>
        </div>
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"We hired 3 interns through InternBridge last quarter. The verified student profiles saved us so much screening time."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">MR</div>
                <div><strong>M. Raza</strong><span>HR Manager, TechVentures Lahore</span></div>
            </div>
        </div>
        <div class="ib-testi__card ib-reveal">
            <p class="ib-testi__quote">"The platform is simple and clean. I applied to 5 companies and tracked every application status in one place."</p>
            <div class="ib-testi__author">
                <div class="ib-testi__avatar">UB</div>
                <div><strong>Usman Baig</strong><span>Software Intern, Islamabad</span></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="ib-footer">
    <div class="ib-footer__inner">
        <div class="ib-footer__brand">
            <span class="ib-logo-text">InternBridge <em>PK</em></span>
            <p>Connecting Pakistani talent with opportunity. We bridge the gap between education and industry across all major cities.</p>
        </div>
        <div class="ib-footer__links">
            <h4>Platform</h4>
            <a href="auth/login.php">Login</a>
            <a href="auth/login.php">Student Register</a>
            <a href="auth/login.php">Company Register</a>
            <a href="pages/dashboard.php">Admin Panel</a>
        </div>
        <div class="ib-footer__cities">
            <h4>Cities We Serve</h4>
            <p>Karachi · Lahore · Islamabad · Peshawar · Quetta · Multan · Faisalabad · Hyderabad</p>
        </div>
    </div>
    <div class="ib-footer__bottom">
        &copy; <?= date('Y') ?> InternBridge PK. Built for Pakistani Students.
    </div>
</footer>

<!-- ═══ INLINE SCRIPTS ═══ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (window.lucide) lucide.createIcons();

    /* ─── 1. THREE.JS CYBERNETIC GRID SHADER ─── */
    (function() {
        var canvas = document.getElementById('ib-shader-canvas');
        if (!canvas || typeof THREE === 'undefined') return;

        var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        var camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
        var scene = new THREE.Scene();
        var clock = new THREE.Clock();

        var uniforms = {
            iTime:        { value: 0.0 },
            iResolution:  { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
            iMouse:       { value: new THREE.Vector2(window.innerWidth / 2, window.innerHeight / 2) },
            iMouseActive: { value: 0.0 }
        };

        /* --- Color extraction from CSS vars --- */
        function cssColorToGLSL(varName) {
            var raw = getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
            if (raw.startsWith('#')) {
                var hex = raw.replace('#','');
                var full = hex.length === 3 ? hex.split('').map(function(c){return c+c}).join('') : hex;
                return [parseInt(full.slice(0,2),16)/255, parseInt(full.slice(2,4),16)/255, parseInt(full.slice(4,6),16)/255];
            }
            var m = raw.match(/[\d.]+/g);
            if (m && m.length >= 3) return [parseFloat(m[0])/255, parseFloat(m[1])/255, parseFloat(m[2])/255];
            return varName.includes('success') ? [0.0, 0.784, 0.588] : [0.239, 0.353, 0.996];
        }
        var primary = cssColorToGLSL('--accent-primary');
        var accent  = cssColorToGLSL('--accent-success');
        var pR = primary[0].toFixed(4), pG = primary[1].toFixed(4), pB = primary[2].toFixed(4);
        var aR = accent[0].toFixed(4),  aG = accent[1].toFixed(4),  aB = accent[2].toFixed(4);

        var vertexShader = 'void main(){gl_Position=vec4(position,1.0);}';

        var fragmentShader = [
            'precision highp float;',
            'uniform vec2 iResolution;',
            'uniform float iTime;',
            'uniform vec2 iMouse;',
            'uniform float iMouseActive;',
            '',
            'float random(vec2 st){return fract(sin(dot(st,vec2(12.9898,78.233)))*43758.5453123);}',
            'float noise(vec2 st){',
            '  vec2 i=floor(st);vec2 f=fract(st);vec2 u=f*f*(3.0-2.0*f);',
            '  return mix(mix(random(i),random(i+vec2(1.0,0.0)),u.x),mix(random(i+vec2(0.0,1.0)),random(i+vec2(1.0,1.0)),u.x),u.y);',
            '}',
            'float gridLines(vec2 uv,float cellSize,float lineWidth){',
            '  vec2 g=fract(uv*cellSize);vec2 dg=min(g,1.0-g);',
            '  return 1.0-smoothstep(0.0,lineWidth,min(dg.x,dg.y));',
            '}',
            '',
            'void main(){',
            '  vec2 uv=(gl_FragCoord.xy-0.5*iResolution.xy)/iResolution.y;',
            '  vec2 mouse=(iMouse-0.5*iResolution.xy)/iResolution.y;',
            '  float t=iTime*0.25;',
            '  float mouseDist=length(uv-mouse);',
            '',
            '  // Ripple warp from cursor',
            '  float ripplePhase=mouseDist*28.0-iTime*5.0;',
            '  float ripple=sin(ripplePhase)*0.055;',
            '  ripple*=smoothstep(0.55,0.0,mouseDist)*iMouseActive;',
            '  uv+=normalize(uv-mouse+0.0001)*ripple;',
            '',
            '  // Breathing distortion',
            '  uv+=sin(uv.x*3.0+t)*cos(uv.y*3.0+t*0.7)*0.012;',
            '',
            '  // Dual-layer grid',
            '  float mainGrid=gridLines(uv,10.0,0.035);',
            '  float fineGrid=gridLines(uv,40.0,0.018)*0.3;',
            '  float grid=max(mainGrid,fineGrid);',
            '',
            '  // Energy pulses along grid',
            '  float energy=sin(uv.x*20.0+iTime*4.0)*sin(uv.y*20.0+iTime*2.8);',
            '  energy=smoothstep(0.72,1.0,energy)*grid;',
            '',
            '  // Mouse proximity glow',
            '  float proximity=1.0-smoothstep(0.0,0.22,mouseDist);',
            '  float proximityGlow=proximity*grid*iMouseActive;',
            '  float cursorCore=smoothstep(0.04,0.0,mouseDist)*iMouseActive;',
            '',
            '  // Scan-line shimmer',
            '  float scan=sin(uv.y*iResolution.y*0.5-iTime*60.0)*0.5+0.5;',
            '  scan=pow(scan,80.0)*0.18*grid;',
            '',
            '  // Noise grain',
            '  float grain=noise((uv+t*0.08)*60.0)*0.06*grid;',
            '',
            '  // Color assembly',
            '  vec3 primaryColor=vec3('+pR+','+pG+','+pB+');',
            '  vec3 accentColor=vec3('+aR+','+aG+','+aB+');',
            '  vec3 white=vec3(1.0);',
            '',
            '  float gridBrightness=0.4+sin(t*1.8)*0.18;',
            '  vec3 color=primaryColor*grid*gridBrightness;',
            '  color+=accentColor*energy*1.4;',
            '  color+=mix(primaryColor,white,proximity*0.6)*proximityGlow*1.8;',
            '  color+=white*cursorCore*0.9;',
            '  color+=primaryColor*scan;',
            '  color+=grain;',
            '',
            '  // Vignette',
            '  float vignette=1.0-smoothstep(0.5,1.4,length(',
            '    (gl_FragCoord.xy/iResolution.xy-0.5)*vec2(iResolution.x/iResolution.y,1.0)',
            '  ));',
            '  color*=0.6+vignette*0.4;',
            '  color=clamp(color,0.0,0.92);',
            '',
            '  gl_FragColor=vec4(color,1.0);',
            '}'
        ].join('\n');

        var material = new THREE.ShaderMaterial({
            uniforms: uniforms,
            vertexShader: vertexShader,
            fragmentShader: fragmentShader
        });
        var mesh = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
        scene.add(mesh);

        /* --- Event handlers --- */
        function onResize() {
            var W = window.innerWidth, H = window.innerHeight;
            renderer.setSize(W, H);
            uniforms.iResolution.value.set(W, H);
        }
        window.addEventListener('resize', onResize);
        onResize();

        var mouseActivated = false;
        window.addEventListener('mousemove', function(e) {
            uniforms.iMouse.value.set(e.clientX, window.innerHeight - e.clientY);
            if (!mouseActivated) {
                mouseActivated = true;
                var start = null;
                function fadeIn(ts) {
                    if (!start) start = ts;
                    uniforms.iMouseActive.value = Math.min((ts - start) / 800, 1.0);
                    if (uniforms.iMouseActive.value < 1.0) requestAnimationFrame(fadeIn);
                }
                requestAnimationFrame(fadeIn);
            }
        });

        window.addEventListener('touchmove', function(e) {
            var touch = e.touches[0];
            uniforms.iMouse.value.set(touch.clientX, window.innerHeight - touch.clientY);
            if (!mouseActivated) {
                mouseActivated = true;
                uniforms.iMouseActive.value = 1.0;
            }
        }, { passive: true });

        /* --- Animation loop with visibility pause --- */
        function renderLoop() {
            uniforms.iTime.value = clock.getElapsedTime();
            renderer.render(scene, camera);
        }
        renderer.setAnimationLoop(renderLoop);

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                renderer.setAnimationLoop(null);
            } else {
                clock.start();
                renderer.setAnimationLoop(renderLoop);
            }
        });
    })();

    /* ─── 2. NAVBAR PILL + SCROLL ─── */
    (function() {
        var nav = document.getElementById('ib-nav');
        var pill = document.getElementById('ib-nav-pill');
        var linksUl = document.getElementById('ib-nav-links');
        if (!nav || !pill || !linksUl) return;

        var items = linksUl.querySelectorAll('li');
        items.forEach(function(li) {
            li.addEventListener('mouseenter', function() {
                var liRect = li.getBoundingClientRect();
                var ulRect = linksUl.getBoundingClientRect();
                var offsetLeft = liRect.left - ulRect.left;
                pill.style.left = offsetLeft + 'px';
                pill.style.width = liRect.width + 'px';
                pill.style.opacity = '1';
            });
        });
        linksUl.addEventListener('mouseleave', function() {
            pill.style.opacity = '0';
        });

        window.addEventListener('scroll', function() {
            nav.classList.toggle('ib-nav--scrolled', window.scrollY > 60);
        }, { passive: true });
    })();

    /* ─── 3. HAMBURGER ─── */
    (function() {
        var btn = document.getElementById('ib-hamburger');
        var links = document.getElementById('ib-nav-links');
        if (!btn || !links) return;
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            links.classList.toggle('open');
            btn.classList.toggle('active');
        });
        document.addEventListener('click', function(e) {
            if (!links.contains(e.target) && !btn.contains(e.target)) {
                links.classList.remove('open');
                btn.classList.remove('active');
            }
        });
    })();

    /* ─── 4. COUNTUP ─── */
    (function() {
        var statsEl = document.querySelector('.ib-stats');
        if (!statsEl) return;
        var animated = false;

        function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

        function animateCountUp() {
            if (animated) return;
            animated = true;
            var els = statsEl.querySelectorAll('[data-target]');
            els.forEach(function(el) {
                var target = parseInt(el.getAttribute('data-target'), 10) || 0;
                var numEl = el.querySelector('.ib-stat__number');
                var start = performance.now();
                var duration = 2000;
                (function tick(now) {
                    var progress = Math.min((now - start) / duration, 1);
                    numEl.textContent = Math.round(easeOutQuart(progress) * target);
                    if (progress < 1) requestAnimationFrame(tick);
                })(start);
            });
        }

        var obs = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting) animateCountUp();
        }, { threshold: 0.3 });
        obs.observe(statsEl);
    })();

    /* ─── 5. SCROLL REVEAL ─── */
    (function() {
        var reveals = document.querySelectorAll('.ib-reveal');
        if (!reveals.length) return;
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('ib-reveal--visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(function(el) { obs.observe(el); });
    })();
});
</script>
</body>
</html>
